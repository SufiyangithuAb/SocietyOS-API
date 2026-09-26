<?php

require_once "../config/database.php";

try {

    $database = new Database();
    $db = $database->connect();

    // Test resident
    $residentId = 61;
    $userId = 26;
    $societyId = 7;

    // Start transaction
    $db->beginTransaction();

    /*
     * Delete records belonging to the resident.
     * Delete child records BEFORE resident/user records.
     */

    // Complaints
    $stmt = $db->prepare("
        DELETE FROM complaints
        WHERE resident_id = ?
    ");
    $stmt->execute([$residentId]);

    $complaintsDeleted = $stmt->rowCount();

    // Maintenance bills
    $stmt = $db->prepare("
        DELETE FROM maintenance_bills
        WHERE resident_id = ?
    ");
    $stmt->execute([$residentId]);

    $billsDeleted = $stmt->rowCount();

    // Payments belong to the user's account
    $stmt = $db->prepare("
        DELETE FROM payments
        WHERE user_id = ?
    ");
    $stmt->execute([$userId]);

    $paymentsDeleted = $stmt->rowCount();

    // Registered devices
    $stmt = $db->prepare("
        DELETE FROM user_devices
        WHERE user_id = ?
    ");
    $stmt->execute([$userId]);

    $devicesDeleted = $stmt->rowCount();

    // Delete resident
    $stmt = $db->prepare("
        DELETE FROM residents
        WHERE id = ?
        AND user_id = ?
        AND society_id = ?
    ");
    $stmt->execute([
        $residentId,
        $userId,
        $societyId
    ]);

    $residentsDeleted = $stmt->rowCount();

    // Delete user account
    $stmt = $db->prepare("
        DELETE FROM users
        WHERE id = ?
        AND society_id = ?
    ");
    $stmt->execute([
        $userId,
        $societyId
    ]);

    $usersDeleted = $stmt->rowCount();

    /*
     * If everything reached this point,
     * commit the transaction.
     */
    $db->commit();

    echo "<h2>Resident deletion test completed successfully.</h2>";

    echo "<p>Resident ID: {$residentId}</p>";
    echo "<p>User ID: {$userId}</p>";
    echo "<p>Society ID: {$societyId}</p>";

    echo "<hr>";

    echo "<p>Complaints deleted: {$complaintsDeleted}</p>";
    echo "<p>Maintenance bills deleted: {$billsDeleted}</p>";
    echo "<p>Payments deleted: {$paymentsDeleted}</p>";
    echo "<p>Devices deleted: {$devicesDeleted}</p>";
    echo "<p>Resident deleted: {$residentsDeleted}</p>";
    echo "<p>User deleted: {$usersDeleted}</p>";

    echo "<hr>";
    echo "<strong>Transaction committed.</strong>";

} catch (Exception $e) {

    // Roll back EVERYTHING if anything fails
    if (isset($db) && $db->inTransaction()) {
        $db->rollBack();
    }

    echo "<h2>Deletion failed.</h2>";
    echo "<p>Transaction rolled back.</p>";
    echo "<p>Error: " . htmlspecialchars($e->getMessage()) . "</p>";
}
