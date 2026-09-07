<?php

require_once "../config/database.php";

try {

    $database = new Database();
    $db = $database->connect();

    $db->exec("SET FOREIGN_KEY_CHECKS = 0;");

    $sql = <<<'SQL'

    /* KEEP ALL YOUR CURRENT SQL HERE */

    -- SocietyOS Database Backup
-- Generated : 2026-08-02 20:05:11


DROP TABLE IF EXISTS `complaints`;
CREATE TABLE `complaints` (
  `id` int NOT NULL AUTO_INCREMENT,
  `society_id` int NOT NULL,
  `resident_id` int DEFAULT NULL,
  `title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci,
  `category` enum('PLUMBING','ELECTRICAL','SECURITY','CLEANING','PARKING','OTHER') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT 'OTHER',
  `status` enum('OPEN','ASSIGNED','IN_PROGRESS','RESOLVED','CLOSED') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT 'OPEN',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `society_id` (`society_id`),
  KEY `resident_id` (`resident_id`),
  CONSTRAINT `complaints_ibfk_1` FOREIGN KEY (`society_id`) REFERENCES `societies` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=44 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `complaints` (`id`,`society_id`,`resident_id`,`title`,`description`,`category`,`status`,`created_at`) VALUES ('19','7',NULL,'Testing 1','This is testing 1.','PLUMBING','OPEN','2026-07-09 06:35:18');
INSERT INTO `complaints` (`id`,`society_id`,`resident_id`,`title`,`description`,`category`,`status`,`created_at`) VALUES ('20','7',NULL,'Testing 2','This is testing 2.','ELECTRICAL','OPEN','2026-07-09 06:35:41');
INSERT INTO `complaints` (`id`,`society_id`,`resident_id`,`title`,`description`,`category`,`status`,`created_at`) VALUES ('21','7',NULL,'Tester 3','This is testing 3.','SECURITY','OPEN','2026-07-09 06:36:23');
INSERT INTO `complaints` (`id`,`society_id`,`resident_id`,`title`,`description`,`category`,`status`,`created_at`) VALUES ('22','7',NULL,'Testing 4','This is testing 5.','OTHER','OPEN','2026-07-09 06:36:51');
INSERT INTO `complaints` (`id`,`society_id`,`resident_id`,`title`,`description`,`category`,`status`,`created_at`) VALUES ('23','7',NULL,'Testing 6','This is testing 6.','PARKING','RESOLVED','2026-07-09 06:37:16');
INSERT INTO `complaints` (`id`,`society_id`,`resident_id`,`title`,`description`,`category`,`status`,`created_at`) VALUES ('24','7','52','Water leakeged','Water is leaking from tiles.','ELECTRICAL','OPEN','2026-07-09 06:47:37');
INSERT INTO `complaints` (`id`,`society_id`,`resident_id`,`title`,`description`,`category`,`status`,`created_at`) VALUES ('25','7','52','Water leakeged','Water is leaking from tiles.','ELECTRICAL','CLOSED','2026-07-09 06:47:40');
INSERT INTO `complaints` (`id`,`society_id`,`resident_id`,`title`,`description`,`category`,`status`,`created_at`) VALUES ('26','7','52','Water leakeged','Water is leaking from tiles.','PLUMBING','OPEN','2026-07-09 06:50:11');
INSERT INTO `complaints` (`id`,`society_id`,`resident_id`,`title`,`description`,`category`,`status`,`created_at`) VALUES ('27','7','52','Water leakeged','Water is leaking from tiles.','PARKING','ASSIGNED','2026-07-09 06:50:30');
INSERT INTO `complaints` (`id`,`society_id`,`resident_id`,`title`,`description`,`category`,`status`,`created_at`) VALUES ('28','7','52','Water leakeged','Water is leaking from tiles.','SECURITY','OPEN','2026-07-09 06:50:49');
INSERT INTO `complaints` (`id`,`society_id`,`resident_id`,`title`,`description`,`category`,`status`,`created_at`) VALUES ('29','7','52','Water leakeged','Water is leaking from tiles.','CLEANING','OPEN','2026-07-09 06:51:03');
INSERT INTO `complaints` (`id`,`society_id`,`resident_id`,`title`,`description`,`category`,`status`,`created_at`) VALUES ('30','7','52','Water leakeged','Water is leaking from tiles.','PLUMBING','IN_PROGRESS','2026-07-09 06:57:40');
INSERT INTO `complaints` (`id`,`society_id`,`resident_id`,`title`,`description`,`category`,`status`,`created_at`) VALUES ('31','7','52','Water leakeged','Water is leaking from tiles.','PLUMBING','IN_PROGRESS','2026-07-09 07:00:14');
INSERT INTO `complaints` (`id`,`society_id`,`resident_id`,`title`,`description`,`category`,`status`,`created_at`) VALUES ('32','7',NULL,'Water Leakage','Today our society water pipeline is breaked at main road so the work is going on please be co-orporate','PLUMBING','OPEN','2026-07-23 19:57:08');
INSERT INTO `complaints` (`id`,`society_id`,`resident_id`,`title`,`description`,`category`,`status`,`created_at`) VALUES ('33','7','59','Testing complaints','This is testing complaint.','PLUMBING','RESOLVED','2026-07-24 19:59:25');
INSERT INTO `complaints` (`id`,`society_id`,`resident_id`,`title`,`description`,`category`,`status`,`created_at`) VALUES ('34','7','59','Testing complaint','This is the notification testing.','OTHER','RESOLVED','2026-07-24 20:15:20');
INSERT INTO `complaints` (`id`,`society_id`,`resident_id`,`title`,`description`,`category`,`status`,`created_at`) VALUES ('35','7','59','Notification testing','this is the notification testing','PLUMBING','RESOLVED','2026-07-24 20:19:50');
INSERT INTO `complaints` (`id`,`society_id`,`resident_id`,`title`,`description`,`category`,`status`,`created_at`) VALUES ('36','7','59','hii','hii','PLUMBING','RESOLVED','2026-07-24 20:23:10');
INSERT INTO `complaints` (`id`,`society_id`,`resident_id`,`title`,`description`,`category`,`status`,`created_at`) VALUES ('37','7','59','hiiiiiiiiii','iiihiiiiiiiiii','PLUMBING','RESOLVED','2026-07-24 20:26:55');
INSERT INTO `complaints` (`id`,`society_id`,`resident_id`,`title`,`description`,`category`,`status`,`created_at`) VALUES ('38','7','59','hhhhhhhhhhhhhh','hhhhhhhhhhhhhh','CLEANING','RESOLVED','2026-07-24 20:34:14');
INSERT INTO `complaints` (`id`,`society_id`,`resident_id`,`title`,`description`,`category`,`status`,`created_at`) VALUES ('39','10',NULL,'TEST','TEST','OTHER','OPEN','2026-07-28 19:23:24');
INSERT INTO `complaints` (`id`,`society_id`,`resident_id`,`title`,`description`,`category`,`status`,`created_at`) VALUES ('40','7','61','Testing','This is the testing complaint','ELECTRICAL','OPEN','2026-07-30 15:01:23');
INSERT INTO `complaints` (`id`,`society_id`,`resident_id`,`title`,`description`,`category`,`status`,`created_at`) VALUES ('41','7','61','new compalint','this is complaint','PARKING','OPEN','2026-07-30 15:06:56');
INSERT INTO `complaints` (`id`,`society_id`,`resident_id`,`title`,`description`,`category`,`status`,`created_at`) VALUES ('42','7','61','This is new complaint','this is new complaint','CLEANING','OPEN','2026-07-30 15:11:43');
INSERT INTO `complaints` (`id`,`society_id`,`resident_id`,`title`,`description`,`category`,`status`,`created_at`) VALUES ('43','7',NULL,'new complaint','this is new complaint','PLUMBING','OPEN','2026-07-30 15:13:23');



DROP TABLE IF EXISTS `maintenance_bills`;
CREATE TABLE `maintenance_bills` (
  `id` int NOT NULL AUTO_INCREMENT,
  `society_id` int NOT NULL,
  `resident_id` int NOT NULL,
  `bill_month` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `amount` decimal(10,2) NOT NULL,
  `due_date` date DEFAULT NULL,
  `status` enum('PAID','PENDING','OVERDUE') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT 'PENDING',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `society_id` (`society_id`),
  KEY `resident_id` (`resident_id`)
) ENGINE=InnoDB AUTO_INCREMENT=37 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `maintenance_bills` (`id`,`society_id`,`resident_id`,`bill_month`,`amount`,`due_date`,`status`,`created_at`) VALUES ('21','7','51','July','15000.00',NULL,'PAID','2026-07-08 21:36:48');
INSERT INTO `maintenance_bills` (`id`,`society_id`,`resident_id`,`bill_month`,`amount`,`due_date`,`status`,`created_at`) VALUES ('22','7','52','July','15000.00',NULL,'PAID','2026-07-09 06:39:17');
INSERT INTO `maintenance_bills` (`id`,`society_id`,`resident_id`,`bill_month`,`amount`,`due_date`,`status`,`created_at`) VALUES ('23','7','53','July','15000.00',NULL,'PAID','2026-07-09 06:39:30');
INSERT INTO `maintenance_bills` (`id`,`society_id`,`resident_id`,`bill_month`,`amount`,`due_date`,`status`,`created_at`) VALUES ('24','7','54','July','15000.00',NULL,'PAID','2026-07-09 06:39:44');
INSERT INTO `maintenance_bills` (`id`,`society_id`,`resident_id`,`bill_month`,`amount`,`due_date`,`status`,`created_at`) VALUES ('25','7','55','July','15000.00',NULL,'PENDING','2026-07-09 06:39:58');
INSERT INTO `maintenance_bills` (`id`,`society_id`,`resident_id`,`bill_month`,`amount`,`due_date`,`status`,`created_at`) VALUES ('26','7','56','July','15000.00',NULL,'PAID','2026-07-09 06:40:16');
INSERT INTO `maintenance_bills` (`id`,`society_id`,`resident_id`,`bill_month`,`amount`,`due_date`,`status`,`created_at`) VALUES ('27','7','56','igddwz','33850.00',NULL,'PAID','2026-07-09 11:45:14');
INSERT INTO `maintenance_bills` (`id`,`society_id`,`resident_id`,`bill_month`,`amount`,`due_date`,`status`,`created_at`) VALUES ('28','7','58','August 2026','15000.00',NULL,'PAID','2026-07-16 06:46:46');
INSERT INTO `maintenance_bills` (`id`,`society_id`,`resident_id`,`bill_month`,`amount`,`due_date`,`status`,`created_at`) VALUES ('29','7','58','July 2026','15000.00',NULL,'PAID','2026-07-16 06:48:29');
INSERT INTO `maintenance_bills` (`id`,`society_id`,`resident_id`,`bill_month`,`amount`,`due_date`,`status`,`created_at`) VALUES ('30','7','59','August 2026','15000.00',NULL,'PENDING','2026-07-23 19:53:07');
INSERT INTO `maintenance_bills` (`id`,`society_id`,`resident_id`,`bill_month`,`amount`,`due_date`,`status`,`created_at`) VALUES ('31','7','59','Sept 2026','15000.00',NULL,'PENDING','2026-07-24 16:58:50');
INSERT INTO `maintenance_bills` (`id`,`society_id`,`resident_id`,`bill_month`,`amount`,`due_date`,`status`,`created_at`) VALUES ('32','7','59','testbill','25000.00',NULL,'PENDING','2026-07-24 18:31:40');
INSERT INTO `maintenance_bills` (`id`,`society_id`,`resident_id`,`bill_month`,`amount`,`due_date`,`status`,`created_at`) VALUES ('33','7','59','testing 2026','56000.00',NULL,'PENDING','2026-07-24 19:05:57');
INSERT INTO `maintenance_bills` (`id`,`society_id`,`resident_id`,`bill_month`,`amount`,`due_date`,`status`,`created_at`) VALUES ('34','10','60','TESET','45445.00',NULL,'PAID','2026-07-28 19:23:47');
INSERT INTO `maintenance_bills` (`id`,`society_id`,`resident_id`,`bill_month`,`amount`,`due_date`,`status`,`created_at`) VALUES ('35','7','61','July 2027','25555.00',NULL,'PENDING','2026-07-30 15:05:19');
INSERT INTO `maintenance_bills` (`id`,`society_id`,`resident_id`,`bill_month`,`amount`,`due_date`,`status`,`created_at`) VALUES ('36','7','61','Oct 2026','15000.00',NULL,'PENDING','2026-07-30 15:06:01');



DROP TABLE IF EXISTS `notices`;
CREATE TABLE `notices` (
  `id` int NOT NULL AUTO_INCREMENT,
  `society_id` int NOT NULL,
  `title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci,
  `created_by` int NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `society_id` (`society_id`),
  KEY `created_by` (`created_by`)
) ENGINE=InnoDB AUTO_INCREMENT=28 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `notices` (`id`,`society_id`,`title`,`description`,`created_by`,`created_at`) VALUES ('13','7','Water Leakage','This is notice to notify residents that water pipeline is Leakage so make sure that water will comes tomorrow.','12','2026-07-08 21:36:22');
INSERT INTO `notices` (`id`,`society_id`,`title`,`description`,`created_by`,`created_at`) VALUES ('14','7','Testing 1','This is testing 1','12','2026-07-09 06:32:46');
INSERT INTO `notices` (`id`,`society_id`,`title`,`description`,`created_by`,`created_at`) VALUES ('22','7','Testing Notice','this is the testing notice.','12','2026-07-23 20:29:21');
INSERT INTO `notices` (`id`,`society_id`,`title`,`description`,`created_by`,`created_at`) VALUES ('23','7','Water Issuie','Water pipeline of our society is breaked at main road work is under process.','12','2026-07-23 20:32:07');
INSERT INTO `notices` (`id`,`society_id`,`title`,`description`,`created_by`,`created_at`) VALUES ('24','7','Testing Notice','This is the testing notice notification.','12','2026-07-24 17:09:32');
INSERT INTO `notices` (`id`,`society_id`,`title`,`description`,`created_by`,`created_at`) VALUES ('25','7','testing 2','this is testing 2','12','2026-07-24 17:46:07');
INSERT INTO `notices` (`id`,`society_id`,`title`,`description`,`created_by`,`created_at`) VALUES ('26','10','TEST','TEST','24','2026-07-28 19:23:10');
INSERT INTO `notices` (`id`,`society_id`,`title`,`description`,`created_by`,`created_at`) VALUES ('27','7','notice','this is notice','12','2026-07-30 15:09:04');



DROP TABLE IF EXISTS `payments`;
CREATE TABLE `payments` (
  `id` int NOT NULL AUTO_INCREMENT,
  `society_id` int NOT NULL,
  `user_id` int NOT NULL,
  `plan_name` varchar(100) NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `currency` varchar(10) NOT NULL DEFAULT 'INR',
  `razorpay_order_id` varchar(100) NOT NULL,
  `razorpay_payment_id` varchar(100) DEFAULT NULL,
  `razorpay_signature` text,
  `payment_method` varchar(50) DEFAULT NULL,
  `status` enum('CREATED','SUCCESS','FAILED','REFUNDED') DEFAULT 'CREATED',
  `paid_at` datetime DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `razorpay_order_id` (`razorpay_order_id`),
  KEY `fk_payment_society` (`society_id`),
  KEY `fk_payment_user` (`user_id`),
  CONSTRAINT `fk_payment_society` FOREIGN KEY (`society_id`) REFERENCES `societies` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk_payment_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=36 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

INSERT INTO `payments` (`id`,`society_id`,`user_id`,`plan_name`,`amount`,`currency`,`razorpay_order_id`,`razorpay_payment_id`,`razorpay_signature`,`payment_method`,`status`,`paid_at`,`created_at`,`updated_at`) VALUES ('1','7','12','PREMIUM','1999.00','INR','order_THsX92fJAb3Tch',NULL,NULL,NULL,'CREATED',NULL,'2026-07-25 21:09:01','2026-07-25 21:09:01');
INSERT INTO `payments` (`id`,`society_id`,`user_id`,`plan_name`,`amount`,`currency`,`razorpay_order_id`,`razorpay_payment_id`,`razorpay_signature`,`payment_method`,`status`,`paid_at`,`created_at`,`updated_at`) VALUES ('2','7','12','ENTERPRISE','4999.00','INR','order_THtkigyATN9c0i',NULL,NULL,NULL,'CREATED',NULL,'2026-07-25 22:20:34','2026-07-25 22:20:34');
INSERT INTO `payments` (`id`,`society_id`,`user_id`,`plan_name`,`amount`,`currency`,`razorpay_order_id`,`razorpay_payment_id`,`razorpay_signature`,`payment_method`,`status`,`paid_at`,`created_at`,`updated_at`) VALUES ('3','7','12','BASIC','999.00','INR','order_THuACqB2LdtuZs',NULL,NULL,NULL,'CREATED',NULL,'2026-07-25 22:44:41','2026-07-25 22:44:41');
INSERT INTO `payments` (`id`,`society_id`,`user_id`,`plan_name`,`amount`,`currency`,`razorpay_order_id`,`razorpay_payment_id`,`razorpay_signature`,`payment_method`,`status`,`paid_at`,`created_at`,`updated_at`) VALUES ('4','7','12','BASIC','999.00','INR','order_THuSCN49LIUqqt',NULL,NULL,NULL,'CREATED',NULL,'2026-07-25 23:01:43','2026-07-25 23:01:43');
INSERT INTO `payments` (`id`,`society_id`,`user_id`,`plan_name`,`amount`,`currency`,`razorpay_order_id`,`razorpay_payment_id`,`razorpay_signature`,`payment_method`,`status`,`paid_at`,`created_at`,`updated_at`) VALUES ('5','7','12','BASIC','999.00','INR','order_THuTMTSSHkpAsT',NULL,NULL,NULL,'CREATED',NULL,'2026-07-25 23:02:50','2026-07-25 23:02:50');
INSERT INTO `payments` (`id`,`society_id`,`user_id`,`plan_name`,`amount`,`currency`,`razorpay_order_id`,`razorpay_payment_id`,`razorpay_signature`,`payment_method`,`status`,`paid_at`,`created_at`,`updated_at`) VALUES ('6','7','12','BASIC','999.00','INR','order_THuW4RYtVVxxWz',NULL,NULL,NULL,'CREATED',NULL,'2026-07-25 23:05:23','2026-07-25 23:05:23');
INSERT INTO `payments` (`id`,`society_id`,`user_id`,`plan_name`,`amount`,`currency`,`razorpay_order_id`,`razorpay_payment_id`,`razorpay_signature`,`payment_method`,`status`,`paid_at`,`created_at`,`updated_at`) VALUES ('7','7','12','BASIC','999.00','INR','order_THuW6JfCq1apgR',NULL,NULL,NULL,'FAILED',NULL,'2026-07-25 23:05:25','2026-07-25 23:09:17');
INSERT INTO `payments` (`id`,`society_id`,`user_id`,`plan_name`,`amount`,`currency`,`razorpay_order_id`,`razorpay_payment_id`,`razorpay_signature`,`payment_method`,`status`,`paid_at`,`created_at`,`updated_at`) VALUES ('8','7','12','BASIC','999.00','INR','order_THuaFmFkZwLVQw',NULL,NULL,NULL,'FAILED',NULL,'2026-07-25 23:09:21','2026-07-25 23:10:20');
INSERT INTO `payments` (`id`,`society_id`,`user_id`,`plan_name`,`amount`,`currency`,`razorpay_order_id`,`razorpay_payment_id`,`razorpay_signature`,`payment_method`,`status`,`paid_at`,`created_at`,`updated_at`) VALUES ('9','7','12','ENTERPRISE','4999.00','INR','order_THudXswQK2D77R',NULL,NULL,NULL,'CREATED',NULL,'2026-07-25 23:12:28','2026-07-25 23:12:28');
INSERT INTO `payments` (`id`,`society_id`,`user_id`,`plan_name`,`amount`,`currency`,`razorpay_order_id`,`razorpay_payment_id`,`razorpay_signature`,`payment_method`,`status`,`paid_at`,`created_at`,`updated_at`) VALUES ('10','7','12','ENTERPRISE','4999.00','INR','order_THueDnn5ezDFnp',NULL,NULL,NULL,'FAILED',NULL,'2026-07-25 23:13:06','2026-07-25 23:13:58');
INSERT INTO `payments` (`id`,`society_id`,`user_id`,`plan_name`,`amount`,`currency`,`razorpay_order_id`,`razorpay_payment_id`,`razorpay_signature`,`payment_method`,`status`,`paid_at`,`created_at`,`updated_at`) VALUES ('11','7','12','ENTERPRISE','4999.00','INR','order_THujVrsGFNIola',NULL,NULL,NULL,'FAILED',NULL,'2026-07-25 23:18:07','2026-07-25 23:19:13');
INSERT INTO `payments` (`id`,`society_id`,`user_id`,`plan_name`,`amount`,`currency`,`razorpay_order_id`,`razorpay_payment_id`,`razorpay_signature`,`payment_method`,`status`,`paid_at`,`created_at`,`updated_at`) VALUES ('12','7','12','ENTERPRISE','4999.00','INR','order_THulfnEOaNsZ0o',NULL,NULL,NULL,'CREATED',NULL,'2026-07-25 23:20:10','2026-07-25 23:20:10');
INSERT INTO `payments` (`id`,`society_id`,`user_id`,`plan_name`,`amount`,`currency`,`razorpay_order_id`,`razorpay_payment_id`,`razorpay_signature`,`payment_method`,`status`,`paid_at`,`created_at`,`updated_at`) VALUES ('13','7','12','BASIC','999.00','INR','order_THupjXParaXoeK',NULL,NULL,NULL,'FAILED',NULL,'2026-07-25 23:24:00','2026-07-25 23:26:46');
INSERT INTO `payments` (`id`,`society_id`,`user_id`,`plan_name`,`amount`,`currency`,`razorpay_order_id`,`razorpay_payment_id`,`razorpay_signature`,`payment_method`,`status`,`paid_at`,`created_at`,`updated_at`) VALUES ('14','7','12','BASIC','999.00','INR','order_THv6ZSKSrk6eNk','pay_THv6lBwz41Ky7q','656b3f0eb5945e27b21e1f81c4e2b611d04d8c0cb5e599edba0b52e88e835bca',NULL,'SUCCESS','2026-07-25 23:40:34','2026-07-25 23:39:57','2026-07-25 23:40:34');
INSERT INTO `payments` (`id`,`society_id`,`user_id`,`plan_name`,`amount`,`currency`,`razorpay_order_id`,`razorpay_payment_id`,`razorpay_signature`,`payment_method`,`status`,`paid_at`,`created_at`,`updated_at`) VALUES ('15','7','12','BASIC','999.00','INR','order_TIvbbAJba8Ocoh',NULL,NULL,NULL,'CREATED',NULL,'2026-07-28 12:48:19','2026-07-28 12:48:19');
INSERT INTO `payments` (`id`,`society_id`,`user_id`,`plan_name`,`amount`,`currency`,`razorpay_order_id`,`razorpay_payment_id`,`razorpay_signature`,`payment_method`,`status`,`paid_at`,`created_at`,`updated_at`) VALUES ('16','10','24','BASIC','999.00','INR','order_TIx7ZtP4ylsEjI',NULL,NULL,NULL,'CREATED',NULL,'2026-07-28 14:17:17','2026-07-28 14:17:17');
INSERT INTO `payments` (`id`,`society_id`,`user_id`,`plan_name`,`amount`,`currency`,`razorpay_order_id`,`razorpay_payment_id`,`razorpay_signature`,`payment_method`,`status`,`paid_at`,`created_at`,`updated_at`) VALUES ('17','10','24','BASIC','999.00','INR','order_TIxMgHsANAZ3th',NULL,NULL,NULL,'CREATED',NULL,'2026-07-28 14:31:35','2026-07-28 14:31:35');
INSERT INTO `payments` (`id`,`society_id`,`user_id`,`plan_name`,`amount`,`currency`,`razorpay_order_id`,`razorpay_payment_id`,`razorpay_signature`,`payment_method`,`status`,`paid_at`,`created_at`,`updated_at`) VALUES ('18','10','24','BASIC','999.00','INR','order_TIxgQR0CJfWLsS',NULL,NULL,NULL,'CREATED',NULL,'2026-07-28 14:50:16','2026-07-28 14:50:16');
INSERT INTO `payments` (`id`,`society_id`,`user_id`,`plan_name`,`amount`,`currency`,`razorpay_order_id`,`razorpay_payment_id`,`razorpay_signature`,`payment_method`,`status`,`paid_at`,`created_at`,`updated_at`) VALUES ('19','10','24','ENTERPRISE','4999.00','INR','order_TIxhwEisTZoTTb',NULL,NULL,NULL,'CREATED',NULL,'2026-07-28 14:51:42','2026-07-28 14:51:42');
INSERT INTO `payments` (`id`,`society_id`,`user_id`,`plan_name`,`amount`,`currency`,`razorpay_order_id`,`razorpay_payment_id`,`razorpay_signature`,`payment_method`,`status`,`paid_at`,`created_at`,`updated_at`) VALUES ('20','10','24','ENTERPRISE','4999.00','INR','order_TIxk6On5qWuBlk',NULL,NULL,NULL,'CREATED',NULL,'2026-07-28 14:53:45','2026-07-28 14:53:45');
INSERT INTO `payments` (`id`,`society_id`,`user_id`,`plan_name`,`amount`,`currency`,`razorpay_order_id`,`razorpay_payment_id`,`razorpay_signature`,`payment_method`,`status`,`paid_at`,`created_at`,`updated_at`) VALUES ('21','10','24','ENTERPRISE','4999.00','INR','order_TIxkgMoTpZkOGn',NULL,NULL,NULL,'CREATED',NULL,'2026-07-28 14:54:18','2026-07-28 14:54:18');
INSERT INTO `payments` (`id`,`society_id`,`user_id`,`plan_name`,`amount`,`currency`,`razorpay_order_id`,`razorpay_payment_id`,`razorpay_signature`,`payment_method`,`status`,`paid_at`,`created_at`,`updated_at`) VALUES ('22','10','24','BASIC','999.00','INR','order_TJ1cdPgDPHwBaZ',NULL,NULL,NULL,'CREATED',NULL,'2026-07-28 18:41:28','2026-07-28 18:41:28');
INSERT INTO `payments` (`id`,`society_id`,`user_id`,`plan_name`,`amount`,`currency`,`razorpay_order_id`,`razorpay_payment_id`,`razorpay_signature`,`payment_method`,`status`,`paid_at`,`created_at`,`updated_at`) VALUES ('23','10','24','ENTERPRISE','4999.00','INR','order_TJ1vVZdxXJR0E4',NULL,NULL,NULL,'CREATED',NULL,'2026-07-28 18:59:20','2026-07-28 18:59:20');
INSERT INTO `payments` (`id`,`society_id`,`user_id`,`plan_name`,`amount`,`currency`,`razorpay_order_id`,`razorpay_payment_id`,`razorpay_signature`,`payment_method`,`status`,`paid_at`,`created_at`,`updated_at`) VALUES ('24','10','24','ENTERPRISE','4999.00','INR','order_TJ2M4lKQLj5fuF','pay_TJ2MkaLXTjRlks','308c48f3839c2f1b8111da15a437874dff92effa5e78450f37df2b61d410d31a',NULL,'SUCCESS','2026-07-28 19:25:29','2026-07-28 19:24:29','2026-07-28 19:25:29');
INSERT INTO `payments` (`id`,`society_id`,`user_id`,`plan_name`,`amount`,`currency`,`razorpay_order_id`,`razorpay_payment_id`,`razorpay_signature`,`payment_method`,`status`,`paid_at`,`created_at`,`updated_at`) VALUES ('25','7','12','BASIC','999.00','INR','order_TJ53mNE3Amqiwf',NULL,NULL,NULL,'CREATED',NULL,'2026-07-28 22:03:14','2026-07-28 22:03:14');
INSERT INTO `payments` (`id`,`society_id`,`user_id`,`plan_name`,`amount`,`currency`,`razorpay_order_id`,`razorpay_payment_id`,`razorpay_signature`,`payment_method`,`status`,`paid_at`,`created_at`,`updated_at`) VALUES ('26','7','12','BASIC','999.00','INR','order_TJ54ESC4zEEwqH',NULL,NULL,NULL,'CREATED',NULL,'2026-07-28 22:03:40','2026-07-28 22:03:40');
INSERT INTO `payments` (`id`,`society_id`,`user_id`,`plan_name`,`amount`,`currency`,`razorpay_order_id`,`razorpay_payment_id`,`razorpay_signature`,`payment_method`,`status`,`paid_at`,`created_at`,`updated_at`) VALUES ('27','7','12','BASIC','999.00','INR','order_TJ54afjYiYVRKH',NULL,NULL,NULL,'CREATED',NULL,'2026-07-28 22:04:00','2026-07-28 22:04:00');
INSERT INTO `payments` (`id`,`society_id`,`user_id`,`plan_name`,`amount`,`currency`,`razorpay_order_id`,`razorpay_payment_id`,`razorpay_signature`,`payment_method`,`status`,`paid_at`,`created_at`,`updated_at`) VALUES ('28','7','12','BASIC','999.00','INR','order_TJ5IlorAHzBlUx',NULL,NULL,NULL,'CREATED',NULL,'2026-07-28 22:17:26','2026-07-28 22:17:26');
INSERT INTO `payments` (`id`,`society_id`,`user_id`,`plan_name`,`amount`,`currency`,`razorpay_order_id`,`razorpay_payment_id`,`razorpay_signature`,`payment_method`,`status`,`paid_at`,`created_at`,`updated_at`) VALUES ('29','7','12','BASIC','999.00','INR','order_TJ5JD8VO6CxgtD',NULL,NULL,NULL,'CREATED',NULL,'2026-07-28 22:17:51','2026-07-28 22:17:51');
INSERT INTO `payments` (`id`,`society_id`,`user_id`,`plan_name`,`amount`,`currency`,`razorpay_order_id`,`razorpay_payment_id`,`razorpay_signature`,`payment_method`,`status`,`paid_at`,`created_at`,`updated_at`) VALUES ('30','7','12','ENTERPRISE','4999.00','INR','order_TJ6TzMRwuG0pY0','pay_TJ6VHBTcoFj1hN','f0324258a1cd4a4ddb9a15222bd430ba45e633459368875787258449195a36cb',NULL,'SUCCESS','2026-07-28 23:28:18','2026-07-28 23:26:45','2026-07-28 23:28:18');
INSERT INTO `payments` (`id`,`society_id`,`user_id`,`plan_name`,`amount`,`currency`,`razorpay_order_id`,`razorpay_payment_id`,`razorpay_signature`,`payment_method`,`status`,`paid_at`,`created_at`,`updated_at`) VALUES ('31','7','12','ENTERPRISE','4999.00','INR','order_TJFxjozLURoTAQ','pay_TJFyCSnR1h1UBV','3927f7496da084c9a401bb00d76429441466b922b620cdadedd438554ca5154a',NULL,'SUCCESS','2026-07-29 08:43:59','2026-07-29 08:43:09','2026-07-29 08:43:59');
INSERT INTO `payments` (`id`,`society_id`,`user_id`,`plan_name`,`amount`,`currency`,`razorpay_order_id`,`razorpay_payment_id`,`razorpay_signature`,`payment_method`,`status`,`paid_at`,`created_at`,`updated_at`) VALUES ('32','7','12','BASIC','999.00','INR','order_TJkgDDUL0XVCQ0',NULL,NULL,NULL,'CREATED',NULL,'2026-07-30 14:46:03','2026-07-30 14:46:03');
INSERT INTO `payments` (`id`,`society_id`,`user_id`,`plan_name`,`amount`,`currency`,`razorpay_order_id`,`razorpay_payment_id`,`razorpay_signature`,`payment_method`,`status`,`paid_at`,`created_at`,`updated_at`) VALUES ('35','7','12','BASIC','999.00','INR','order_TJsZSYrzxRKXYM',NULL,NULL,NULL,'CREATED',NULL,'2026-07-30 22:29:13','2026-07-30 22:29:13');



DROP TABLE IF EXISTS `plans`;
CREATE TABLE `plans` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(50) DEFAULT NULL,
  `amount` decimal(10,2) DEFAULT NULL,
  `duration_days` int DEFAULT NULL,
  `is_active` tinyint(1) DEFAULT '1',
  `description` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

INSERT INTO `plans` (`id`,`name`,`amount`,`duration_days`,`is_active`,`description`) VALUES ('1','BASIC','999.00','365','1','Basic Society Plan');
INSERT INTO `plans` (`id`,`name`,`amount`,`duration_days`,`is_active`,`description`) VALUES ('2','PREMIUM','1999.00','365','1','Premium Society Plan');
INSERT INTO `plans` (`id`,`name`,`amount`,`duration_days`,`is_active`,`description`) VALUES ('3','ENTERPRISE','4999.00','365','1','Enterprise Society Plan');



DROP TABLE IF EXISTS `residents`;
CREATE TABLE `residents` (
  `id` int NOT NULL AUTO_INCREMENT,
  `society_id` int NOT NULL,
  `user_id` int DEFAULT NULL,
  `flat_number` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `tower` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `resident_type` enum('OWNER','TENANT') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT 'OWNER',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `phone` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `society_id` (`society_id`),
  KEY `user_id` (`user_id`),
  CONSTRAINT `fk_resident_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=64 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `residents` (`id`,`society_id`,`user_id`,`flat_number`,`tower`,`resident_type`,`created_at`,`name`,`email`,`phone`) VALUES ('51','7','13','104','C wing','TENANT','2026-07-08 21:35:06','Shubham Sidh','shub@gmail.com','9999999999');
INSERT INTO `residents` (`id`,`society_id`,`user_id`,`flat_number`,`tower`,`resident_type`,`created_at`,`name`,`email`,`phone`) VALUES ('52','7','14','101','A','TENANT','2026-07-09 06:29:27','Tester 1','test1@123','8888888888');
INSERT INTO `residents` (`id`,`society_id`,`user_id`,`flat_number`,`tower`,`resident_type`,`created_at`,`name`,`email`,`phone`) VALUES ('53','7','15','102','A','OWNER','2026-07-09 06:29:59','Tester 2','test2@123','8888888888');
INSERT INTO `residents` (`id`,`society_id`,`user_id`,`flat_number`,`tower`,`resident_type`,`created_at`,`name`,`email`,`phone`) VALUES ('54','7','16','103','A','OWNER','2026-07-09 06:30:44','Tester 3','test3@123','8888888888');
INSERT INTO `residents` (`id`,`society_id`,`user_id`,`flat_number`,`tower`,`resident_type`,`created_at`,`name`,`email`,`phone`) VALUES ('55','7','17','201','B','TENANT','2026-07-09 06:31:32','Tester 4','test4@123','8888888888');
INSERT INTO `residents` (`id`,`society_id`,`user_id`,`flat_number`,`tower`,`resident_type`,`created_at`,`name`,`email`,`phone`) VALUES ('56','7','18','202','B','OWNER','2026-07-09 06:32:09','Tester 5','test5@123','8888888888');
INSERT INTO `residents` (`id`,`society_id`,`user_id`,`flat_number`,`tower`,`resident_type`,`created_at`,`name`,`email`,`phone`) VALUES ('57','8','21','103','b','OWNER','2026-07-10 03:49:54','Siraj','siraj@gmail.com','9028344068');
INSERT INTO `residents` (`id`,`society_id`,`user_id`,`flat_number`,`tower`,`resident_type`,`created_at`,`name`,`email`,`phone`) VALUES ('58','7','22','203','B wing','OWNER','2026-07-16 06:40:56','Sufiyan Shaikh','sufiyan@gmail.com','8956904988');
INSERT INTO `residents` (`id`,`society_id`,`user_id`,`flat_number`,`tower`,`resident_type`,`created_at`,`name`,`email`,`phone`) VALUES ('59','7','23','203','C wing','TENANT','2026-07-23 19:47:15','Testing 1','test@gmail.com','7777777777');
INSERT INTO `residents` (`id`,`society_id`,`user_id`,`flat_number`,`tower`,`resident_type`,`created_at`,`name`,`email`,`phone`) VALUES ('60','10','25','230','M','TENANT','2026-07-28 19:22:59','TSEE','TEST','5648594859');
INSERT INTO `residents` (`id`,`society_id`,`user_id`,`flat_number`,`tower`,`resident_type`,`created_at`,`name`,`email`,`phone`) VALUES ('61','7','26','405','N','OWNER','2026-07-30 14:54:23','Shubhangi Tester','shub1@gmail.com','5696894659');
INSERT INTO `residents` (`id`,`society_id`,`user_id`,`flat_number`,`tower`,`resident_type`,`created_at`,`name`,`email`,`phone`) VALUES ('62','12',NULL,'ff','ff','OWNER','2026-07-30 15:26:25','ff','ff','123');
INSERT INTO `residents` (`id`,`society_id`,`user_id`,`flat_number`,`tower`,`resident_type`,`created_at`,`name`,`email`,`phone`) VALUES ('63','10','30','353','k','OWNER','2026-07-30 22:25:31','tsetest','tst','8989898989');



DROP TABLE IF EXISTS `settings`;
CREATE TABLE `settings` (
  `id` int NOT NULL AUTO_INCREMENT,
  `site_name` varchar(150) NOT NULL DEFAULT 'SocietyOS',
  `company_name` varchar(150) DEFAULT NULL,
  `support_email` varchar(150) DEFAULT NULL,
  `support_phone` varchar(30) DEFAULT NULL,
  `currency` varchar(10) DEFAULT 'INR',
  `timezone` varchar(100) DEFAULT 'Asia/Kolkata',
  `maintenance_mode` tinyint(1) DEFAULT '0',
  `logo` varchar(255) DEFAULT NULL,
  `favicon` varchar(255) DEFAULT NULL,
  `address` text,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

INSERT INTO `settings` (`id`,`site_name`,`company_name`,`support_email`,`support_phone`,`currency`,`timezone`,`maintenance_mode`,`logo`,`favicon`,`address`,`created_at`,`updated_at`) VALUES ('1','SocietyOS','SocietyOS Official','devesociety@gmail.com','8956904988','INR','Asia/Kolkata','0',NULL,NULL,'Dhankunj Building, Opp Elpro City Square Mall.','2026-07-31 19:12:00','2026-07-31 19:18:10');



DROP TABLE IF EXISTS `societies`;
CREATE TABLE `societies` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `address` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci,
  `city` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `state` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `country` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `total_flats` int DEFAULT '0',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `societies` (`id`,`name`,`address`,`city`,`state`,`country`,`total_flats`,`created_at`) VALUES ('7','National Park',NULL,'Murud','Maharashtra','India','0','2026-07-08 21:24:26');
INSERT INTO `societies` (`id`,`name`,`address`,`city`,`state`,`country`,`total_flats`,`created_at`) VALUES ('8','HolyWood Society',NULL,'Pune','Maharashtra','India','0','2026-07-10 03:18:03');
INSERT INTO `societies` (`id`,`name`,`address`,`city`,`state`,`country`,`total_flats`,`created_at`) VALUES ('9','Green Valley',NULL,'Solapur','Maharashtra','India','0','2026-07-10 03:34:40');
INSERT INTO `societies` (`id`,`name`,`address`,`city`,`state`,`country`,`total_flats`,`created_at`) VALUES ('10','test',NULL,'test','tes','','0','2026-07-28 14:13:50');



DROP TABLE IF EXISTS `society_profile`;
CREATE TABLE `society_profile` (
  `id` int NOT NULL AUTO_INCREMENT,
  `society_id` int NOT NULL,
  `logo` varchar(255) DEFAULT NULL,
  `society_name` varchar(150) NOT NULL,
  `address` text,
  `city` varchar(80) DEFAULT NULL,
  `state` varchar(80) DEFAULT NULL,
  `country` varchar(80) DEFAULT NULL,
  `pincode` varchar(20) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `email` varchar(120) DEFAULT NULL,
  `maintenance_amount` decimal(10,2) DEFAULT '0.00',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `society_id` (`society_id`),
  CONSTRAINT `society_profile_ibfk_1` FOREIGN KEY (`society_id`) REFERENCES `societies` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

INSERT INTO `society_profile` (`id`,`society_id`,`logo`,`society_name`,`address`,`city`,`state`,`country`,`pincode`,`phone`,`email`,`maintenance_amount`,`created_at`) VALUES ('4','7',NULL,'National Park','Opp Anjuman Islam High School','Murud','Maharashtra','India','402401','8956904988','devesociety@gmail.com','500.00','2026-07-08 21:24:26');
INSERT INTO `society_profile` (`id`,`society_id`,`logo`,`society_name`,`address`,`city`,`state`,`country`,`pincode`,`phone`,`email`,`maintenance_amount`,`created_at`) VALUES ('5','8',NULL,'HolyWood Society','','Pune','Maharashtra','India','','8668622801','sufiyansirajshaikh12345@gmail.com','0.00','2026-07-10 03:18:03');
INSERT INTO `society_profile` (`id`,`society_id`,`logo`,`society_name`,`address`,`city`,`state`,`country`,`pincode`,`phone`,`email`,`maintenance_amount`,`created_at`) VALUES ('6','9',NULL,'Mantri Chandak Vihar','Bilding 3 Block 4 Aasra Chok','Solapur','Maharashtra','India','413003','9028344068','sirajabdulganishaikh786@gmail.com','800.00','2026-07-10 03:34:40');
INSERT INTO `society_profile` (`id`,`society_id`,`logo`,`society_name`,`address`,`city`,`state`,`country`,`pincode`,`phone`,`email`,`maintenance_amount`,`created_at`) VALUES ('7','10',NULL,'test','','test','tes','','','8485878245','tes456@gmail.com','0.00','2026-07-28 14:13:50');



DROP TABLE IF EXISTS `subscriptions`;
CREATE TABLE `subscriptions` (
  `id` int NOT NULL AUTO_INCREMENT,
  `society_id` int NOT NULL,
  `plan_name` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `amount` decimal(10,2) DEFAULT NULL,
  `start_date` date DEFAULT NULL,
  `expiry_date` date DEFAULT NULL,
  `status` enum('ACTIVE','EXPIRED','CANCELLED') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT 'ACTIVE',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `society_id` (`society_id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `subscriptions` (`id`,`society_id`,`plan_name`,`amount`,`start_date`,`expiry_date`,`status`,`created_at`) VALUES ('2','7','ENTERPRISE','4999.00','2026-07-29','2027-07-29','ACTIVE','2026-07-08 21:24:26');
INSERT INTO `subscriptions` (`id`,`society_id`,`plan_name`,`amount`,`start_date`,`expiry_date`,`status`,`created_at`) VALUES ('3','8','TRIAL','0.00','2026-07-10','2026-08-09','ACTIVE','2026-07-10 03:18:03');
INSERT INTO `subscriptions` (`id`,`society_id`,`plan_name`,`amount`,`start_date`,`expiry_date`,`status`,`created_at`) VALUES ('4','9','TRIAL','0.00','2026-07-10','2026-08-09','ACTIVE','2026-07-10 03:34:40');
INSERT INTO `subscriptions` (`id`,`society_id`,`plan_name`,`amount`,`start_date`,`expiry_date`,`status`,`created_at`) VALUES ('5','10','ENTERPRISE','4999.00','2026-07-28','2027-07-28','ACTIVE','2026-07-28 14:13:50');
INSERT INTO `subscriptions` (`id`,`society_id`,`plan_name`,`amount`,`start_date`,`expiry_date`,`status`,`created_at`) VALUES ('6','11','TRIAL','0.00','2026-07-30','2026-08-29','ACTIVE','2026-07-30 15:21:19');
INSERT INTO `subscriptions` (`id`,`society_id`,`plan_name`,`amount`,`start_date`,`expiry_date`,`status`,`created_at`) VALUES ('7','12','TRIAL','0.00','2026-07-30','2026-08-29','ACTIVE','2026-07-30 15:24:55');



DROP TABLE IF EXISTS `super_admins`;
CREATE TABLE `super_admins` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `email` varchar(150) NOT NULL,
  `password` varchar(255) NOT NULL,
  `status` enum('ACTIVE','BLOCKED') DEFAULT 'ACTIVE',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `last_login` date DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

INSERT INTO `super_admins` (`id`,`name`,`email`,`password`,`status`,`created_at`,`last_login`) VALUES ('1','Sufiyan','admin@societyos.in','$2y$10$C3oJ3vSRMU3gNXf/NqAOhezrcyZajxmVKwbgdk3RbAPC6bbE9gKC2','ACTIVE','2026-07-30 12:27:07','2026-08-02');



DROP TABLE IF EXISTS `user_devices`;
CREATE TABLE `user_devices` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `society_id` int NOT NULL,
  `fcm_token` text NOT NULL,
  `device_type` varchar(20) DEFAULT 'ANDROID',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `idx_user_id` (`user_id`),
  KEY `idx_society_id` (`society_id`),
  CONSTRAINT `fk_user_devices_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

INSERT INTO `user_devices` (`id`,`user_id`,`society_id`,`fcm_token`,`device_type`,`created_at`,`updated_at`) VALUES ('1','12','7','d_Gqyme-TQW7BvhP3wJsLP:APA91bHSnKopDBjYV53nVPHWdSzZIoUMfvCGxhiadUvx-jKVpEWkIAjUhn-0K62_20OdhPN-gPf7AKeEFBIPV3vr62fDNBEKQF-I_FV35MK3fK6hbGkZ5XE','ANDROID','2026-07-23 18:18:16','2026-07-23 18:18:16');
INSERT INTO `user_devices` (`id`,`user_id`,`society_id`,`fcm_token`,`device_type`,`created_at`,`updated_at`) VALUES ('2','23','7','epXFDzavQwGHPSxdq6uV9w:APA91bGZKtzjS1vs09DKegRnjbFU8XEKiQGAqJLclj8y6pVIPht4i51Cu5QwPTW-Kp7fLrGT-5knLsh5hf1CZ4w-7nGMHtdqeWzEp1jgQPJMZW8hjuJaVCY','ANDROID','2026-07-23 19:50:36','2026-07-23 19:50:36');
INSERT INTO `user_devices` (`id`,`user_id`,`society_id`,`fcm_token`,`device_type`,`created_at`,`updated_at`) VALUES ('3','12','7','dXHKcWLgQ6iSru57n2c5CD:APA91bEhEQd5mB45_J-yxT5nPXuQmBu4d9wNGfEFajPI5Kp92n80KTnaHvOQv_bY5SDpFBw8L60QHVHM0WIF-wShdvQtrs9BtrnjHi1Th7NqhUG4WVA0oEg','ANDROID','2026-07-28 22:03:03','2026-07-28 22:03:03');
INSERT INTO `user_devices` (`id`,`user_id`,`society_id`,`fcm_token`,`device_type`,`created_at`,`updated_at`) VALUES ('4','12','7','c0PJiiUjSXSPsSMy4PjZcF:APA91bFY4fC5Bsjm7EhARBysRXZswfGqjvL9Yf8F3mlJvJjoRG6fZWNuQcElMMqb8x05Wo2Yits70zoYGdjeWOD6sFMrZ7HNbmuIt-QiBMC5MZsPs8cl3Pw','ANDROID','2026-07-28 22:03:24','2026-07-28 22:03:56');
INSERT INTO `user_devices` (`id`,`user_id`,`society_id`,`fcm_token`,`device_type`,`created_at`,`updated_at`) VALUES ('5','12','7','fLcV1a5mT3CLOdjtcziEDa:APA91bHB2LZfakl6LxNfR7jurkX0ulf2MJrBBDgnKZzmcd5v8mCt_QYx3BRCkJMvnDYpUWiJJyr5KLT9fegHkPe7X4oIzBn-CnTHCJQoz4OV7kL6ieDw1R0','ANDROID','2026-07-28 22:03:27','2026-07-28 22:03:27');
INSERT INTO `user_devices` (`id`,`user_id`,`society_id`,`fcm_token`,`device_type`,`created_at`,`updated_at`) VALUES ('6','12','7','dJ5l-pX_R12b_X9UU1vWHz:APA91bHvpSkn-8FDyXIRjLKGRB-AeRyUzGnKaUfhFDlyOEcFf39XwopXDAq6OFkCjpxu4DAGedJ5C6kvSiOkdRMWWOoRyEc8TBPnau7XhgpRAlb3otqRfWk','ANDROID','2026-07-28 22:07:51','2026-07-28 22:07:51');
INSERT INTO `user_devices` (`id`,`user_id`,`society_id`,`fcm_token`,`device_type`,`created_at`,`updated_at`) VALUES ('7','12','7','fIoJ7p7HSfaCjg78b0p_jN:APA91bFlmHd-3Xmmw7oBeGZtPsqcBhLPJT6wti5X5K9z1pPy_LPfT-d8T64goQLunO1R3bkDxoq3XuZnrFp39QnFQRRHQuod4BNGA6TGbJGSxPBgzxOQCIA','ANDROID','2026-07-28 22:17:10','2026-07-28 22:17:54');
INSERT INTO `user_devices` (`id`,`user_id`,`society_id`,`fcm_token`,`device_type`,`created_at`,`updated_at`) VALUES ('8','12','7','fr7DcDBQT9ujfXEnfkVMwC:APA91bGWKN6_iLnL-0m72EmlE6AZzYhMF87FxUy1KFVLgxSkl3ORSf_ylJsC3zS1cFdEkNNjH74TBre2b4LHVDJp-Gj9HrMqPMHp0x4mbeMOgzaiSLdt3U8','ANDROID','2026-07-28 22:17:11','2026-07-28 22:17:11');
INSERT INTO `user_devices` (`id`,`user_id`,`society_id`,`fcm_token`,`device_type`,`created_at`,`updated_at`) VALUES ('9','12','7','dX3WKd09Rye1NL0nROrL48:APA91bEH_osuz9tK95vJtEaoY_0h9AISt5dxPV1s023Drhw-4QCa2Qhj-013nPpqB6tacfOCaOYf14yz47fIIiH_dIOFZtye_K0tJjxlHOOsy9yyQ0t8kXo','ANDROID','2026-07-28 22:17:37','2026-07-28 22:17:37');
INSERT INTO `user_devices` (`id`,`user_id`,`society_id`,`fcm_token`,`device_type`,`created_at`,`updated_at`) VALUES ('10','12','7','cNM2AGQCSxWxIH4rj7bn1M:APA91bHYbpAxXXrKMJsFLGNq94OMe6HMJSwyr1zzJM2sI9RCdt5HpA9plrRf5gI-enIjdWvClIzvKETLbaYydJOHMStwkhS-MpJmW2YoUGBfGQ4hfVQDMbg','ANDROID','2026-07-28 22:23:46','2026-07-28 22:23:46');
INSERT INTO `user_devices` (`id`,`user_id`,`society_id`,`fcm_token`,`device_type`,`created_at`,`updated_at`) VALUES ('11','26','7','c4_GnLEISQSTctmkXVwnv0:APA91bGBBe7_G57kmSZvPH0VWv1eR3uvnl0NcD0b9cBVW-9gzb8haCvKd-1qEvZr3HIHFOPbqVprzvuVSmaOhgW0_LcJdkksa7ywWQKM5SSXLiKFieEwt1g','ANDROID','2026-07-30 14:55:39','2026-07-30 14:55:39');



DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` int NOT NULL AUTO_INCREMENT,
  `society_id` int DEFAULT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `phone` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `role` enum('SUPER_ADMIN','ADMIN','RESIDENT') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT 'RESIDENT',
  `profile_image` varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `is_active` tinyint(1) DEFAULT '1',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `api_token` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `status` enum('ACTIVE','INACTIVE') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'ACTIVE',
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`),
  KEY `society_id` (`society_id`)
) ENGINE=InnoDB AUTO_INCREMENT=31 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `users` (`id`,`society_id`,`name`,`email`,`phone`,`password`,`role`,`profile_image`,`is_active`,`created_at`,`api_token`,`status`) VALUES ('12','7','Sufiyan ','devesociety@gmail.com','8956904988','$2y$10$J.WHXg7pZplbe1AEEE6G3eh9fDKVxd.KjP6Z6oLHTYhMat5YzrCQe','ADMIN',NULL,'1','2026-07-08 21:24:26','0d543642788d935a34cd846ebfd45c0320bc942de525ddd1a7fcd0c9f95b6d07','ACTIVE');
INSERT INTO `users` (`id`,`society_id`,`name`,`email`,`phone`,`password`,`role`,`profile_image`,`is_active`,`created_at`,`api_token`,`status`) VALUES ('13','7','Shubham Sidh','shub@123','9999999999','$2y$10$c/qgLyU3iULgOFYBYE8.p.lLgvgarMBh4McDMuFpdK.EaHMpe489.','RESIDENT',NULL,'1','2026-07-08 21:35:06',NULL,'ACTIVE');
INSERT INTO `users` (`id`,`society_id`,`name`,`email`,`phone`,`password`,`role`,`profile_image`,`is_active`,`created_at`,`api_token`,`status`) VALUES ('14','7','Tester 1','test1@123','8888888888','$2y$10$/H7XFT.Fc9.WRiaYQn5..utkdNlL3/STIqCWL8WtAQwL9HNqZ8Tvm','RESIDENT',NULL,'1','2026-07-09 06:29:27','f3c991cdbaabea1d0e2bffd095e06a1d5eb4ca896b257067797ac22fed82f3a5','ACTIVE');
INSERT INTO `users` (`id`,`society_id`,`name`,`email`,`phone`,`password`,`role`,`profile_image`,`is_active`,`created_at`,`api_token`,`status`) VALUES ('15','7','Tester 2','test2@123','8888888888','$2y$10$0jkuNwx/0J0DbjUMmzuLU.UFm/QCx13FXaX/MoeV4iXgu85QPsAT2','RESIDENT',NULL,'1','2026-07-09 06:29:59','16f13360c1383a9bd28ce1be908bb6e264d61da4580cc1fbfea3057cf3d30c72','ACTIVE');
INSERT INTO `users` (`id`,`society_id`,`name`,`email`,`phone`,`password`,`role`,`profile_image`,`is_active`,`created_at`,`api_token`,`status`) VALUES ('16','7','Tester 3','test3@123','8888888888','$2y$10$gtndwyPVUwtjjtl9By7rNOm30xn9UBH8PLNwFVI6Ztw04GC2eItgm','RESIDENT',NULL,'1','2026-07-09 06:30:44',NULL,'ACTIVE');
INSERT INTO `users` (`id`,`society_id`,`name`,`email`,`phone`,`password`,`role`,`profile_image`,`is_active`,`created_at`,`api_token`,`status`) VALUES ('17','7','Tester 4','test4@123','8888888888','$2y$10$xSbGdaalarC.rFQCcYH4S.3d7sEw4x9FbAWXYx6ADTCDgGGu/LFne','RESIDENT',NULL,'1','2026-07-09 06:31:32',NULL,'ACTIVE');
INSERT INTO `users` (`id`,`society_id`,`name`,`email`,`phone`,`password`,`role`,`profile_image`,`is_active`,`created_at`,`api_token`,`status`) VALUES ('18','7','Tester 5','test5@123','8888888888','$2y$10$HNS8TO7mooEdhmApXAa.S.BwF4/kpI.yi382BCddsQ1fPMTzYaRB6','RESIDENT',NULL,'1','2026-07-09 06:32:09',NULL,'ACTIVE');
INSERT INTO `users` (`id`,`society_id`,`name`,`email`,`phone`,`password`,`role`,`profile_image`,`is_active`,`created_at`,`api_token`,`status`) VALUES ('19','7','Sufiyan','sufiyansirajshaikh12345@gmail.com','8668622801','$2y$10$Qx1VSBRioo.ui32wKGnqCeXkZzOdXtIWO2Z/mjuOA/RCyx3boAGSu','RESIDENT',NULL,'1','2026-07-10 03:18:03','05dc9bfd75e02fd1f3642c54fa83928b2632a4fae001952f737caa4045bef964','ACTIVE');
INSERT INTO `users` (`id`,`society_id`,`name`,`email`,`phone`,`password`,`role`,`profile_image`,`is_active`,`created_at`,`api_token`,`status`) VALUES ('20','9','Sufiyan','sirajabdulganishaikh786@gmail.com','9028344068','$2y$10$G1HwbbX5gijv7EO5.z.O/e/nvypVt3PWrU9nFYICK3mNrH.XIvGjG','ADMIN',NULL,'1','2026-07-10 03:34:40','fef6d176fd96db4faf96feadb517bfcb83b82901c92c91be558d4b43ee0011a5','ACTIVE');
INSERT INTO `users` (`id`,`society_id`,`name`,`email`,`phone`,`password`,`role`,`profile_image`,`is_active`,`created_at`,`api_token`,`status`) VALUES ('21','8','Siraj','siraj@gmail.com','9028344068','$2y$10$zzVN19JKi5OQDIYpybDQheqz4vOGkE6XDmqgsPRV30g8O/aGcWZB.','RESIDENT',NULL,'1','2026-07-10 03:49:54',NULL,'ACTIVE');
INSERT INTO `users` (`id`,`society_id`,`name`,`email`,`phone`,`password`,`role`,`profile_image`,`is_active`,`created_at`,`api_token`,`status`) VALUES ('22','7','Sufiyan Shaikh','sufiyan@gmail.com','8956904988','$2y$10$nA1C/zF8lGT2BGwadsE6ReCKZoRmhZT6Lxijig7BuIqz7mZJiIICS','RESIDENT',NULL,'1','2026-07-16 06:40:56','f046720a3f63a1b9340e4079e877de5634d9ef105040709f22addf68738b01d3','ACTIVE');
INSERT INTO `users` (`id`,`society_id`,`name`,`email`,`phone`,`password`,`role`,`profile_image`,`is_active`,`created_at`,`api_token`,`status`) VALUES ('23','7','Testing 1','test@gmail.com','7777777777','$2y$10$8GA8hotunEcGTFu2f1WWse2ynV4aO6cDlbBrSpCHiXAB4vDNyJArW','RESIDENT',NULL,'1','2026-07-23 19:47:15','68c9e51bf24bcc754ce330678a0b1557d0f0c9bc6b92bea9fb1890f9a192e2b5','ACTIVE');
INSERT INTO `users` (`id`,`society_id`,`name`,`email`,`phone`,`password`,`role`,`profile_image`,`is_active`,`created_at`,`api_token`,`status`) VALUES ('24','10','test','tes456@gmail.com','8485878245','$2y$10$9rCCl4Offx8UOvZZnWR3Kep2vulVxTTQRBxhWQe1nOy3gLKPlPrYG','ADMIN',NULL,'1','2026-07-28 14:13:50','5c4eb4dcda4023f327e952b841f9e1e6c418af549f19f19e52617cb22331ec89','ACTIVE');
INSERT INTO `users` (`id`,`society_id`,`name`,`email`,`phone`,`password`,`role`,`profile_image`,`is_active`,`created_at`,`api_token`,`status`) VALUES ('25','10','TSEE','TEST','5648594859','$2y$10$0You7g1UHxlmRqu.hUok8O6rRWT66wdvcNzPEXRaQdMQaIz/ZxhBy','RESIDENT',NULL,'1','2026-07-28 19:22:59',NULL,'ACTIVE');
INSERT INTO `users` (`id`,`society_id`,`name`,`email`,`phone`,`password`,`role`,`profile_image`,`is_active`,`created_at`,`api_token`,`status`) VALUES ('26','7','Shubhangi Tester','shub1@gmail.com','5696894659','$2y$10$4iVmZeUpvQDXgPCBrydTde3JtsGGfMMuQbjOohFa2HuyGH0KGMq2i','RESIDENT',NULL,'1','2026-07-30 14:54:23','344f21e2babc019aa9593f7dc1f8252b34b6838730e1a2e24b4848a613a050c1','ACTIVE');
INSERT INTO `users` (`id`,`society_id`,`name`,`email`,`phone`,`password`,`role`,`profile_image`,`is_active`,`created_at`,`api_token`,`status`) VALUES ('30','10','tsetest','tst','8989898989','$2y$10$PBh3iwz.L8RTbKz.Vx0gUOLX4dOizK0GVmMnH7fQPrm0jTqZhbbtG','RESIDENT',NULL,'1','2026-07-30 22:25:31',NULL,'ACTIVE');




SQL;

    $db->exec($sql);

    $db->exec("SET FOREIGN_KEY_CHECKS = 1;");

    echo "Tables created successfully.";

} catch (PDOException $e) {

    try {
        if (isset($db)) {
            $db->exec("SET FOREIGN_KEY_CHECKS = 1;");
        }
    } catch (Exception $ignored) {
    }

    die($e->getMessage());
}
