<?php

class Resident
{
    private $conn;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    /*
     * Create resident
     */
    public function create(
        $societyId,
        $userId,
        $name,
        $email,
        $phone,
        $flatNumber,
        $tower,
        $residentType
    ) {
        $query = $this->conn->prepare(
            "INSERT INTO residents
            (
                society_id,
                user_id,
                name,
                email,
                phone,
                flat_number,
                tower,
                resident_type
            )
            VALUES
            (?, ?, ?, ?, ?, ?, ?, ?)"
        );

        return $query->execute([
            $societyId,
            $userId,
            $name,
            $email,
            $phone,
            $flatNumber,
            $tower,
            $residentType
        ]);
    }


    /*
     * Get all residents of a society
     */
    public function getAll($societyId)
    {
        $query = $this->conn->prepare(
            "SELECT *
             FROM residents
             WHERE society_id = ?
             ORDER BY id DESC"
        );

        $query->execute([
            $societyId
        ]);

        return $query->fetchAll(PDO::FETCH_ASSOC);
    }


    /*
     * Get one resident
     */
    public function getById($id, $societyId)
    {
        $query = $this->conn->prepare(
            "SELECT *
             FROM residents
             WHERE id = ?
             AND society_id = ?
             LIMIT 1"
        );

        $query->execute([
            $id,
            $societyId
        ]);

        return $query->fetch(PDO::FETCH_ASSOC);
    }


    /*
     * Delete complaints belonging to resident
     */
    private function deleteComplaints($residentId)
    {
        $query = $this->conn->prepare(
            "DELETE FROM complaints
             WHERE resident_id = ?"
        );

        $query->execute([
            $residentId
        ]);

        return $query->rowCount();
    }


    /*
     * Delete maintenance bills belonging to resident
     */
    private function deleteMaintenanceBills($residentId)
    {
        $query = $this->conn->prepare(
            "DELETE FROM maintenance_bills
             WHERE resident_id = ?"
        );

        $query->execute([
            $residentId
        ]);

        return $query->rowCount();
    }


    /*
     * Delete payments belonging to resident's user account
     *
     * Currently payments may be empty because resident
     * payment functionality has not been implemented yet.
     */
    private function deletePayments($userId)
    {
        if (empty($userId)) {
            return 0;
        }

        $query = $this->conn->prepare(
            "DELETE FROM payments
             WHERE user_id = ?"
        );

        $query->execute([
            $userId
        ]);

        return $query->rowCount();
    }


    /*
     * Delete registered devices belonging to user
     */
    private function deleteUserDevices($userId)
    {
        if (empty($userId)) {
            return 0;
        }

        $query = $this->conn->prepare(
            "DELETE FROM user_devices
             WHERE user_id = ?"
        );

        $query->execute([
            $userId
        ]);

        return $query->rowCount();
    }


    /*
     * Delete resident + all currently related records
     *
     * Everything is handled inside ONE transaction.
     *
     * If ANY operation fails:
     * - resident remains
     * - user remains
     * - complaints remain
     * - bills remain
     * - payments remain
     * - devices remain
     *
     * Nothing is partially deleted.
     */
    public function deleteComplete($id, $societyId)
    {
        try {

            /*
             * Start transaction
             */
            $this->conn->beginTransaction();


            /*
             * -----------------------------------------------------
             * 1. Find resident and associated user
             * -----------------------------------------------------
             */

            $query = $this->conn->prepare(
                "SELECT
                    id,
                    user_id,
                    society_id
                 FROM residents
                 WHERE id = ?
                 AND society_id = ?
                 LIMIT 1"
            );

            $query->execute([
                $id,
                $societyId
            ]);

            $resident = $query->fetch(PDO::FETCH_ASSOC);

            if (!$resident) {

                $this->conn->rollBack();

                return [
                    "success" => false,
                    "message" => "Resident not found"
                ];
            }


            $residentId = (int) $resident['id'];
            $userId = $resident['user_id'];


            /*
             * -----------------------------------------------------
             * 2. Delete complaints
             * -----------------------------------------------------
             */

            $deletedComplaints =
                $this->deleteComplaints($residentId);


            /*
             * -----------------------------------------------------
             * 3. Delete maintenance bills
             * -----------------------------------------------------
             */

            $deletedBills =
                $this->deleteMaintenanceBills($residentId);


            /*
             * -----------------------------------------------------
             * 4. Delete payments
             * -----------------------------------------------------
             */

            $deletedPayments =
                $this->deletePayments($userId);


            /*
             * -----------------------------------------------------
             * 5. Delete registered devices
             * -----------------------------------------------------
             */

            $deletedDevices =
                $this->deleteUserDevices($userId);


            /*
             * -----------------------------------------------------
             * 6. Delete resident record
             * -----------------------------------------------------
             */

            $query = $this->conn->prepare(
                "DELETE FROM residents
                 WHERE id = ?
                 AND society_id = ?"
            );

            $query->execute([
                $residentId,
                $societyId
            ]);

            $deletedResident = $query->rowCount();

            if ($deletedResident !== 1) {

                throw new Exception(
                    "Resident could not be deleted"
                );
            }


            /*
             * -----------------------------------------------------
             * 7. Delete associated user account
             * -----------------------------------------------------
             */

            $deletedUser = 0;

            if (!empty($userId)) {

                $query = $this->conn->prepare(
                    "DELETE FROM users
                     WHERE id = ?
                     AND society_id = ?"
                );

                $query->execute([
                    $userId,
                    $societyId
                ]);

                $deletedUser = $query->rowCount();

                /*
                 * The resident should normally always have
                 * an associated user account.
                 *
                 * If it doesn't, treat it as an error so we
                 * don't leave an incomplete account state.
                 */
                if ($deletedUser !== 1) {

                    throw new Exception(
                        "Associated user account could not be deleted"
                    );
                }
            }


            /*
             * -----------------------------------------------------
             * 8. Commit transaction
             * -----------------------------------------------------
             */

            $this->conn->commit();


            /*
             * -----------------------------------------------------
             * 9. Return useful deletion information
             * -----------------------------------------------------
             */

            return [
                "success" => true,
                "message" =>
                    "Resident and all related records deleted successfully",

                "resident_id" => $residentId,
                "user_id" => $userId,

                "deleted" => [
                    "complaints" => $deletedComplaints,
                    "maintenance_bills" => $deletedBills,
                    "payments" => $deletedPayments,
                    "user_devices" => $deletedDevices,
                    "resident" => $deletedResident,
                    "user" => $deletedUser
                ]
            ];


        } catch (Exception $e) {

            /*
             * -----------------------------------------------------
             * Roll back EVERYTHING if anything fails
             * -----------------------------------------------------
             */

            if ($this->conn->inTransaction()) {
                $this->conn->rollBack();
            }

            return [
                "success" => false,
                "message" => $e->getMessage()
            ];
        }
    }
}
