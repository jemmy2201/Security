-- MySQL dump 10.13  Distrib 5.7.24, for Win64 (x86_64)
--
-- Host: 127.0.0.1    Database: security_employees
-- ------------------------------------------------------
-- Server version	5.7.24

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `booking_schedules`
--

DROP TABLE IF EXISTS `booking_schedules`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `booking_schedules` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `app_type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'new or replacement or renewal',
  `card_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'get table application',
  `grade_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'get table detail application',
  `declaration_date` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'date select declaration',
  `trans_date` timestamp NULL DEFAULT NULL COMMENT 'date transaction amount',
  `expired_date` timestamp NULL DEFAULT NULL COMMENT 'date after transaction amount',
  `appointment_date` timestamp NULL DEFAULT NULL COMMENT 'date appointment',
  `time_start_appointment` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'time start declaration',
  `time_end_appointment` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'time end declaration',
  `gst_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `transaction_amount_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `grand_total` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `Status_app` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `paymentby` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status_payment` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `receiptNo` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `booking_schedules`
--

LOCK TABLES `booking_schedules` WRITE;
/*!40000 ALTER TABLE `booking_schedules` DISABLE KEYS */;
/*!40000 ALTER TABLE `booking_schedules` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `failed_jobs`
--

DROP TABLE IF EXISTS `failed_jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `failed_jobs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `failed_jobs`
--

LOCK TABLES `failed_jobs` WRITE;
/*!40000 ALTER TABLE `failed_jobs` DISABLE KEYS */;
/*!40000 ALTER TABLE `failed_jobs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `grades`
--

DROP TABLE IF EXISTS `grades`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `grades` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `card_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'get table application',
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `bsoc` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ssoc` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `sssc` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_by` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `grades`
--

LOCK TABLES `grades` WRITE;
/*!40000 ALTER TABLE `grades` DISABLE KEYS */;
INSERT INTO `grades` VALUES (1,'0','Security Officer Course - Provide Guards & Patrol Services (PGPS)','SO','000000','000000','000000','admin','2021-03-29 01:35:28','2021-03-29 01:35:31'),(2,'0','Security Officer Course - Incident Response (HSIS)','SO','000000','000000','000000','admin','2021-03-29 01:35:28','2021-03-29 01:35:31'),(3,'0','Security Officer Course - Recognise Terrorist Threat (RTT)','SO','000000','000000','000000','admin','2021-03-29 01:35:28','2021-03-29 01:35:31'),(4,'0','Senior Security Officer Course - Operate Basic Security Equipment (OBSE)','SSO','000000','000000','000000','admin','2021-03-29 01:35:28','2021-03-29 01:35:31'),(5,'0','Senior Security Officer Course - Manage Disorderly Conduct & Threatening Behaviour (MDCTB)','SSO','000000','000000','000000','admin','2021-03-29 01:35:28','2021-03-29 01:35:31'),(6,'0','Security Supervisor Course - Perform Supervisory Duties Within Legal Framework','SSS','000000','000000','000000','admin','2021-03-29 01:35:28','2021-03-29 01:35:31'),(7,'0','Security Supervisor Course - Induct Security Personnel','SSS','000000','000000','000000','admin','2021-03-29 01:35:28','2021-03-29 01:35:31'),(8,'0','Security Supervisor Course - Supervise Security Officers','SSS','000000','000000','000000','admin','2021-03-29 01:35:28','2021-03-29 01:35:31');
/*!40000 ALTER TABLE `grades` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `gsts`
--

DROP TABLE IF EXISTS `gsts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `gsts` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `create_date` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `amount_gst` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `gsts`
--

LOCK TABLES `gsts` WRITE;
/*!40000 ALTER TABLE `gsts` DISABLE KEYS */;
INSERT INTO `gsts` VALUES (1,'2021-04-01','4','2021-03-31 22:43:57','2021-03-31 22:43:57');
/*!40000 ALTER TABLE `gsts` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migrations`
--

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` VALUES (1,'2014_10_12_000000_create_users_table',1),(2,'2014_10_12_100000_create_password_resets_table',1),(3,'2019_08_19_000000_create_failed_jobs_table',1),(14,'2021_03_17_075911_create_schedule_limits_table',6),(18,'2021_03_25_034651_create_gsts_table',9),(20,'2021_03_25_025041_create_grades_table',10),(21,'2021_03_17_081549_create_booking_schedules_table',11),(22,'2021_03_29_082320_create_sertifikats_table',11),(23,'2021_03_25_022853_create_transaction_amounts_table',12),(24,'2021_05_03_111320_create_backup_users_table',13),(25,'2021_05_03_111420_create_backup_booking_schedules_table',13);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `password_resets`
--

DROP TABLE IF EXISTS `password_resets`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  KEY `password_resets_email_index` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `password_resets`
--

LOCK TABLES `password_resets` WRITE;
/*!40000 ALTER TABLE `password_resets` DISABLE KEYS */;
/*!40000 ALTER TABLE `password_resets` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `schedule_limits`
--

DROP TABLE IF EXISTS `schedule_limits`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `schedule_limits` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `date_schedule_limit` timestamp NULL DEFAULT NULL,
  `start_at` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `end_at` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `amount` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=69 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `schedule_limits`
--

LOCK TABLES `schedule_limits` WRITE;
/*!40000 ALTER TABLE `schedule_limits` DISABLE KEYS */;
INSERT INTO `schedule_limits` VALUES (1,'2021-03-30 15:19:04','09:00','11:00','1','0','2021-03-30 15:19:16','2021-03-30 15:19:20'),(2,'2021-03-30 15:19:43','10:00','12:00','10','0','2021-03-30 15:19:16','2021-03-30 15:19:24'),(58,'2021-03-30 17:00:00','08:00','09:00','10','0','2021-03-31 03:19:47','2021-03-31 03:19:47'),(59,'2021-03-30 17:00:00','10:00','11:00','10','0','2021-03-31 03:19:47','2021-03-31 03:19:47'),(60,'2021-03-30 17:00:00','08:00','09:00','10','0','2021-03-31 03:20:22','2021-03-31 03:20:22'),(61,'2021-03-30 17:00:00','10:00','11:00','10','0','2021-03-31 03:20:22','2021-03-31 03:20:22'),(62,'2021-03-30 17:00:00','11:00','12:00','5','0','2021-03-31 03:20:22','2021-03-31 03:20:22'),(63,'2021-03-30 17:00:00','12:00','13:00','5','0','2021-03-31 03:20:22','2021-03-31 03:20:22'),(64,'2021-03-30 17:00:00','08:00','09:00','7','0','2021-03-31 07:29:56','2021-03-31 07:56:05'),(65,'2021-03-30 17:00:00','09:00','10:00','10','0','2021-03-31 07:29:56','2021-03-31 07:29:56'),(66,'2021-03-30 17:00:00','08:00','09:00','10','1','2021-03-31 07:56:34','2021-03-31 07:56:34'),(67,'2021-03-30 17:00:00','09:00','10:00','10','1','2021-03-31 07:56:34','2021-03-31 07:56:34'),(68,'2021-03-30 17:00:00','11:00','12:00','10','1','2021-03-31 07:56:34','2021-03-31 07:56:34');
/*!40000 ALTER TABLE `schedule_limits` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sertifikats`
--

DROP TABLE IF EXISTS `sertifikats`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sertifikats` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `app_type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'new or replacement or renewal',
  `card_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'get table application',
  `grade_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'get table detail application',
  `declaration_date` timestamp NULL DEFAULT NULL COMMENT 'date select declaration',
  `trans_date` timestamp NULL DEFAULT NULL COMMENT 'date transaction amount',
  `expired_date` timestamp NULL DEFAULT NULL COMMENT 'date after transaction amount',
  `appointment_date` timestamp NULL DEFAULT NULL COMMENT 'date appointment',
  `time_start_appointment` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'time start declaration',
  `time_end_appointment` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'time end declaration',
  `gst` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `grand_gst` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `transaction_amount` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `grand_total` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `Status_app` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `paymentby` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status_payment` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `receiptNo` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sertifikats`
--

LOCK TABLES `sertifikats` WRITE;
/*!40000 ALTER TABLE `sertifikats` DISABLE KEYS */;
INSERT INTO `sertifikats` VALUES (1,'1','1','2','2021-05-02 17:00:00','2021-05-02 17:00:00','2022-05-02 17:00:00','2021-05-03 17:00:00','08:00','09:00','4','4','17','17.68','3','paynow','1','03/05/21/4','2','2021-05-03 04:52:40','2021-05-03 04:52:40');
/*!40000 ALTER TABLE `sertifikats` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `transaction_amounts`
--

DROP TABLE IF EXISTS `transaction_amounts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `transaction_amounts` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `app_type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `card_type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `grade_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `grade_type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `transaction_amount` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=43 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `transaction_amounts`
--

LOCK TABLES `transaction_amounts` WRITE;
/*!40000 ALTER TABLE `transaction_amounts` DISABLE KEYS */;
INSERT INTO `transaction_amounts` VALUES (19,'0','1','1','1','12','2021-04-15 16:41:51','2021-04-15 16:41:51'),(20,'0','1','2','1','12','2021-04-15 16:41:51','2021-04-15 16:41:51'),(21,'0','1','3','1','12','2021-04-15 16:41:51','2021-04-15 16:41:51'),(22,'0','2',NULL,NULL,'121','2021-04-15 16:59:01','2021-04-15 17:03:40'),(23,'0','1','4','2','111','2021-04-15 16:59:19','2021-04-15 16:59:19'),(24,'0','1','5','2','111','2021-04-15 16:59:19','2021-04-15 16:59:19'),(25,'1','1','4','2','17','2021-04-16 19:01:47','2021-04-16 19:01:47'),(26,'1','1','5','2','17','2021-04-16 19:01:47','2021-04-16 19:01:47'),(27,'2','1','6','3','20','2021-04-16 19:04:02','2021-04-16 19:04:02'),(28,'2','1','7','3','20','2021-04-16 19:04:03','2021-04-16 19:04:03'),(29,'2','1','8','3','20','2021-04-16 19:04:03','2021-04-16 19:04:03'),(30,'2','1','4','2','12','2021-04-16 19:26:43','2021-04-16 19:26:43'),(31,'2','1','5','2','12','2021-04-16 19:26:43','2021-04-16 19:26:43'),(32,'1','2',NULL,NULL,'11','2021-04-16 19:34:52','2021-04-16 19:34:52'),(33,'0','3',NULL,NULL,'11','2021-04-16 19:38:01','2021-04-16 19:38:01'),(34,'1','3',NULL,NULL,'122','2021-04-16 19:39:29','2021-04-16 19:39:29'),(35,'2','3',NULL,NULL,'122','2021-04-16 19:51:42','2021-04-16 19:51:42'),(36,'2','2',NULL,NULL,'111','2021-04-16 19:51:58','2021-04-16 19:51:58'),(37,'1','1','1','1','12','2021-04-29 02:11:01','2021-04-29 02:11:01'),(38,'1','1','2','1','12','2021-04-29 02:11:01','2021-04-29 02:11:01'),(39,'1','1','3','1','12','2021-04-29 02:11:01','2021-04-29 02:11:01'),(40,'2','1','1','1','12','2021-04-29 02:58:19','2021-04-29 02:58:19'),(41,'2','1','2','1','12','2021-04-29 02:58:19','2021-04-29 02:58:19'),(42,'2','1','3','1','12','2021-04-29 02:58:19','2021-04-29 02:58:19');
/*!40000 ALTER TABLE `transaction_amounts` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nric` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'National Registration Identity Card or Foreign Identification Number',
  `passid` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `passportexpirydate` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `passexpirydate` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `passportnumber` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `mobileno` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `homeno` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `photo` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `time_login_at` date DEFAULT NULL COMMENT 'time login',
  `role` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'admin','admin@admin.com',NULL,'$2y$10$iaz4fTRs0T79EXanuiduieK5CRH3Ub6iECY0iI7H81HCbKFU5TRCu',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'1',NULL,NULL,NULL);
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2021-05-04 14:26:20
