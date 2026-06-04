-- MySQL dump 10.13  Distrib 8.0.30, for Win64 (x86_64)
--
-- Host: localhost    Database: scimediaonline_laravel_learning_management_system_db
-- ------------------------------------------------------
-- Server version	8.0.30

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `admin_activity_logs`
--

DROP TABLE IF EXISTS `admin_activity_logs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `admin_activity_logs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `admin_id` int DEFAULT NULL,
  `action` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `data_id` bigint unsigned DEFAULT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `admin_activity_logs_admin_id_foreign` (`admin_id`),
  CONSTRAINT `admin_activity_logs_admin_id_foreign` FOREIGN KEY (`admin_id`) REFERENCES `admins` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `admin_activity_logs`
--

LOCK TABLES `admin_activity_logs` WRITE;
/*!40000 ALTER TABLE `admin_activity_logs` DISABLE KEYS */;
INSERT INTO `admin_activity_logs` VALUES (1,1,'UPDATE','Admin',1,'Data diubah','127.0.0.1','2026-03-03 05:23:44','2026-03-03 05:23:44'),(2,1,'UPDATE','Admin',1,'Data diubah','127.0.0.1','2026-03-03 05:39:08','2026-03-03 05:39:08'),(3,1,'CREATE','Admin',6,'Data ditambahkan','127.0.0.1','2026-03-03 05:39:53','2026-03-03 05:39:53'),(4,6,'UPDATE','Admin',6,'Data diubah','127.0.0.1','2026-03-03 05:40:05','2026-03-03 05:40:05'),(5,6,'UPDATE','Admin',6,'Data diubah','127.0.0.1','2026-03-03 10:41:22','2026-03-03 10:41:22'),(6,6,'UPDATE','Serial',1,'Data diubah','127.0.0.1','2026-03-03 10:41:37','2026-03-03 10:41:37'),(7,6,'UPDATE','Serial',2,'Data diubah','127.0.0.1','2026-03-03 10:41:38','2026-03-03 10:41:38'),(8,6,'UPDATE','Admin',6,'Data diubah','127.0.0.1','2026-03-03 10:45:15','2026-03-03 10:45:15');
/*!40000 ALTER TABLE `admin_activity_logs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `admins`
--

DROP TABLE IF EXISTS `admins`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `admins` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `username` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `role` tinyint NOT NULL,
  `date_in` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `position` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `img` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `login_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `admins_username_unique` (`username`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `admins`
--

LOCK TABLES `admins` WRITE;
/*!40000 ALTER TABLE `admins` DISABLE KEYS */;
INSERT INTO `admins` VALUES (1,'Admin A','QAZWSXEDC','$2y$12$Vb/vdf3sluoJLXBJyrHYUOru3/DEqlqmc3SuVYNt3oC4aJMxeJScK',1,'2026-03-03','Super-Admin','081111111111',NULL,'2026-03-03 05:39:08','2026-03-03 05:22:58','2026-03-03 05:39:08'),(2,'Admin B','Admin','$2y$12$AJxgsojw84rBh9oGNVg0p.71fsiTWdg3hNfdTFnDYNdH2ujq/Bl0i',2,'2026-03-03','Admin','082222222222',NULL,NULL,'2026-03-03 05:22:59','2026-03-03 05:22:59'),(3,'Admin C','Koordinator','$2y$12$lYcXOTdre.2dc7plRIIwf.OYvVfEDQJ.FjiXmc/pVMsl2Xf2LmJJy',3,'2026-03-03','Operasional','083333333333',NULL,NULL,'2026-03-03 05:22:59','2026-03-03 05:22:59'),(4,'Admin D','Konten-Pembelajaran','$2y$12$hyyP/7dNQTt2w1doZBVP8OEUky9Emn78JCVACYmJsyy7ydBc.HTAu',4,'2026-03-03','Konten-Pembelajaran','084444444444',NULL,NULL,'2026-03-03 05:22:59','2026-03-03 05:22:59'),(5,'Admin E','Layanan-Pelanggan','$2y$12$IGrPWNndXgm0gkEPJWVB3ejnhRop2iVvU5EX0qzJkupM5xywgyRxO',5,'2026-03-03','Layanan-Pengguna','085555555555',NULL,NULL,'2026-03-03 05:23:00','2026-03-03 05:23:00'),(6,'Jonathan','Jon','$2y$12$a4AodLaPraxgNfbxEvcL9u8HyLGgK8AddiuwMM6xMcCeb9g3U6gde',1,'2026-01-01',NULL,NULL,NULL,'2026-03-03 10:45:14','2026-03-03 05:39:53','2026-03-03 10:45:14');
/*!40000 ALTER TABLE `admins` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `classrooms`
--

DROP TABLE IF EXISTS `classrooms`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `classrooms` (
  `id` int NOT NULL AUTO_INCREMENT,
  `serial_id` int NOT NULL,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `grade` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `code` varchar(24) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `classrooms_serial_id_foreign` (`serial_id`),
  CONSTRAINT `classrooms_serial_id_foreign` FOREIGN KEY (`serial_id`) REFERENCES `serials` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `classrooms`
--

LOCK TABLES `classrooms` WRITE;
/*!40000 ALTER TABLE `classrooms` DISABLE KEYS */;
INSERT INTO `classrooms` VALUES (1,1,'KELAS 1 PAK J','1','AYaXY6YwBfpB8KwGF3Dnh5SB','2025-12-28 13:12:39','2025-12-28 13:12:39'),(2,2,'Kelas Pax Q','1','jY30qaFTVqEisfLBCuoMEs9k','2026-01-08 15:55:40','2026-01-08 15:55:40');
/*!40000 ALTER TABLE `classrooms` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `competences`
--

DROP TABLE IF EXISTS `competences`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `competences` (
  `id` int NOT NULL AUTO_INCREMENT,
  `lesson_id` int NOT NULL,
  `mapel_id` int NOT NULL,
  `point` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `competences_lesson_id_foreign` (`lesson_id`),
  KEY `competences_mapel_id_foreign` (`mapel_id`),
  CONSTRAINT `competences_lesson_id_foreign` FOREIGN KEY (`lesson_id`) REFERENCES `lessons` (`id`) ON DELETE CASCADE,
  CONSTRAINT `competences_mapel_id_foreign` FOREIGN KEY (`mapel_id`) REFERENCES `mapels` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `competences`
--

LOCK TABLES `competences` WRITE;
/*!40000 ALTER TABLE `competences` DISABLE KEYS */;
INSERT INTO `competences` VALUES (1,1,1,'KD-01','Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur.','2025-12-29 04:53:32','2025-12-29 04:53:32');
/*!40000 ALTER TABLE `competences` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cs_files`
--

DROP TABLE IF EXISTS `cs_files`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `cs_files` (
  `id` int NOT NULL AUTO_INCREMENT,
  `room_id` int NOT NULL,
  `file_path` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `cs_files_room_id_foreign` (`room_id`),
  CONSTRAINT `cs_files_room_id_foreign` FOREIGN KEY (`room_id`) REFERENCES `cs_rooms` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cs_files`
--

LOCK TABLES `cs_files` WRITE;
/*!40000 ALTER TABLE `cs_files` DISABLE KEYS */;
/*!40000 ALTER TABLE `cs_files` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cs_logs`
--

DROP TABLE IF EXISTS `cs_logs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `cs_logs` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `question_categories_id` int DEFAULT NULL,
  `admin_id` int DEFAULT NULL,
  `completion_time` datetime NOT NULL,
  `resolution_by` enum('QnA','ChatBot','Admin') COLLATE utf8mb4_unicode_ci NOT NULL,
  `notes` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `cs_logs_admin_id_foreign` (`admin_id`),
  KEY `cs_logs_question_categories_id_foreign` (`question_categories_id`),
  CONSTRAINT `cs_logs_admin_id_foreign` FOREIGN KEY (`admin_id`) REFERENCES `admins` (`id`) ON DELETE SET NULL,
  CONSTRAINT `cs_logs_question_categories_id_foreign` FOREIGN KEY (`question_categories_id`) REFERENCES `question_categories` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cs_logs`
--

LOCK TABLES `cs_logs` WRITE;
/*!40000 ALTER TABLE `cs_logs` DISABLE KEYS */;
INSERT INTO `cs_logs` VALUES (1,NULL,NULL,'2026-02-24 22:24:17','ChatBot','[24/02/2026 22:16] Sistem: Terima kasih telah menghubungi layanan ini.<br> \n            Silakan jelaskan masalah Anda. ChatBot akan mencoba menjawab secara otomatis.\n[24/02/2026 22:16] Pelapor: hallo nama saya jo saya tidak bisa login\n[24/02/2026 22:16] ChatBot: ? Terima kasih sudah menunggu. Berikut informasi yang ditemukan:\n\nNama : Jo\nKategori  : Pelapor\n\nUntuk melihat solusi secara lengkap, silakan login sebagai Pelapor atau menghubungi admin guna memperoleh informasi lebih lanjut.\n[24/02/2026 22:17] Pelapor: hallo nama saya jo saya tidak bisa login\n[24/02/2026 22:18] Sistem: AI tidak dapat dihubungi.\n[24/02/2026 22:18] Pelapor: Lupa password atau nama pengguna\n[24/02/2026 22:19] ChatBot: ? Terima kasih sudah menunggu.\nBerikut informasi yang ditemukan:\n\nNama : Lupa password atau nama pengguna\n\nKategori  : Umum\n\nSolusi:\nLorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.\n\nUt enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.\n\nDuis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur.\n\nVideo Panduan:\nhttps://www.youtube.com/watch?v=XGvhjm2vI7o\n\nFile Panduan:\nhttp://127.0.0.1:8000/storage/guide_files/1763656678_p.pdf\n[24/02/2026 22:20] Pelapor: nama saya siapa ya tadi ?\n[24/02/2026 22:20] ChatBot: ? Nama Anda adalah Jo, seperti yang sudah kami informasikan sebelumnya. Jika ada pertanyaan lain, silakan sampaikan.\n[24/02/2026 22:20] Pelapor: info lowongan kerja jadi admin\n[24/02/2026 22:22] ChatBot: ? Maaf, saya hanya dapat membantu berdasarkan informasi yang tersedia di sistem SCI Media Online.\n\nUntuk pertanyaan berikut:\n\"info lowongan kerja jadi admin\"\n\nSilakan hubungi admin untuk informasi lebih lanjut. \n\nTerima kasih atas kontribusi Anda dalam membantu meningkatkan kualitas layanan kami dengan menambahkan variasi pertanyaan.\n[24/02/2026 22:22] Pelapor: Laporan bug atau kesalahan sistem lainnya\n[24/02/2026 22:23] ChatBot: ? Terima kasih sudah menunggu.\nBerikut informasi yang ditemukan:\n\nNama : Laporan bug atau kesalahan sistem lainnya\n\nKategori  : Umum\n\nSolusi:\nLorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.\n\nUt enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.\n\nDuis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur.\n\nVideo Panduan:\nhttps://www.youtube.com/watch?v=XGvhjm2vI7o\n\nFile Panduan:\nhttp://127.0.0.1:8000/storage/guide_files/1763656678_p.pdf\n[24/02/2026 22:23] Pelapor: terimakasih\n[24/02/2026 22:24] ChatBot: ? Sama-sama! ? \nSemoga informations yang diberikan earlier bisa membantu. Jika ada pertanyaan lebih lanjut, jangan ragu untuk bertanya kembali. \nSampai jumpa!\n[24/02/2026 22:24] Sistem: Layanan ini telah diselesaikan oleh Pelapor.','2026-02-24 15:24:20','2026-02-24 15:24:20'),(2,NULL,NULL,'2026-02-26 09:53:07','QnA','Terselesaikan otomatis oleh QnA.','2026-02-26 02:53:17','2026-02-26 02:53:17'),(3,NULL,NULL,'2026-02-26 10:41:39','ChatBot','[26/02/2026 10:41] Sistem: Terima kasih telah menghubungi layanan ini.<br> \n            Silakan jelaskan masalah Anda. ChatBot akan mencoba menjawab secara otomatis.\n[26/02/2026 10:41] Sistem: Layanan ini telah diselesaikan oleh Pelapor.','2026-02-26 03:41:41','2026-02-26 03:41:41'),(4,NULL,NULL,'2026-02-26 10:42:09','Admin','[26/02/2026 10:41] Sistem: Terima kasih telah menghubungi layanan ini.<br> \n            Silakan jelaskan masalah Anda. ChatBot akan mencoba menjawab secara otomatis.\n[26/02/2026 10:42] Sistem: Permintaan Anda telah diteruskan kepada Admin. Mohon menunggu respons.\nJika dalam 5 menit belum ada tanggapan, Anda dapat menekan tombol ini kembali. Gunakan fitur ini dengan bijak.\n[26/02/2026 10:42] Sistem: Layanan ini telah diselesaikan oleh Pelapor.','2026-02-26 03:42:11','2026-02-26 03:42:11');
/*!40000 ALTER TABLE `cs_logs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cs_messages`
--

DROP TABLE IF EXISTS `cs_messages`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `cs_messages` (
  `id` int NOT NULL AUTO_INCREMENT,
  `cs_rooms_id` int NOT NULL,
  `message_sender` enum('Pelapor','Admin','Sistem') COLLATE utf8mb4_unicode_ci NOT NULL,
  `message_content` text COLLATE utf8mb4_unicode_ci,
  `sent_time` datetime DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `cs_messages_cs_rooms_id_foreign` (`cs_rooms_id`),
  CONSTRAINT `cs_messages_cs_rooms_id_foreign` FOREIGN KEY (`cs_rooms_id`) REFERENCES `cs_rooms` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cs_messages`
--

LOCK TABLES `cs_messages` WRITE;
/*!40000 ALTER TABLE `cs_messages` DISABLE KEYS */;
/*!40000 ALTER TABLE `cs_messages` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cs_rooms`
--

DROP TABLE IF EXISTS `cs_rooms`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `cs_rooms` (
  `id` int NOT NULL AUTO_INCREMENT,
  `room_code` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `question_categories_id` int DEFAULT NULL,
  `student_id` int DEFAULT NULL,
  `user_id` int DEFAULT NULL,
  `admin_id` int DEFAULT NULL,
  `chat_status` enum('QnA','ChatBot','Admin') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'QnA',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `cs_rooms_room_code_unique` (`room_code`),
  KEY `cs_rooms_question_categories_id_foreign` (`question_categories_id`),
  KEY `cs_rooms_student_id_foreign` (`student_id`),
  KEY `cs_rooms_user_id_foreign` (`user_id`),
  KEY `cs_rooms_admin_id_foreign` (`admin_id`),
  CONSTRAINT `cs_rooms_admin_id_foreign` FOREIGN KEY (`admin_id`) REFERENCES `admins` (`id`) ON DELETE SET NULL,
  CONSTRAINT `cs_rooms_question_categories_id_foreign` FOREIGN KEY (`question_categories_id`) REFERENCES `question_categories` (`id`) ON DELETE SET NULL,
  CONSTRAINT `cs_rooms_student_id_foreign` FOREIGN KEY (`student_id`) REFERENCES `students` (`id`) ON DELETE SET NULL,
  CONSTRAINT `cs_rooms_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cs_rooms`
--

LOCK TABLES `cs_rooms` WRITE;
/*!40000 ALTER TABLE `cs_rooms` DISABLE KEYS */;
INSERT INTO `cs_rooms` VALUES (1,'0303-2026-OGNV-LAHI',NULL,NULL,NULL,NULL,'QnA','2026-03-03 11:04:36','2026-03-03 11:04:36'),(2,'0303-2026-5GZZ-LKUW',NULL,NULL,NULL,NULL,'QnA','2026-03-03 11:04:45','2026-03-03 11:04:45'),(3,'0303-2026-PRYB-A90K',NULL,NULL,NULL,NULL,'QnA','2026-03-03 11:04:48','2026-03-03 11:04:48'),(4,'0303-2026-7ZFV-PSLH',NULL,NULL,NULL,NULL,'QnA','2026-02-03 11:04:52','2026-03-03 11:04:52'),(5,'0303-2026-WPOW-A07X',NULL,NULL,NULL,NULL,'QnA','2026-02-03 11:04:56','2026-03-03 11:04:56'),(6,'0303-2026-IKDG-8ALN',NULL,NULL,NULL,NULL,'QnA','2026-02-03 11:05:00','2026-03-03 11:05:00'),(7,'0303-2026-AQNO-BFDN',NULL,NULL,NULL,NULL,'QnA','2026-02-03 11:05:07','2026-03-03 11:05:07'),(8,'0303-2026-HT99-2K7L',NULL,NULL,NULL,NULL,'QnA','2026-01-03 11:05:14','2026-03-03 11:05:14'),(9,'0303-2026-JLDL-BE5T',NULL,NULL,NULL,NULL,'QnA','2026-03-03 11:05:24','2026-03-03 11:05:24'),(10,'0303-2026-8WVP-K8VY',NULL,NULL,NULL,NULL,'QnA','2026-03-03 11:05:30','2026-03-03 11:05:30'),(11,'0303-2026-FWVH-CGJL',NULL,NULL,NULL,NULL,'QnA','2026-03-03 11:05:35','2026-03-03 11:05:35');
/*!40000 ALTER TABLE `cs_rooms` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `exercise_items`
--

DROP TABLE IF EXISTS `exercise_items`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `exercise_items` (
  `id` int NOT NULL AUTO_INCREMENT,
  `admin_id` int DEFAULT NULL,
  `user_id` int DEFAULT NULL,
  `competence_id` int DEFAULT NULL,
  `exercise_id` int NOT NULL,
  `exercise_type_id` int NOT NULL,
  `exercise_model_id` int NOT NULL,
  `exercise_choice` tinyint NOT NULL,
  `exercise_number` int NOT NULL,
  `question` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `selection` text COLLATE utf8mb4_unicode_ci,
  `answer` text COLLATE utf8mb4_unicode_ci,
  `is_user` tinyint NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `exercise_items_admin_id_foreign` (`admin_id`),
  KEY `exercise_items_user_id_foreign` (`user_id`),
  KEY `exercise_items_competence_id_foreign` (`competence_id`),
  KEY `exercise_items_exercise_id_foreign` (`exercise_id`),
  KEY `exercise_items_exercise_type_id_foreign` (`exercise_type_id`),
  KEY `exercise_items_exercise_model_id_foreign` (`exercise_model_id`),
  CONSTRAINT `exercise_items_admin_id_foreign` FOREIGN KEY (`admin_id`) REFERENCES `admins` (`id`) ON DELETE SET NULL,
  CONSTRAINT `exercise_items_competence_id_foreign` FOREIGN KEY (`competence_id`) REFERENCES `competences` (`id`) ON DELETE SET NULL,
  CONSTRAINT `exercise_items_exercise_id_foreign` FOREIGN KEY (`exercise_id`) REFERENCES `exercises` (`id`) ON DELETE CASCADE,
  CONSTRAINT `exercise_items_exercise_model_id_foreign` FOREIGN KEY (`exercise_model_id`) REFERENCES `exercise_models` (`id`) ON DELETE CASCADE,
  CONSTRAINT `exercise_items_exercise_type_id_foreign` FOREIGN KEY (`exercise_type_id`) REFERENCES `exercise_types` (`id`) ON DELETE CASCADE,
  CONSTRAINT `exercise_items_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `exercise_items`
--

LOCK TABLES `exercise_items` WRITE;
/*!40000 ALTER TABLE `exercise_items` DISABLE KEYS */;
INSERT INTO `exercise_items` VALUES (1,1,NULL,1,1,1,1,1,1,'<p>Manusia Normal berjalan mengunakan berapa kaki ?</p>','[\"<p>1<\\/p>\",\"<p>2<\\/p>\",\"<p>3<\\/p>\"]','[\"B\"]',0,'2025-12-29 04:55:46','2025-12-29 04:55:46');
/*!40000 ALTER TABLE `exercise_items` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `exercise_models`
--

DROP TABLE IF EXISTS `exercise_models`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `exercise_models` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `exercise_models`
--

LOCK TABLES `exercise_models` WRITE;
/*!40000 ALTER TABLE `exercise_models` DISABLE KEYS */;
INSERT INTO `exercise_models` VALUES (1,'Pilihan Ganda',NULL,NULL),(2,'Pilihan Ganda Banyak',NULL,NULL),(3,'Pernyataan',NULL,NULL),(4,'Isian',NULL,NULL),(5,'Uraian',NULL,NULL),(6,'Iya Tidak',NULL,NULL),(7,'Argumen',NULL,NULL);
/*!40000 ALTER TABLE `exercise_models` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `exercise_points`
--

DROP TABLE IF EXISTS `exercise_points`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `exercise_points` (
  `id` int NOT NULL AUTO_INCREMENT,
  `serial_id` int NOT NULL,
  `exercise_id` int NOT NULL,
  `student_id` int NOT NULL,
  `answer` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `competence_point` text COLLATE utf8mb4_unicode_ci,
  `exercise_point` varchar(3) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `exercise_points_serial_id_foreign` (`serial_id`),
  KEY `exercise_points_exercise_id_foreign` (`exercise_id`),
  KEY `exercise_points_student_id_foreign` (`student_id`),
  CONSTRAINT `exercise_points_exercise_id_foreign` FOREIGN KEY (`exercise_id`) REFERENCES `exercises` (`id`) ON DELETE CASCADE,
  CONSTRAINT `exercise_points_serial_id_foreign` FOREIGN KEY (`serial_id`) REFERENCES `serials` (`id`) ON DELETE CASCADE,
  CONSTRAINT `exercise_points_student_id_foreign` FOREIGN KEY (`student_id`) REFERENCES `students` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `exercise_points`
--

LOCK TABLES `exercise_points` WRITE;
/*!40000 ALTER TABLE `exercise_points` DISABLE KEYS */;
/*!40000 ALTER TABLE `exercise_points` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `exercise_types`
--

DROP TABLE IF EXISTS `exercise_types`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `exercise_types` (
  `id` int NOT NULL AUTO_INCREMENT,
  `kode` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `exercise_types`
--

LOCK TABLES `exercise_types` WRITE;
/*!40000 ALTER TABLE `exercise_types` DISABLE KEYS */;
INSERT INTO `exercise_types` VALUES (1,'UH','Ulangan Harian',NULL,NULL),(2,'PTS','Penilaian Tengah Semester',NULL,NULL),(3,'PAS','Penilaian Akhir Semester',NULL,NULL),(4,'AKM','Asesmen Kompetensi Minimum',NULL,NULL),(5,'ASPD','Asesmen Standardisasi Pendidikan Daerah',NULL,NULL),(6,'TKA','Tes Kemampuan Akademik',NULL,NULL);
/*!40000 ALTER TABLE `exercise_types` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `exercises`
--

DROP TABLE IF EXISTS `exercises`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `exercises` (
  `id` int NOT NULL AUTO_INCREMENT,
  `lesson_id` int NOT NULL,
  `serial_id` int DEFAULT NULL,
  `exercise_type_id` int NOT NULL,
  `title` varchar(200) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_admin` tinyint NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `exercises_lesson_id_foreign` (`lesson_id`),
  KEY `exercises_serial_id_foreign` (`serial_id`),
  KEY `exercises_exercise_type_id_foreign` (`exercise_type_id`),
  CONSTRAINT `exercises_exercise_type_id_foreign` FOREIGN KEY (`exercise_type_id`) REFERENCES `exercise_types` (`id`) ON DELETE CASCADE,
  CONSTRAINT `exercises_lesson_id_foreign` FOREIGN KEY (`lesson_id`) REFERENCES `lessons` (`id`) ON DELETE CASCADE,
  CONSTRAINT `exercises_serial_id_foreign` FOREIGN KEY (`serial_id`) REFERENCES `serials` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `exercises`
--

LOCK TABLES `exercises` WRITE;
/*!40000 ALTER TABLE `exercises` DISABLE KEYS */;
INSERT INTO `exercises` VALUES (1,1,1,1,'Kuis 1',1,'2025-12-29 04:54:25','2025-12-29 04:54:25');
/*!40000 ALTER TABLE `exercises` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `failed_jobs`
--

DROP TABLE IF EXISTS `failed_jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `failed_jobs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
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
-- Table structure for table `helps`
--

DROP TABLE IF EXISTS `helps`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `helps` (
  `id` int NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `priority` int NOT NULL DEFAULT '3',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `helps`
--

LOCK TABLES `helps` WRITE;
/*!40000 ALTER TABLE `helps` DISABLE KEYS */;
/*!40000 ALTER TABLE `helps` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `jobs`
--

DROP TABLE IF EXISTS `jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `jobs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `queue` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` tinyint unsigned NOT NULL,
  `reserved_at` int unsigned DEFAULT NULL,
  `available_at` int unsigned NOT NULL,
  `created_at` int unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `jobs_queue_index` (`queue`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `jobs`
--

LOCK TABLES `jobs` WRITE;
/*!40000 ALTER TABLE `jobs` DISABLE KEYS */;
/*!40000 ALTER TABLE `jobs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `lesson_items`
--

DROP TABLE IF EXISTS `lesson_items`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `lesson_items` (
  `id` int NOT NULL AUTO_INCREMENT,
  `lesson_id` int NOT NULL,
  `theme_id` int NOT NULL,
  `subtheme_id` int NOT NULL,
  `admin_id` int NOT NULL,
  `number` int NOT NULL,
  `title` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `embed` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `lesson_items_lesson_id_foreign` (`lesson_id`),
  KEY `lesson_items_theme_id_foreign` (`theme_id`),
  KEY `lesson_items_subtheme_id_foreign` (`subtheme_id`),
  KEY `lesson_items_admin_id_foreign` (`admin_id`),
  CONSTRAINT `lesson_items_admin_id_foreign` FOREIGN KEY (`admin_id`) REFERENCES `admins` (`id`) ON DELETE CASCADE,
  CONSTRAINT `lesson_items_lesson_id_foreign` FOREIGN KEY (`lesson_id`) REFERENCES `lessons` (`id`) ON DELETE CASCADE,
  CONSTRAINT `lesson_items_subtheme_id_foreign` FOREIGN KEY (`subtheme_id`) REFERENCES `subthemes` (`id`) ON DELETE CASCADE,
  CONSTRAINT `lesson_items_theme_id_foreign` FOREIGN KEY (`theme_id`) REFERENCES `themes` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `lesson_items`
--

LOCK TABLES `lesson_items` WRITE;
/*!40000 ALTER TABLE `lesson_items` DISABLE KEYS */;
INSERT INTO `lesson_items` VALUES (1,1,1,1,1,1,'Mengenal Bagian Tubuhku','<iframe src=\"https://www.youtube.com/embed/nfvOSNVdaM8\" allowfullscreen></iframe> (YouTube)','2025-12-29 04:22:28','2025-12-29 04:22:28'),(2,1,1,1,1,2,'Fungsi Bagian Tubuhku','<iframe src=\"https://www.youtube.com/embed/eERsW4WJASs\" allowfullscreen></iframe> (YouTube)','2025-12-29 04:22:28','2025-12-29 04:22:28'),(3,1,1,2,1,1,'Cara Merawat Tubuhku','<iframe src=\"https://www.youtube.com/embed/abcd1234\" allowfullscreen></iframe>','2025-12-29 04:22:28','2025-12-29 04:22:28'),(4,1,2,3,1,1,'Mengenal Anggota Keluargaku','<iframe src=\"https://www.youtube.com/embed/efgh5678\" allowfullscreen></iframe>','2025-12-29 04:22:28','2025-12-29 04:22:28'),(5,1,3,4,1,1,'Lingkungan Sekitarku','<iframe src=\"https://www.youtube.com/embed/ijkl9012\" allowfullscreen></iframe>','2025-12-29 04:22:28','2025-12-29 04:22:28'),(6,1,4,5,1,1,'Benda di Rumah dan Sekolah','<iframe src=\"https://www.youtube.com/embed/mnop3456\" allowfullscreen></iframe>','2025-12-29 04:22:28','2025-12-29 04:22:28'),(7,1,5,6,1,1,'Perubahan Bentuk Benda','<iframe src=\"https://www.youtube.com/embed/qrst7890\" allowfullscreen></iframe>','2025-12-29 04:22:28','2025-12-29 04:22:28'),(8,1,6,7,1,1,'Kegunaan Benda di Sekitarku','<iframe src=\"https://www.youtube.com/embed/uvwx2345\" allowfullscreen></iframe>','2025-12-29 04:22:28','2025-12-29 04:22:28'),(9,1,7,8,1,1,'Gerak Benda di Sekitarku','<iframe src=\"https://www.youtube.com/embed/yzab3456\" allowfullscreen></iframe>','2025-12-29 04:22:28','2025-12-29 04:22:28'),(10,1,8,9,1,1,'Cuaca dan Musim','<iframe src=\"https://www.youtube.com/embed/cdef5678\" allowfullscreen></iframe>','2025-12-29 04:22:28','2025-12-29 04:22:28'),(11,1,1,1,1,3,'Mengenal Bagian Tubuhku','<iframe src=\"https://www.youtube.com/embed/nfvOSNVdaM8\" allowfullscreen></iframe> (YouTube)','2025-12-29 04:22:30','2025-12-29 04:22:30'),(12,1,1,1,1,4,'Fungsi Bagian Tubuhku','<iframe src=\"https://www.youtube.com/embed/eERsW4WJASs\" allowfullscreen></iframe> (YouTube)','2025-12-29 04:22:30','2025-12-29 04:22:30'),(13,1,1,2,1,2,'Cara Merawat Tubuhku','<iframe src=\"https://www.youtube.com/embed/abcd1234\" allowfullscreen></iframe>','2025-12-29 04:22:30','2025-12-29 04:22:30'),(14,1,2,3,1,2,'Mengenal Anggota Keluargaku','<iframe src=\"https://www.youtube.com/embed/efgh5678\" allowfullscreen></iframe>','2025-12-29 04:22:30','2025-12-29 04:22:30'),(15,1,3,4,1,2,'Lingkungan Sekitarku','<iframe src=\"https://www.youtube.com/embed/ijkl9012\" allowfullscreen></iframe>','2025-12-29 04:22:30','2025-12-29 04:22:30'),(16,1,4,5,1,2,'Benda di Rumah dan Sekolah','<iframe src=\"https://www.youtube.com/embed/mnop3456\" allowfullscreen></iframe>','2025-12-29 04:22:30','2025-12-29 04:22:30'),(17,1,5,6,1,2,'Perubahan Bentuk Benda','<iframe src=\"https://www.youtube.com/embed/qrst7890\" allowfullscreen></iframe>','2025-12-29 04:22:30','2025-12-29 04:22:30'),(18,1,6,7,1,2,'Kegunaan Benda di Sekitarku','<iframe src=\"https://www.youtube.com/embed/uvwx2345\" allowfullscreen></iframe>','2025-12-29 04:22:30','2025-12-29 04:22:30'),(19,1,7,8,1,2,'Gerak Benda di Sekitarku','<iframe src=\"https://www.youtube.com/embed/yzab3456\" allowfullscreen></iframe>','2025-12-29 04:22:30','2025-12-29 04:22:30'),(20,1,8,9,1,2,'Cuaca dan Musim','<iframe src=\"https://www.youtube.com/embed/cdef5678\" allowfullscreen></iframe>','2025-12-29 04:22:30','2025-12-29 04:22:30');
/*!40000 ALTER TABLE `lesson_items` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `lessons`
--

DROP TABLE IF EXISTS `lessons`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `lessons` (
  `id` int NOT NULL AUTO_INCREMENT,
  `mapel_id` int NOT NULL,
  `name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `grade` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `semester` int NOT NULL,
  `category` int NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `lessons_mapel_id_foreign` (`mapel_id`),
  CONSTRAINT `lessons_mapel_id_foreign` FOREIGN KEY (`mapel_id`) REFERENCES `mapels` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `lessons`
--

LOCK TABLES `lessons` WRITE;
/*!40000 ALTER TABLE `lessons` DISABLE KEYS */;
INSERT INTO `lessons` VALUES (1,1,'IPA K 2006','1',1,1,'2025-12-28 13:03:47','2025-12-28 13:03:47'),(2,1,'IPA K 2006','1',2,1,'2025-12-28 13:04:10','2025-12-28 13:04:10'),(3,3,'MTK K 2006','1',1,1,'2025-12-28 13:04:37','2025-12-28 13:04:37'),(4,2,'IPS  2006','1',1,1,'2025-12-28 13:05:07','2025-12-28 13:05:07');
/*!40000 ALTER TABLE `lessons` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `mapels`
--

DROP TABLE IF EXISTS `mapels`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `mapels` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `mapels`
--

LOCK TABLES `mapels` WRITE;
/*!40000 ALTER TABLE `mapels` DISABLE KEYS */;
INSERT INTO `mapels` VALUES (1,'IPA',NULL,NULL),(2,'IPS',NULL,NULL),(3,'MTK',NULL,NULL);
/*!40000 ALTER TABLE `mapels` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `media`
--

DROP TABLE IF EXISTS `media`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `media` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `model_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint unsigned NOT NULL,
  `uuid` char(36) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `collection_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `file_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `mime_type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `disk` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `conversions_disk` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `size` bigint unsigned NOT NULL,
  `manipulations` json NOT NULL,
  `custom_properties` json NOT NULL,
  `generated_conversions` json NOT NULL,
  `responsive_images` json NOT NULL,
  `order_column` int unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `media_uuid_unique` (`uuid`),
  KEY `media_model_type_model_id_index` (`model_type`,`model_id`),
  KEY `media_order_column_index` (`order_column`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `media`
--

LOCK TABLES `media` WRITE;
/*!40000 ALTER TABLE `media` DISABLE KEYS */;
/*!40000 ALTER TABLE `media` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `migrations` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=40 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migrations`
--

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` VALUES (1,'2014_10_12_100000_create_password_reset_tokens_table',1),(2,'2019_08_19_000000_create_failed_jobs_table',1),(3,'2019_12_14_000001_create_personal_access_tokens_table',1),(4,'2025_10_20_000001_create_users_table',1),(5,'2025_10_20_000002_create_admins_table',1),(6,'2025_10_20_000003_create_products_table',1),(7,'2025_10_20_000004_create_serials_table',1),(8,'2025_10_20_000005_create_classrooms_table',1),(9,'2025_10_20_000006_create_students_table',1),(10,'2025_10_20_000007_create_mapels_table',1),(11,'2025_10_20_000008_create_lessons_table',1),(12,'2025_10_20_000009_create_themes_table',1),(13,'2025_10_20_000010_create_subthemes_table',1),(14,'2025_10_20_000011_create_lesson_items_table',1),(15,'2025_10_20_000012_create_competences_table',1),(16,'2025_10_20_000013_create_exercise_types_table',1),(17,'2025_10_20_000014_create_exercise_models_table',1),(18,'2025_10_20_000015_create_exercises_table',1),(19,'2025_10_20_000016_create_exercise_items_table',1),(20,'2025_10_20_000017_create_exercise_points_table',1),(21,'2025_10_20_000018_create_share_exercises_table',1),(22,'2025_10_20_000019_create_posts_table',1),(23,'2025_10_20_000020_create_post_comments_table',1),(24,'2025_10_20_000021_create_post_child_comments_table',1),(25,'2025_10_20_000022_create_tasks_table',1),(26,'2025_10_20_000023_create_reports_table',1),(27,'2025_10_20_000024_create_helps_table',1),(28,'2025_10_20_000025_create_question_categories_table',1),(29,'2025_10_20_000026_create_cs_rooms_table',1),(30,'2025_10_20_000027_create_cs_messages_table',1),(31,'2025_10_20_000028_create_cs_logs_table',1),(32,'2025_10_20_000029_create_cs_files_table',1),(33,'2025_10_20_000030_create_online_meetings_table',1),(34,'2025_10_20_000032_create_serial_logs_table',1),(35,'2025_10_20_040218_create_permission_tables',1),(36,'2025_10_20_040756_create_media_table',1),(37,'2025_11_18_011146_create_jobs_table',1),(38,'2026_02_22_111527_create_unanswered_questions_table',1),(39,'2026_02_26_151324_create_admin_activity_logs_table',1);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `model_has_permissions`
--

DROP TABLE IF EXISTS `model_has_permissions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `model_has_permissions` (
  `permission_id` bigint unsigned NOT NULL,
  `model_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint unsigned NOT NULL,
  PRIMARY KEY (`permission_id`,`model_id`,`model_type`),
  KEY `model_has_permissions_model_id_model_type_index` (`model_id`,`model_type`),
  CONSTRAINT `model_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `model_has_permissions`
--

LOCK TABLES `model_has_permissions` WRITE;
/*!40000 ALTER TABLE `model_has_permissions` DISABLE KEYS */;
/*!40000 ALTER TABLE `model_has_permissions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `model_has_roles`
--

DROP TABLE IF EXISTS `model_has_roles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `model_has_roles` (
  `role_id` bigint unsigned NOT NULL,
  `model_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint unsigned NOT NULL,
  PRIMARY KEY (`role_id`,`model_id`,`model_type`),
  KEY `model_has_roles_model_id_model_type_index` (`model_id`,`model_type`),
  CONSTRAINT `model_has_roles_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `model_has_roles`
--

LOCK TABLES `model_has_roles` WRITE;
/*!40000 ALTER TABLE `model_has_roles` DISABLE KEYS */;
/*!40000 ALTER TABLE `model_has_roles` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `online_meetings`
--

DROP TABLE IF EXISTS `online_meetings`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `online_meetings` (
  `id` int NOT NULL AUTO_INCREMENT,
  `serial_id` int NOT NULL,
  `user_id` int NOT NULL,
  `classroom_id` int NOT NULL,
  `title` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `meeting_code` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `meeting_link` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `platform` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `start_time` datetime NOT NULL,
  `end_time` datetime DEFAULT NULL,
  `status` enum('upcoming','live','ended','cancelled') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'upcoming',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `online_meetings_serial_id_foreign` (`serial_id`),
  KEY `online_meetings_user_id_foreign` (`user_id`),
  KEY `online_meetings_classroom_id_foreign` (`classroom_id`),
  CONSTRAINT `online_meetings_classroom_id_foreign` FOREIGN KEY (`classroom_id`) REFERENCES `classrooms` (`id`) ON DELETE CASCADE,
  CONSTRAINT `online_meetings_serial_id_foreign` FOREIGN KEY (`serial_id`) REFERENCES `serials` (`id`) ON DELETE CASCADE,
  CONSTRAINT `online_meetings_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `online_meetings`
--

LOCK TABLES `online_meetings` WRITE;
/*!40000 ALTER TABLE `online_meetings` DISABLE KEYS */;
/*!40000 ALTER TABLE `online_meetings` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `password_reset_tokens`
--

DROP TABLE IF EXISTS `password_reset_tokens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `password_reset_tokens`
--

LOCK TABLES `password_reset_tokens` WRITE;
/*!40000 ALTER TABLE `password_reset_tokens` DISABLE KEYS */;
/*!40000 ALTER TABLE `password_reset_tokens` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `permissions`
--

DROP TABLE IF EXISTS `permissions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `permissions` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `permissions_name_guard_name_unique` (`name`,`guard_name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `permissions`
--

LOCK TABLES `permissions` WRITE;
/*!40000 ALTER TABLE `permissions` DISABLE KEYS */;
/*!40000 ALTER TABLE `permissions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `personal_access_tokens`
--

DROP TABLE IF EXISTS `personal_access_tokens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `personal_access_tokens` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `tokenable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint unsigned NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `personal_access_tokens`
--

LOCK TABLES `personal_access_tokens` WRITE;
/*!40000 ALTER TABLE `personal_access_tokens` DISABLE KEYS */;
/*!40000 ALTER TABLE `personal_access_tokens` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `post_child_comments`
--

DROP TABLE IF EXISTS `post_child_comments`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `post_child_comments` (
  `id` int NOT NULL AUTO_INCREMENT,
  `post_comment_id` int NOT NULL,
  `user_id` int DEFAULT NULL,
  `student_id` int DEFAULT NULL,
  `message` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_user` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `post_child_comments_post_comment_id_foreign` (`post_comment_id`),
  KEY `post_child_comments_user_id_foreign` (`user_id`),
  KEY `post_child_comments_student_id_foreign` (`student_id`),
  CONSTRAINT `post_child_comments_post_comment_id_foreign` FOREIGN KEY (`post_comment_id`) REFERENCES `post_comments` (`id`) ON DELETE CASCADE,
  CONSTRAINT `post_child_comments_student_id_foreign` FOREIGN KEY (`student_id`) REFERENCES `students` (`id`) ON DELETE SET NULL,
  CONSTRAINT `post_child_comments_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `post_child_comments`
--

LOCK TABLES `post_child_comments` WRITE;
/*!40000 ALTER TABLE `post_child_comments` DISABLE KEYS */;
/*!40000 ALTER TABLE `post_child_comments` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `post_comments`
--

DROP TABLE IF EXISTS `post_comments`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `post_comments` (
  `id` int NOT NULL AUTO_INCREMENT,
  `post_id` int NOT NULL,
  `user_id` int DEFAULT NULL,
  `student_id` int DEFAULT NULL,
  `message` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `code` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_user` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `post_comments_code_unique` (`code`),
  KEY `post_comments_post_id_foreign` (`post_id`),
  KEY `post_comments_user_id_foreign` (`user_id`),
  KEY `post_comments_student_id_foreign` (`student_id`),
  CONSTRAINT `post_comments_post_id_foreign` FOREIGN KEY (`post_id`) REFERENCES `posts` (`id`) ON DELETE CASCADE,
  CONSTRAINT `post_comments_student_id_foreign` FOREIGN KEY (`student_id`) REFERENCES `students` (`id`) ON DELETE SET NULL,
  CONSTRAINT `post_comments_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `post_comments`
--

LOCK TABLES `post_comments` WRITE;
/*!40000 ALTER TABLE `post_comments` DISABLE KEYS */;
/*!40000 ALTER TABLE `post_comments` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `posts`
--

DROP TABLE IF EXISTS `posts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `posts` (
  `id` int NOT NULL AUTO_INCREMENT,
  `serial_id` int NOT NULL,
  `user_id` int NOT NULL,
  `mapel_id` int NOT NULL,
  `title` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `slug` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `link` text COLLATE utf8mb4_unicode_ci,
  `attachment` text COLLATE utf8mb4_unicode_ci,
  `embed` text COLLATE utf8mb4_unicode_ci,
  `category` text COLLATE utf8mb4_unicode_ci,
  `is_task` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `posts_slug_unique` (`slug`),
  KEY `posts_serial_id_foreign` (`serial_id`),
  KEY `posts_user_id_foreign` (`user_id`),
  KEY `posts_mapel_id_foreign` (`mapel_id`),
  CONSTRAINT `posts_mapel_id_foreign` FOREIGN KEY (`mapel_id`) REFERENCES `mapels` (`id`) ON DELETE CASCADE,
  CONSTRAINT `posts_serial_id_foreign` FOREIGN KEY (`serial_id`) REFERENCES `serials` (`id`) ON DELETE CASCADE,
  CONSTRAINT `posts_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `posts`
--

LOCK TABLES `posts` WRITE;
/*!40000 ALTER TABLE `posts` DISABLE KEYS */;
/*!40000 ALTER TABLE `posts` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `products`
--

DROP TABLE IF EXISTS `products`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `products` (
  `id` int NOT NULL AUTO_INCREMENT,
  `lesson_id` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `grade` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `grade_category` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `semester` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `products`
--

LOCK TABLES `products` WRITE;
/*!40000 ALTER TABLE `products` DISABLE KEYS */;
INSERT INTO `products` VALUES (1,'[\"1\",\"3\"]','P1','1','[\"1\"]','1',NULL,NULL);
/*!40000 ALTER TABLE `products` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `question_categories`
--

DROP TABLE IF EXISTS `question_categories`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `question_categories` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `level` enum('Umum','Siswa','Guru') COLLATE utf8mb4_unicode_ci NOT NULL,
  `solution_text` text COLLATE utf8mb4_unicode_ci,
  `guide_file` text COLLATE utf8mb4_unicode_ci,
  `guide_video` text COLLATE utf8mb4_unicode_ci,
  `category_status` enum('Aktif','Tidak Aktif') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Aktif',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=201 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `question_categories`
--

LOCK TABLES `question_categories` WRITE;
/*!40000 ALTER TABLE `question_categories` DISABLE KEYS */;
INSERT INTO `question_categories` VALUES (1,'Apa Itu Aplikasi SCI Media Online','Umum','SCI Media Online adalah platform Learning Management System (LMS) yang dikembangkan untuk mendukung pembelajaran digital jenjang SD, MI, dan SMP. \r<br>Aplikasi ini membantu guru dan siswa dalam:\r<br>1. Mengelola materi pembelajaran.\r<br>2. Memberikan dan mengerjakan tugas.\r<br>3. Melaksanakan ulangan harian, PTS, dan PAS.\r<br>4. Melakukan penilaian otomatis dan rekap nilai.\r<br>Sistem ini dapat diakses secara online melalui web maupun aplikasi Android.','1763656678_p.pdf','<iframe src=\"https://www.youtube.com/embed/XGvhjm2vI7o?si=4b8AwPabGAJ3TG-6\" frameborder=\"0\" allowfullscreen></iframe>','Aktif','2026-03-03 05:27:05','2026-03-03 05:27:05'),(2,'Fungsi dan Manfaat SCI Media Online','Umum','Fungsi utama aplikasi ini adalah membantu proses pembelajaran secara digital dan terstruktur. \r<br>Manfaatnya antara lain:\r<br>1. Guru dapat mengelola kelas dan siswa dengan mudah.\r<br>2. Materi dan video pembelajaran dapat dibagikan langsung.\r<br>3. Nilai ulangan direkap otomatis.\r<br>4. Laporan nilai dapat diunduh dalam bentuk Excel dan PDF.\r<br>5. Siswa dapat belajar dan memantau nilai secara mandiri.','1763656678_p.pdf','<iframe src=\"https://www.youtube.com/embed/XGvhjm2vI7o?si=4b8AwPabGAJ3TG-6\" frameborder=\"0\" allowfullscreen></iframe>','Aktif','2026-03-03 05:27:05','2026-03-03 05:27:05'),(3,'Perangkat yang Dapat Digunakan','Umum','Aplikasi SCI Media Online dapat digunakan melalui:\r<br>1. PC atau Laptop menggunakan browser seperti Chrome atau Mozilla.\r<br>2. Smartphone Android melalui aplikasi resmi di Play Store.\r<br>Pastikan perangkat memiliki koneksi internet yang stabil agar proses pembelajaran berjalan lancar.','1763656678_p.pdf','<iframe src=\"https://www.youtube.com/embed/XGvhjm2vI7o?si=4b8AwPabGAJ3TG-6\" frameborder=\"0\" allowfullscreen></iframe>','Aktif','2026-03-03 05:27:05','2026-03-03 05:27:05'),(4,'Cara Mengakses Website SCI Media Online','Umum','Untuk mengakses melalui website:\r<br>1. Buka browser di perangkat Anda.\r<br>2. Ketik alamat: scimediaonline.com.\r<br>3. Klik menu Login.\r<br>4. Masukkan username dan password.\r<br>Setelah berhasil login, Anda dapat langsung menggunakan fitur sesuai peran (Guru/Siswa).','1763656678_p.pdf','<iframe src=\"https://www.youtube.com/embed/XGvhjm2vI7o?si=4b8AwPabGAJ3TG-6\" frameborder=\"0\" allowfullscreen></iframe>','Aktif','2026-03-03 05:27:05','2026-03-03 05:27:05'),(5,'Cara Mengunduh Aplikasi Android','Umum','Langkah mengunduh aplikasi:\r<br>1. Buka Google Play Store.\r<br>2. Cari \"SCI Media Online\".\r<br>3. Pastikan memilih aplikasi resmi dengan logo SCI Media.\r<br>4. Tekan tombol Install.\r<br>5. Setelah selesai, buka aplikasi dan login menggunakan akun yang diberikan.','1763656678_p.pdf','<iframe src=\"https://www.youtube.com/embed/XGvhjm2vI7o?si=4b8AwPabGAJ3TG-6\" frameborder=\"0\" allowfullscreen></iframe>','Aktif','2026-03-03 05:27:05','2026-03-03 05:27:05'),(6,'Perbedaan Versi Web dan Android','Umum','Versi web dan Android memiliki fitur yang sama. \r<br>Perbedaannya hanya pada:\r<br>1. Tampilan yang menyesuaikan ukuran layar.\r<br>2. Akses lebih praktis melalui aplikasi Android.\r<br>3. Pengalaman pengguna yang disesuaikan dengan perangkat.\r<br>Semua data tetap terintegrasi dalam satu sistem.','1763656678_p.pdf','<iframe src=\"https://www.youtube.com/embed/XGvhjm2vI7o?si=4b8AwPabGAJ3TG-6\" frameborder=\"0\" allowfullscreen></iframe>','Aktif','2026-03-03 05:27:05','2026-03-03 05:27:05'),(7,'Cara Mendapatkan Akun SCI Media Online','Umum','Untuk mendapatkan akun:\r<br>1. Beli produk resmi SCI Media.\r<br>2. Isi formulir lisensi.\r<br>3. Kirim foto lisensi ke admin.\r<br>4. Admin akan mengirimkan username dan password.\r<br>Akun siap digunakan untuk login sebagai guru.','1763656678_p.pdf','<iframe src=\"https://www.youtube.com/embed/XGvhjm2vI7o?si=4b8AwPabGAJ3TG-6\" frameborder=\"0\" allowfullscreen></iframe>','Aktif','2026-03-03 05:27:05','2026-03-03 05:27:05'),(8,'Fitur Rekap Nilai Otomatis','Umum','Sistem secara otomatis merekap:\r<br>1. Nilai Ulangan Harian (UH).\r<br>2. Nilai PTS dan PAS.\r<br>3. Nilai tugas.\r<br>4. Rekap per mata pelajaran.\r<br>Guru dapat mengunduh laporan dalam format Excel atau PDF untuk kebutuhan administrasi.','1763656678_p.pdf','<iframe src=\"https://www.youtube.com/embed/XGvhjm2vI7o?si=4b8AwPabGAJ3TG-6\" frameborder=\"0\" allowfullscreen></iframe>','Aktif','2026-03-03 05:27:05','2026-03-03 05:27:05'),(9,'Fitur Kelas Online Tatap Muka','Umum','SCI Media Online menyediakan fitur kelas virtual yang memungkinkan guru dan siswa berinteraksi secara daring. \r<br>Fitur ini mendukung pembelajaran tatap muka secara online tanpa instalasi rumit dan dapat diakses langsung melalui sistem.','1763656678_p.pdf','<iframe src=\"https://www.youtube.com/embed/XGvhjm2vI7o?si=4b8AwPabGAJ3TG-6\" frameborder=\"0\" allowfullscreen></iframe>','Aktif','2026-03-03 05:27:05','2026-03-03 05:27:05'),(10,'Fitur Pusat Layanan Pelanggan','Umum','Tersedia Pusat Layanan Pelanggan untuk membantu pengguna dalam:\r<br>1. Kendala login.\r<br>2. Lupa password.\r<br>3. Error sistem.\r<br>4. Pertanyaan penggunaan fitur.\r<br>Pengguna dapat membuat layanan baru atau melanjutkan layanan sebelumnya melalui sistem.','1763656678_p.pdf','<iframe src=\"https://www.youtube.com/embed/XGvhjm2vI7o?si=4b8AwPabGAJ3TG-6\" frameborder=\"0\" allowfullscreen></iframe>','Aktif','2026-03-03 05:27:05','2026-03-03 05:27:05'),(11,'Apa Itu Forum Kelas di SCI Media Online','Umum','Forum Kelas adalah ruang pembelajaran digital tempat guru dan siswa berinteraksi.\r<br>Di dalam forum kelas tersedia:\r<br>1. Materi pembelajaran.\r<br>2. Tugas.\r<br>3. Ulangan.\r<br>4. Rekap nilai.\r<br>Forum kelas hanya dapat diakses oleh guru dan siswa yang sudah memiliki akun aktif.','1763656678_p.pdf','<iframe src=\"https://www.youtube.com/embed/XGvhjm2vI7o?si=4b8AwPabGAJ3TG-6\" frameborder=\"0\" allowfullscreen></iframe>','Aktif','2026-03-03 05:51:27','2026-03-03 05:51:27'),(12,'Spesifikasi Minimum Perangkat untuk Mengakses Aplikasi','Umum','Agar aplikasi berjalan optimal, perangkat disarankan memiliki:\r<br>1. Sistem operasi Android versi terbaru atau browser modern pada PC/Laptop.\r<br>2. RAM minimal 2GB.\r<br>3. Koneksi internet stabil.\r<br>Spesifikasi yang memadai membantu aplikasi berjalan lebih lancar tanpa kendala.','1763656678_p.pdf','<iframe src=\"https://www.youtube.com/embed/XGvhjm2vI7o?si=4b8AwPabGAJ3TG-6\" frameborder=\"0\" allowfullscreen></iframe>','Aktif','2026-03-03 05:51:27','2026-03-03 06:31:16'),(13,'Apa yang Terjadi Jika Koneksi Internet Terputus','Umum','Jika koneksi internet terputus:\r<br>1. Proses pengiriman tugas bisa gagal.\r<br>2. Ujian online dapat terganggu.\r<br>3. Sinkronisasi data tidak berjalan.\r<br>Pastikan koneksi stabil sebelum mengerjakan tugas atau ujian.','1763656678_p.pdf','<iframe src=\"https://www.youtube.com/embed/XGvhjm2vI7o?si=4b8AwPabGAJ3TG-6\" frameborder=\"0\" allowfullscreen></iframe>','Aktif','2026-03-03 05:51:27','2026-03-03 06:31:22'),(14,'Bagaimana Cara Mendapatkan Akun Guru','Umum','Untuk mendapatkan akun guru:\r<br>1. Membeli produk Media Ajar SCI Media.\r<br>2. Mengirimkan lisensi ke admin via WhatsApp.\r<br>3. Admin akan membalas dengan username dan password.\r<br>Akun tersebut digunakan untuk mengakses forum kelas.','1763656678_p.pdf','<iframe src=\"https://www.youtube.com/embed/XGvhjm2vI7o?si=4b8AwPabGAJ3TG-6\" frameborder=\"0\" allowfullscreen></iframe>','Aktif','2026-03-03 05:51:27','2026-03-03 05:51:27'),(15,'Apa Fungsi Username dan Password','Umum','Username dan password berfungsi sebagai identitas akun pengguna.\r<br>Akun digunakan untuk:\r<br>1. Login ke sistem.\r<br>2. Mengakses kelas.\r<br>3. Mengelola pembelajaran.\r<br>Pastikan tidak membagikan akun kepada pihak lain demi keamanan data.','1763656678_p.pdf','<iframe src=\"https://www.youtube.com/embed/XGvhjm2vI7o?si=4b8AwPabGAJ3TG-6\" frameborder=\"0\" allowfullscreen></iframe>','Aktif','2026-03-03 05:51:27','2026-03-03 05:51:27'),(16,'Cara Mengelola Data Siswa','Guru','Guru dapat mengelola data siswa dengan cara:\r<br>1. Masuk ke menu Data Siswa.\r<br>2. Tambahkan siswa baru dengan mengisi nama, NIS, username, dan password.\r<br>3. Username harus unik.\r<br>4. Password minimal 6 karakter.\r<br>Guru juga dapat mengedit atau menghapus data siswa sesuai kebutuhan.','1763656678_p.pdf','<iframe src=\"https://www.youtube.com/embed/XGvhjm2vI7o?si=4b8AwPabGAJ3TG-6\" frameborder=\"0\" allowfullscreen></iframe>','Aktif','2026-03-03 05:27:05','2026-03-03 05:27:05'),(17,'Cara Membuat Materi Pembelajaran','Guru','Guru dapat membuat materi pembelajaran dengan:\r<br>1. Masuk ke menu Pembelajaran.\r<br>2. Klik Tambah Materi.\r<br>3. Isi judul dan deskripsi.\r<br>4. Tambahkan link YouTube atau file jika diperlukan.\r<br>5. Klik Kirim.\r<br>Materi akan otomatis tampil pada akun siswa.','1763656678_p.pdf','<iframe src=\"https://www.youtube.com/embed/XGvhjm2vI7o?si=4b8AwPabGAJ3TG-6\" frameborder=\"0\" allowfullscreen></iframe>','Aktif','2026-03-03 05:27:05','2026-03-03 05:27:05'),(18,'Cara Membuat dan Membagikan Soal','Guru','Guru dapat menggunakan soal utama dari bank soal atau membuat soal tambahan sendiri.\r<br>Langkahnya:\r<br>1. Pilih menu Soal.\r<br>2. Klik Buat Soal.\r<br>3. Pilih tipe (UH/PTS/PAS).\r<br>4. Tambahkan pertanyaan dan jawaban.\r<br>5. Klik Share agar aktif di akun siswa.','1763656678_p.pdf','<iframe src=\"https://www.youtube.com/embed/XGvhjm2vI7o?si=4b8AwPabGAJ3TG-6\" frameborder=\"0\" allowfullscreen></iframe>','Aktif','2026-03-03 05:27:05','2026-03-03 05:27:05'),(19,'Cara Mengatur Batas Waktu Pengumpulan Tugas','Guru','Saat membuat tugas, guru dapat menentukan batas waktu pengumpulan.\r<br>Langkahnya:\r<br>1. Masuk ke menu Tugas.\r<br>2. Klik Tambah.\r<br>3. Tentukan tanggal dan jam batas akhir.\r<br>4. Simpan dan kirim.\r<br>Sistem akan otomatis menandai tugas yang terlambat dikumpulkan.','1763656678_p.pdf','<iframe src=\"https://www.youtube.com/embed/XGvhjm2vI7o?si=4b8AwPabGAJ3TG-6\" frameborder=\"0\" allowfullscreen></iframe>','Aktif','2026-03-03 05:27:05','2026-03-03 06:31:31'),(20,'Cara Melihat dan Mengunduh Rekap Nilai','Guru','Guru dapat melihat rekap nilai melalui menu Rekap Nilai.\r<br>Tersedia:\r<br>1. Rekap UH.\r<br>2. Rekap PTS dan PAS.\r<br>3. Rekap tugas.\r<br>4. Rekap per mata pelajaran.\r<br>Klik tombol Excel atau PDF untuk mengunduh laporan.','1763656678_p.pdf','<iframe src=\"https://www.youtube.com/embed/XGvhjm2vI7o?si=4b8AwPabGAJ3TG-6\" frameborder=\"0\" allowfullscreen></iframe>','Aktif','2026-03-03 05:27:05','2026-03-03 05:27:05'),(21,'Cara Mengakses Menu Data Siswa','Guru','Masuk ke Forum Kelas kemudian pilih menu Data Siswa pada sidebar.\r<br>Menu ini digunakan untuk:\r<br>1. Menambah siswa.\r<br>2. Mengedit siswa.\r<br>3. Menghapus siswa.\r<br>4. Melihat laporan siswa.','1763656678_p.pdf','<iframe src=\"https://www.youtube.com/embed/XGvhjm2vI7o?si=4b8AwPabGAJ3TG-6\" frameborder=\"0\" allowfullscreen></iframe>','Aktif','2026-03-03 05:51:27','2026-03-03 05:51:27'),(22,'Cara Memberi Nama Kelas','Guru','Pada menu Data Siswa klik ikon edit nama kelas.\r<br>Masukkan nama kelas, misalnya:\r<br>Kelas IV A atau Kelas V B.\r<br>Klik tombol Save untuk menyimpan perubahan.','1763656678_p.pdf','<iframe src=\"https://www.youtube.com/embed/XGvhjm2vI7o?si=4b8AwPabGAJ3TG-6\" frameborder=\"0\" allowfullscreen></iframe>','Aktif','2026-03-03 05:51:27','2026-03-03 05:51:27'),(23,'Cara Menambahkan Siswa ke Kelas','Guru','Klik menu Data Siswa lalu tekan tombol Tambah.\r<br>Isi data:\r<br>- Nomor Absen\r<br>- Nama\r<br>- NIS\r<br>- Username\r<br>- Password\r<br>Kemudian klik Simpan.','1763656678_p.pdf','<iframe src=\"https://www.youtube.com/embed/XGvhjm2vI7o?si=4b8AwPabGAJ3TG-6\" frameborder=\"0\" allowfullscreen></iframe>','Aktif','2026-03-03 05:51:27','2026-03-03 05:51:27'),(24,'Ketentuan Username dan Password Siswa','Guru','Ketentuan akun siswa:\r<br>1. Username harus unik.\r<br>2. Password minimal 6 karakter.\r<br>3. Password boleh sama dalam satu kelas.\r<br>4. Username tidak dapat diubah kecuali akun dihapus.','1763656678_p.pdf','<iframe src=\"https://www.youtube.com/embed/XGvhjm2vI7o?si=4b8AwPabGAJ3TG-6\" frameborder=\"0\" allowfullscreen></iframe>','Aktif','2026-03-03 05:51:27','2026-03-03 05:51:27'),(25,'Cara Mengedit Data Siswa','Guru','Masuk ke menu Data Siswa.\r<br>Klik tombol Edit (ikon pensil).\r<br>Perbarui data yang diperlukan kemudian klik Simpan.','1763656678_p.pdf','<iframe src=\"https://www.youtube.com/embed/XGvhjm2vI7o?si=4b8AwPabGAJ3TG-6\" frameborder=\"0\" allowfullscreen></iframe>','Aktif','2026-03-03 05:51:27','2026-03-03 05:51:27'),(26,'Cara Menghapus Siswa dari Kelas','Guru','Masuk ke menu Data Siswa.\r<br>Klik tombol Hapus (ikon tong sampah).\r<br>Konfirmasi penghapusan pada popup yang muncul.','1763656678_p.pdf','<iframe src=\"https://www.youtube.com/embed/XGvhjm2vI7o?si=4b8AwPabGAJ3TG-6\" frameborder=\"0\" allowfullscreen></iframe>','Aktif','2026-03-03 05:51:27','2026-03-03 05:51:27'),(27,'Cara Melihat Laporan Harian KI1 dan KI2','Guru','Masuk ke Data Siswa.\r<br>Klik menu pada nama siswa lalu pilih Laporan.\r<br>Klik Detail untuk melihat laporan KI 1 dan KI 2 yang telah diinput siswa.','1763656678_p.pdf','<iframe src=\"https://www.youtube.com/embed/XGvhjm2vI7o?si=4b8AwPabGAJ3TG-6\" frameborder=\"0\" allowfullscreen></iframe>','Aktif','2026-03-03 05:51:27','2026-03-03 05:51:27'),(28,'Cara Melihat Tugas yang Dikumpulkan Siswa','Guru','Masuk ke Data Siswa.\r<br>Klik nama siswa lalu pilih Tugas.\r<br>Klik Buka untuk melihat file dan beri penilaian.','1763656678_p.pdf','<iframe src=\"https://www.youtube.com/embed/XGvhjm2vI7o?si=4b8AwPabGAJ3TG-6\" frameborder=\"0\" allowfullscreen></iframe>','Aktif','2026-03-03 05:51:27','2026-03-03 05:51:27'),(29,'Cara Memberikan Nilai Tugas','Guru','Klik tombol Berikan Penilaian.\r<br>Masukkan komentar dan nilai.\r<br>Klik Kirim agar nilai tampil di akun siswa.','1763656678_p.pdf','<iframe src=\"https://www.youtube.com/embed/XGvhjm2vI7o?si=4b8AwPabGAJ3TG-6\" frameborder=\"0\" allowfullscreen></iframe>','Aktif','2026-03-03 05:51:27','2026-03-03 05:51:27'),(30,'Cara Mereset Nilai Ulangan','Guru','Masuk ke menu Ulangan siswa.\r<br>Klik tombol Reset Nilai.\r<br>Fitur ini digunakan jika ingin mengulang penilaian.','1763656678_p.pdf','<iframe src=\"https://www.youtube.com/embed/XGvhjm2vI7o?si=4b8AwPabGAJ3TG-6\" frameborder=\"0\" allowfullscreen></iframe>','Aktif','2026-03-03 05:51:27','2026-03-03 05:51:27'),(31,'Cara Melihat Materi dari Guru','Siswa','Siswa dapat melihat materi dengan:\r<br>1. Login menggunakan akun siswa.\r<br>2. Masuk ke menu Pembelajaran.\r<br>3. Pilih materi yang dibagikan guru.\r<br>Materi dapat berupa teks, video, atau file yang dapat diunduh.','1763656678_p.pdf','<iframe src=\"https://www.youtube.com/embed/XGvhjm2vI7o?si=4b8AwPabGAJ3TG-6\" frameborder=\"0\" allowfullscreen></iframe>','Aktif','2026-03-03 05:27:05','2026-03-03 05:27:05'),(32,'Cara Mengerjakan Tugas','Siswa','Untuk mengerjakan tugas:\r<br>1. Masuk ke menu Tugas.\r<br>2. Klik Buka Tugas.\r<br>3. Kerjakan sesuai instruksi.\r<br>4. Unggah file jika diminta.\r<br>5. Klik Kirim.\r<br>Nilai akan diberikan oleh guru setelah diperiksa.','1763656678_p.pdf','<iframe src=\"https://www.youtube.com/embed/XGvhjm2vI7o?si=4b8AwPabGAJ3TG-6\" frameborder=\"0\" allowfullscreen></iframe>','Aktif','2026-03-03 05:27:05','2026-03-03 05:27:05'),(33,'Cara Mengerjakan Soal Ulangan','Siswa','Siswa dapat mengerjakan soal dengan:\r<br>1. Masuk ke menu Soal.\r<br>2. Pilih ulangan yang aktif.\r<br>3. Jawab setiap pertanyaan.\r<br>4. Klik Selesai.\r<br>Nilai akan langsung muncul jika sistem menggunakan penilaian otomatis.','1763656678_p.pdf','<iframe src=\"https://www.youtube.com/embed/XGvhjm2vI7o?si=4b8AwPabGAJ3TG-6\" frameborder=\"0\" allowfullscreen></iframe>','Aktif','2026-03-03 05:27:05','2026-03-03 05:27:05'),(34,'Cara Melihat Nilai','Siswa','Siswa dapat melihat nilai melalui menu Nilai atau Hasil Ulangan.\r<br>Nilai yang dapat dilihat meliputi:\r<br>1. Nilai ulangan harian.\r<br>2. Nilai PTS dan PAS.\r<br>3. Nilai tugas.\r<br>Semua nilai tersimpan dan dapat diakses kapan saja.','1763656678_p.pdf','<iframe src=\"https://www.youtube.com/embed/XGvhjm2vI7o?si=4b8AwPabGAJ3TG-6\" frameborder=\"0\" allowfullscreen></iframe>','Aktif','2026-03-03 05:27:05','2026-03-03 05:27:05'),(35,'Cara Mengatur Struktur Forum Kelas','Guru','Forum kelas dapat diatur agar pembelajaran lebih rapi dan terstruktur.\r<br>Langkah yang dapat dilakukan:\r<br>1. Susun materi berdasarkan urutan pembelajaran.\r<br>2. Beri judul yang jelas pada setiap postingan.\r<br>3. Pisahkan materi, tugas, dan ulangan.\r<br>4. Gunakan deskripsi yang informatif.\r<br>Pengaturan yang baik akan memudahkan siswa memahami alur belajar.','1763656678_p.pdf','<iframe src=\"https://www.youtube.com/embed/XGvhjm2vI7o?si=4b8AwPabGAJ3TG-6\" frameborder=\"0\" allowfullscreen></iframe>','Aktif','2026-03-03 06:20:34','2026-03-03 06:20:34'),(36,'Cara Mengontrol Akses Materi Siswa','Guru','Guru memiliki kendali penuh atas materi yang ditampilkan.\r<br>Untuk mengatur akses:\r<br>1. Gunakan fitur Share untuk menampilkan materi.\r<br>2. Gunakan fitur Hide untuk menyembunyikan materi.\r<br>3. Pastikan materi hanya aktif saat dibutuhkan.\r<br>Hal ini membantu pembelajaran lebih terfokus dan tidak membingungkan siswa.','1763656678_p.pdf','<iframe src=\"https://www.youtube.com/embed/XGvhjm2vI7o?si=4b8AwPabGAJ3TG-6\" frameborder=\"0\" allowfullscreen></iframe>','Aktif','2026-03-03 06:20:34','2026-03-03 06:20:34'),(37,'Cara Mengatur Waktu Ulangan','Guru','Guru dapat mengatur batas waktu pengerjaan soal.\r<br>Caranya:\r<br>1. Saat membuat soal pilih pengaturan waktu.\r<br>2. Tentukan durasi (misalnya 60 menit).\r<br>3. Simpan dan aktifkan.\r<br>Setelah waktu habis, sistem akan menutup otomatis akses siswa.','1763656678_p.pdf','<iframe src=\"https://www.youtube.com/embed/XGvhjm2vI7o?si=4b8AwPabGAJ3TG-6\" frameborder=\"0\" allowfullscreen></iframe>','Aktif','2026-03-03 05:27:05','2026-03-03 05:27:05'),(38,'Cara Mengacak Soal Otomatis','Guru','Sistem menyediakan fitur pengacakan soal agar setiap siswa mendapat urutan berbeda.\r<br>Aktifkan opsi Acak Soal saat membuat ujian.\r<br>Fitur ini membantu meminimalisir kecurangan saat ujian berlangsung.','1763656678_p.pdf','<iframe src=\"https://www.youtube.com/embed/XGvhjm2vI7o?si=4b8AwPabGAJ3TG-6\" frameborder=\"0\" allowfullscreen></iframe>','Aktif','2026-03-03 05:27:05','2026-03-03 05:27:05'),(39,'Cara Menambahkan Video Pembelajaran','Guru','Guru dapat menyisipkan video YouTube pada materi.\r<br>Langkah:\r<br>1. Salin link video YouTube.\r<br>2. Tempel pada kolom link video saat membuat materi.\r<br>3. Klik Simpan.\r<br>Video akan tampil langsung di akun siswa.','1763656678_p.pdf','<iframe src=\"https://www.youtube.com/embed/XGvhjm2vI7o?si=4b8AwPabGAJ3TG-6\" frameborder=\"0\" allowfullscreen></iframe>','Aktif','2026-03-03 05:27:05','2026-03-03 05:27:05'),(40,'Cara Mengunduh Nilai dalam Format Excel','Guru','Untuk kebutuhan administrasi sekolah:\r<br>1. Masuk menu Rekap Nilai.\r<br>2. Pilih kelas dan mata pelajaran.\r<br>3. Klik tombol Export Excel.\r<br>File akan otomatis terunduh dan dapat dibuka di Microsoft Excel.','1763656678_p.pdf','<iframe src=\"https://www.youtube.com/embed/XGvhjm2vI7o?si=4b8AwPabGAJ3TG-6\" frameborder=\"0\" allowfullscreen></iframe>','Aktif','2026-03-03 05:27:05','2026-03-03 05:27:05'),(41,'Cara Mengunduh Nilai dalam Format PDF','Guru','Sistem menyediakan laporan PDF siap cetak.\r<br>Langkah:\r<br>1. Masuk menu Rekap Nilai.\r<br>2. Klik Export PDF.\r<br>3. File akan tersimpan di perangkat.\r<br>Format ini cocok untuk arsip dan laporan resmi.','1763656678_p.pdf','<iframe src=\"https://www.youtube.com/embed/XGvhjm2vI7o?si=4b8AwPabGAJ3TG-6\" frameborder=\"0\" allowfullscreen></iframe>','Aktif','2026-03-03 05:27:05','2026-03-03 05:27:05'),(42,'Cara Membuat Soal Tambahan Sendiri','Guru','Selain soal utama, guru dapat membuat soal tambahan.\r<br>1. Pilih menu Soal Tambahan.\r<br>2. Klik Tambah Soal.\r<br>3. Isi pertanyaan dan pilihan jawaban.\r<br>4. Tentukan kunci jawaban.\r<br>5. Simpan dan aktifkan.','1763656678_p.pdf','<iframe src=\"https://www.youtube.com/embed/XGvhjm2vI7o?si=4b8AwPabGAJ3TG-6\" frameborder=\"0\" allowfullscreen></iframe>','Aktif','2026-03-03 05:27:05','2026-03-03 05:27:05'),(43,'Cara Mengaktifkan dan Menonaktifkan Soal','Guru','Guru dapat mengontrol kapan soal dapat dikerjakan.\r<br>1. Masuk ke daftar soal.\r<br>2. Klik tombol Aktif/Nonaktif.\r<br>Soal hanya dapat dikerjakan siswa jika statusnya aktif.','1763656678_p.pdf','<iframe src=\"https://www.youtube.com/embed/XGvhjm2vI7o?si=4b8AwPabGAJ3TG-6\" frameborder=\"0\" allowfullscreen></iframe>','Aktif','2026-03-03 05:27:05','2026-03-03 05:27:05'),(44,'Cara Menggunakan Fitur Kelas Online','Guru','Untuk memulai kelas tatap muka online:\r<br>1. Masuk ke menu Kelas Online.\r<br>2. Buat jadwal pertemuan.\r<br>3. Bagikan link kepada siswa.\r<br>Guru dan siswa dapat bergabung pada waktu yang ditentukan.','1763656678_p.pdf','<iframe src=\"https://www.youtube.com/embed/XGvhjm2vI7o?si=4b8AwPabGAJ3TG-6\" frameborder=\"0\" allowfullscreen></iframe>','Aktif','2026-03-03 05:27:05','2026-03-03 05:27:05'),(45,'Cara Membuat Kegiatan Pembelajaran Sendiri','Guru','Untuk membuat Kegiatan pembelajaran mandiri:\r<br>1. Masuk ke menu Kegiatan Pembelajaran.\r<br>2. Klik tombol Tambah.\r<br>3. Isi judul dan deskripsi materi.\r<br>4. Tambahkan link atau lampiran jika diperlukan.\r<br>5. Klik Kirim agar materi tampil di kelas.\r<br>\r<br>','1763656678_p.pdf','<iframe src=\"https://www.youtube.com/embed/XGvhjm2vI7o?si=4b8AwPabGAJ3TG-6\" frameborder=\"0\" allowfullscreen></iframe>','Aktif','2026-03-03 05:52:14','2026-03-03 05:52:14'),(46,'Cara Melampirkan File pada Materi','Guru','Saat membuat materi:\r<br>1. Klik Tambahkan Lampiran.\r<br>2. Pilih file dari perangkat (dokumen, gambar, atau video).\r<br>3. Pastikan file berhasil terupload.\r<br>4. Klik Kirim untuk mempublikasikan.','1763656678_p.pdf','<iframe src=\"https://www.youtube.com/embed/XGvhjm2vI7o?si=4b8AwPabGAJ3TG-6\" frameborder=\"0\" allowfullscreen></iframe>','Aktif','2026-03-03 05:52:14','2026-03-03 05:52:14'),(47,'Cara Membagikan Materi dari SCI Media','Guru','Masuk ke menu Materi Ajar.\r<br>Pilih tema, subtema, dan pelajaran.\r<br>Klik Share pada materi yang dipilih.\r<br>Materi otomatis tampil pada kegiatan pembelajaran siswa.','1763656678_p.pdf','<iframe src=\"https://www.youtube.com/embed/XGvhjm2vI7o?si=4b8AwPabGAJ3TG-6\" frameborder=\"0\" allowfullscreen></iframe>','Aktif','2026-03-03 05:52:14','2026-03-03 05:52:14'),(48,'Cara Mengubah Judul Saat Share Materi','Guru','Sebelum menekan tombol Share, guru dapat mengedit judul dan menambahkan pesan.\r<br>Judul bisa disesuaikan dengan kebutuhan kelas.','1763656678_p.pdf','<iframe src=\"https://www.youtube.com/embed/XGvhjm2vI7o?si=4b8AwPabGAJ3TG-6\" frameborder=\"0\" allowfullscreen></iframe>','Aktif','2026-03-03 05:52:14','2026-03-03 05:52:14'),(49,'Cara Memberikan Tugas ke Siswa','Guru','Masuk ke menu Tugas.\r<br>Klik Tambah.\r<br>Isi mata pelajaran, judul, dan keterangan.\r<br>Tambahkan link atau file jika perlu.\r<br>Klik Kirim agar tugas aktif.','1763656678_p.pdf','<iframe src=\"https://www.youtube.com/embed/XGvhjm2vI7o?si=4b8AwPabGAJ3TG-6\" frameborder=\"0\" allowfullscreen></iframe>','Aktif','2026-03-03 05:52:14','2026-03-03 05:52:14'),(50,'Cara Memposting Soal dari SCI Media','Guru','Masuk ke menu Soal → Soal Utama.\r<br>Klik Open untuk melihat soal.\r<br>Klik Share agar soal aktif dan bisa dikerjakan siswa.','1763656678_p.pdf','<iframe src=\"https://www.youtube.com/embed/XGvhjm2vI7o?si=4b8AwPabGAJ3TG-6\" frameborder=\"0\" allowfullscreen></iframe>','Aktif','2026-03-03 05:52:14','2026-03-03 05:52:14'),(51,'Cara Menampilkan Kunci Jawaban','Guru','Pada halaman soal, klik tombol Show.\r<br>Kunci jawaban akan tampil dan dapat digunakan untuk pengecekan.','1763656678_p.pdf','<iframe src=\"https://www.youtube.com/embed/XGvhjm2vI7o?si=4b8AwPabGAJ3TG-6\" frameborder=\"0\" allowfullscreen></iframe>','Aktif','2026-03-03 05:52:14','2026-03-03 05:52:14'),(52,'Cara Menyembunyikan Soal dari Siswa','Guru','Klik tombol Hide pada soal yang sudah dibagikan.\r<br>Soal tidak lagi terlihat di akun siswa.','1763656678_p.pdf','<iframe src=\"https://www.youtube.com/embed/XGvhjm2vI7o?si=4b8AwPabGAJ3TG-6\" frameborder=\"0\" allowfullscreen></iframe>','Aktif','2026-03-03 05:52:14','2026-03-03 05:52:14'),(53,'Cara Membuat Soal Tambahan Mandiri','Guru','Masuk ke menu Soal → Soal Tambahan.\r<br>Klik Buat Soal.\r<br>Pilih tipe (UH, PTS, PAS), isi judul lalu klik Create.','1763656678_p.pdf','<iframe src=\"https://www.youtube.com/embed/XGvhjm2vI7o?si=4b8AwPabGAJ3TG-6\" frameborder=\"0\" allowfullscreen></iframe>','Aktif','2026-03-03 05:52:14','2026-03-03 05:52:14'),(54,'Cara Menambahkan Pertanyaan pada Soal Tambahan','Guru','Klik Open pada soal.\r<br>Klik Tambah Soal.\r<br>Isi pertanyaan, pilihan jawaban, dan tentukan jawaban benar.\r<br>Klik Simpan.','1763656678_p.pdf','<iframe src=\"https://www.youtube.com/embed/XGvhjm2vI7o?si=4b8AwPabGAJ3TG-6\" frameborder=\"0\" allowfullscreen></iframe>','Aktif','2026-03-03 05:52:14','2026-03-03 05:52:14'),(55,'Cara Mengedit atau Menghapus Soal','Guru','Pada daftar soal:\r<br>- Klik ikon pensil untuk mengedit.\r<br>- Klik ikon silang untuk menghapus.\r<br>Pastikan perubahan disimpan.','1763656678_p.pdf','<iframe src=\"https://www.youtube.com/embed/XGvhjm2vI7o?si=4b8AwPabGAJ3TG-6\" frameborder=\"0\" allowfullscreen></iframe>','Aktif','2026-03-03 05:52:14','2026-03-03 05:52:14'),(56,'Cara Mengganti Password Akun','Siswa','Siswa dapat mengganti password untuk keamanan akun.\r<br>Langkah:\r<br>1. Masuk ke menu Profil.\r<br>2. Klik Ubah Password.\r<br>3. Masukkan password lama dan password baru.\r<br>4. Klik Simpan.\r<br>Gunakan kombinasi huruf dan angka agar lebih aman.','1763656678_p.pdf','<iframe src=\"https://www.youtube.com/embed/XGvhjm2vI7o?si=4b8AwPabGAJ3TG-6\" frameborder=\"0\" allowfullscreen></iframe>','Aktif','2026-03-03 05:27:05','2026-03-03 05:27:05'),(57,'Apa yang Harus Dilakukan Jika Soal Tidak Muncul','Siswa','Jika soal tidak muncul:\r<br>1. Periksa koneksi internet.\r<br>2. Pastikan soal sudah diaktifkan guru.\r<br>3. Refresh halaman.\r<br>4. Logout lalu login kembali.\r<br>Jika masih bermasalah, hubungi guru.','1763656678_p.pdf','<iframe src=\"https://www.youtube.com/embed/XGvhjm2vI7o?si=4b8AwPabGAJ3TG-6\" frameborder=\"0\" allowfullscreen></iframe>','Aktif','2026-03-03 05:27:05','2026-03-03 05:27:05'),(58,'Apa yang Harus Dilakukan Jika Gagal Login','Siswa','Jika gagal login:\r<br>1. Periksa username dan password.\r<br>2. Pastikan huruf besar/kecil benar.\r<br>3. Coba ulangi beberapa saat.\r<br>4. Hubungi guru jika tetap tidak bisa masuk.','1763656678_p.pdf','<iframe src=\"https://www.youtube.com/embed/XGvhjm2vI7o?si=4b8AwPabGAJ3TG-6\" frameborder=\"0\" allowfullscreen></iframe>','Aktif','2026-03-03 05:27:05','2026-03-03 05:27:05'),(59,'Cara Mengikuti Kelas Online','Siswa','Untuk mengikuti kelas online:\r<br>1. Login ke akun siswa.\r<br>2. Masuk menu Kelas Online.\r<br>3. Klik link pertemuan yang tersedia.\r<br>4. Bergabung sesuai jadwal yang ditentukan guru.','1763656678_p.pdf','<iframe src=\"https://www.youtube.com/embed/XGvhjm2vI7o?si=4b8AwPabGAJ3TG-6\" frameborder=\"0\" allowfullscreen></iframe>','Aktif','2026-03-03 05:27:05','2026-03-03 05:27:05'),(60,'Cara Melihat Riwayat Nilai','Siswa','Siswa dapat melihat riwayat nilai pada menu Nilai.\r<br>Riwayat mencakup:\r<br>1. Nilai tugas.\r<br>2. Nilai ulangan.\r<br>3. Nilai PTS dan PAS.\r<br>Semua nilai tersimpan selama akun aktif.','1763656678_p.pdf','<iframe src=\"https://www.youtube.com/embed/XGvhjm2vI7o?si=4b8AwPabGAJ3TG-6\" frameborder=\"0\" allowfullscreen></iframe>','Aktif','2026-03-03 05:27:05','2026-03-03 05:27:05'),(61,'Cara Share Soal Tambahan ke Siswa','Guru','Setelah selesai membuat soal tambahan, kembali ke deskripsi soal dan klik Share.\r<br>Tanda centang hijau menandakan soal sudah aktif.','1763656678_p.pdf','<iframe src=\"https://www.youtube.com/embed/XGvhjm2vI7o?si=4b8AwPabGAJ3TG-6\" frameborder=\"0\" allowfullscreen></iframe>','Aktif','2026-03-03 05:52:14','2026-03-03 05:52:14'),(62,'Cara Melihat Rekap Nilai Siswa','Guru','Masuk ke menu Rekap Nilai.\r<br>Pilih jenis rekap: UH, PTS, atau PAS.\r<br>Nilai akan tampil dalam bentuk tabel.','1763656678_p.pdf','<iframe src=\"https://www.youtube.com/embed/XGvhjm2vI7o?si=4b8AwPabGAJ3TG-6\" frameborder=\"0\" allowfullscreen></iframe>','Aktif','2026-03-03 05:52:14','2026-03-03 05:52:14'),(63,'Cara Download Rekap Nilai Excel','Guru','Pada halaman rekap, klik tombol Excel.\r<br>File akan otomatis terunduh dalam format .xlsx.','1763656678_p.pdf','<iframe src=\"https://www.youtube.com/embed/XGvhjm2vI7o?si=4b8AwPabGAJ3TG-6\" frameborder=\"0\" allowfullscreen></iframe>','Aktif','2026-03-03 05:52:14','2026-03-03 05:52:14'),(64,'Cara Download Rekap Nilai PDF','Guru','Klik tombol PDF pada halaman rekap.\r<br>File akan terdownload dalam format PDF siap cetak.','1763656678_p.pdf','<iframe src=\"https://www.youtube.com/embed/XGvhjm2vI7o?si=4b8AwPabGAJ3TG-6\" frameborder=\"0\" allowfullscreen></iframe>','Aktif','2026-03-03 05:52:14','2026-03-03 05:52:14'),(65,'Cara Melihat Rekap Nilai Per Mapel','Guru','Klik tombol Rekap Nilai Per Mapel.\r<br>Sistem akan menampilkan nilai siswa berdasarkan mata pelajaran.','1763656678_p.pdf','<iframe src=\"https://www.youtube.com/embed/XGvhjm2vI7o?si=4b8AwPabGAJ3TG-6\" frameborder=\"0\" allowfullscreen></iframe>','Aktif','2026-03-03 05:52:14','2026-03-03 05:52:14'),(66,'Cara Keluar dari Forum Kelas','Guru','Klik menu Keluar pada sidebar.\r<br>Anda akan kembali ke halaman utama akun.','1763656678_p.pdf','<iframe src=\"https://www.youtube.com/embed/XGvhjm2vI7o?si=4b8AwPabGAJ3TG-6\" frameborder=\"0\" allowfullscreen></iframe>','Aktif','2026-03-03 05:52:14','2026-03-03 05:52:14'),(67,'Cara Logout dari Aplikasi','Guru','Klik tombol Logout di pojok kanan atas setelah keluar dari forum kelas.\r<br>Ini untuk menjaga keamanan akun.','1763656678_p.pdf','<iframe src=\"https://www.youtube.com/embed/XGvhjm2vI7o?si=4b8AwPabGAJ3TG-6\" frameborder=\"0\" allowfullscreen></iframe>','Aktif','2026-03-03 05:52:14','2026-03-03 05:52:14'),(68,'Cara Konsultasi ke Admin','Guru','Jika mengalami kendala, hubungi admin melalui WhatsApp resmi.\r<br>Sertakan detail masalah agar dapat dibantu lebih cepat.','1763656678_p.pdf','<iframe src=\"https://www.youtube.com/embed/XGvhjm2vI7o?si=4b8AwPabGAJ3TG-6\" frameborder=\"0\" allowfullscreen></iframe>','Aktif','2026-03-03 05:52:14','2026-03-03 05:52:14'),(69,'Cara Menggunakan Fitur Print Soal','Guru','Pada halaman soal klik tombol Print.\r<br>Soal akan terbuka dalam format siap cetak.','1763656678_p.pdf','<iframe src=\"https://www.youtube.com/embed/XGvhjm2vI7o?si=4b8AwPabGAJ3TG-6\" frameborder=\"0\" allowfullscreen></iframe>','Aktif','2026-03-03 05:52:14','2026-03-03 05:52:14'),(70,'Apa Fungsi Tombol Open pada Soal','Guru','Tombol Open digunakan untuk melihat detail isi soal sebelum dibagikan kepada siswa.','1763656678_p.pdf','<iframe src=\"https://www.youtube.com/embed/XGvhjm2vI7o?si=4b8AwPabGAJ3TG-6\" frameborder=\"0\" allowfullscreen></iframe>','Aktif','2026-03-03 05:52:14','2026-03-03 05:52:14'),(71,'Cara Menghubungi Admin SCI Media','Umum','Untuk bantuan lebih lanjut, pengguna dapat menghubungi admin resmi SCI Media melalui WhatsApp atau Pusat Layanan Pelanggan yang tersedia di website resmi.','1763656678_p.pdf','<iframe src=\"https://www.youtube.com/embed/XGvhjm2vI7o?si=4b8AwPabGAJ3TG-6\" frameborder=\"0\" allowfullscreen></iframe>','Aktif','2026-03-03 05:27:05','2026-03-03 05:27:05'),(72,'Keamanan Data Pengguna','Umum','SCI Media Online menjaga keamanan data guru dan siswa.\r<br>Data login bersifat pribadi dan tidak boleh dibagikan kepada pihak lain.\r<br>Gunakan password yang kuat dan rutin menggantinya.','1763656678_p.pdf','<iframe src=\"https://www.youtube.com/embed/XGvhjm2vI7o?si=4b8AwPabGAJ3TG-6\" frameborder=\"0\" allowfullscreen></iframe>','Aktif','2026-03-03 05:27:05','2026-03-03 05:27:05'),(73,'Apakah Data Akan Hilang Jika Logout','Umum','Logout hanya mengeluarkan akun dari perangkat.\r<br>Semua data seperti nilai, materi, dan tugas tetap tersimpan di server dan dapat diakses kembali saat login ulang.','1763656678_p.pdf','<iframe src=\"https://www.youtube.com/embed/XGvhjm2vI7o?si=4b8AwPabGAJ3TG-6\" frameborder=\"0\" allowfullscreen></iframe>','Aktif','2026-03-03 05:27:05','2026-03-03 05:27:05'),(74,'Apakah Bisa Digunakan Lebih dari Satu Perangkat','Umum','Akun dapat digunakan di beberapa perangkat, namun tidak disarankan login bersamaan untuk menghindari konflik data atau logout otomatis.','1763656678_p.pdf','<iframe src=\"https://www.youtube.com/embed/XGvhjm2vI7o?si=4b8AwPabGAJ3TG-6\" frameborder=\"0\" allowfullscreen></iframe>','Aktif','2026-03-03 05:27:05','2026-03-03 05:27:05'),(75,'Apakah Aplikasi Membutuhkan Internet','Umum','Ya, SCI Media Online memerlukan koneksi internet karena semua data tersimpan secara online dan sinkron secara real-time.','1763656678_p.pdf','<iframe src=\"https://www.youtube.com/embed/XGvhjm2vI7o?si=4b8AwPabGAJ3TG-6\" frameborder=\"0\" allowfullscreen></iframe>','Aktif','2026-03-03 05:27:05','2026-03-03 05:27:05'),(76,'Apa yang Harus Dilakukan Jika Sistem Error','Umum','Jika terjadi error:\r<br>1. Refresh halaman.\r<br>2. Periksa koneksi internet.\r<br>3. Logout dan login ulang.\r<br>4. Hubungi admin jika masalah berlanjut.','1763656678_p.pdf','<iframe src=\"https://www.youtube.com/embed/XGvhjm2vI7o?si=4b8AwPabGAJ3TG-6\" frameborder=\"0\" allowfullscreen></iframe>','Aktif','2026-03-03 05:27:05','2026-03-03 05:27:05'),(77,'Manfaat Pembelajaran Digital','Umum','Pembelajaran digital membantu:\r<br>1. Efisiensi waktu.\r<br>2. Pengurangan penggunaan kertas.\r<br>3. Monitoring nilai real-time.\r<br>4. Akses materi kapan saja dan di mana saja.','1763656678_p.pdf','<iframe src=\"https://www.youtube.com/embed/XGvhjm2vI7o?si=4b8AwPabGAJ3TG-6\" frameborder=\"0\" allowfullscreen></iframe>','Aktif','2026-03-03 05:27:05','2026-03-03 05:27:05'),(78,'Apakah Nilai Bisa Dicetak','Umum','Ya, guru dapat mencetak nilai melalui fitur export PDF atau Excel yang tersedia pada menu Rekap Nilai.','1763656678_p.pdf','<iframe src=\"https://www.youtube.com/embed/XGvhjm2vI7o?si=4b8AwPabGAJ3TG-6\" frameborder=\"0\" allowfullscreen></iframe>','Aktif','2026-03-03 05:27:05','2026-03-03 05:27:05'),(79,'Siapa Saja yang Bisa Menggunakan Aplikasi Ini','Umum','Aplikasi ini dirancang untuk:\r<br>1. Guru SD, MI, dan SMP.\r<br>2. Siswa SD, MI, dan SMP.\r<br>3. Sekolah yang ingin menerapkan pembelajaran digital.','1763656678_p.pdf','<iframe src=\"https://www.youtube.com/embed/XGvhjm2vI7o?si=4b8AwPabGAJ3TG-6\" frameborder=\"0\" allowfullscreen></iframe>','Aktif','2026-03-03 05:27:05','2026-03-03 05:27:05'),(80,'Apakah Sistem Mendukung Pembelajaran Hybrid','Umum','Ya, SCI Media Online mendukung pembelajaran tatap muka dan online (hybrid). Guru dapat menggabungkan materi offline dan online sesuai kebutuhan pembelajaran.','1763656678_p.pdf','<iframe src=\"https://www.youtube.com/embed/XGvhjm2vI7o?si=4b8AwPabGAJ3TG-6\" frameborder=\"0\" allowfullscreen></iframe>','Aktif','2026-03-03 05:27:05','2026-03-03 05:27:05'),(81,'Cara Mengatur KKM Mata Pelajaran','Guru','Guru dapat menentukan Kriteria Ketuntasan Minimal (KKM) untuk setiap mata pelajaran.\r<br>Langkah:\r<br>1. Masuk ke menu Pengaturan atau Mata Pelajaran.\r<br>2. Pilih kelas dan mapel.\r<br>3. Isi nilai KKM sesuai kebijakan sekolah.\r<br>4. Klik Simpan.\r<br>Nilai siswa akan otomatis dibandingkan dengan KKM untuk menentukan tuntas atau tidak.','1763656678_p.pdf','<iframe src=\"https://www.youtube.com/embed/XGvhjm2vI7o?si=4b8AwPabGAJ3TG-6\" frameborder=\"0\" allowfullscreen></iframe>','Aktif','2026-03-03 05:27:05','2026-03-03 05:27:05'),(82,'Cara Melihat Statistik Hasil Ulangan','Guru','Sistem menyediakan statistik hasil ulangan dalam bentuk ringkasan nilai.\r<br>Guru dapat melihat:\r<br>1. Nilai tertinggi.\r<br>2. Nilai terendah.\r<br>3. Nilai rata-rata kelas.\r<br>4. Jumlah siswa tuntas dan tidak tuntas.\r<br>Data ini membantu evaluasi pembelajaran.','1763656678_p.pdf','<iframe src=\"https://www.youtube.com/embed/XGvhjm2vI7o?si=4b8AwPabGAJ3TG-6\" frameborder=\"0\" allowfullscreen></iframe>','Aktif','2026-03-03 05:27:05','2026-03-03 05:27:05'),(83,'Cara Mengatur Jadwal Ulangan','Guru','Guru dapat menentukan tanggal mulai dan berakhirnya ulangan.\r<br>Langkah:\r<br>1. Saat membuat soal pilih pengaturan jadwal.\r<br>2. Tentukan tanggal dan jam mulai.\r<br>3. Tentukan tanggal dan jam selesai.\r<br>4. Simpan pengaturan.\r<br>Siswa hanya dapat mengakses soal pada waktu tersebut.','1763656678_p.pdf','<iframe src=\"https://www.youtube.com/embed/XGvhjm2vI7o?si=4b8AwPabGAJ3TG-6\" frameborder=\"0\" allowfullscreen></iframe>','Aktif','2026-03-03 05:27:05','2026-03-03 05:27:05'),(84,'Cara Memberi Nilai Manual pada Tugas','Guru','Untuk tugas berbentuk esai atau upload file:\r<br>1. Masuk ke menu Tugas.\r<br>2. Klik Lihat Jawaban Siswa.\r<br>3. Periksa jawaban.\r<br>4. Masukkan nilai secara manual.\r<br>5. Klik Simpan.\r<br>Nilai akan langsung terlihat pada akun siswa.','1763656678_p.pdf','<iframe src=\"https://www.youtube.com/embed/XGvhjm2vI7o?si=4b8AwPabGAJ3TG-6\" frameborder=\"0\" allowfullscreen></iframe>','Aktif','2026-03-03 05:27:05','2026-03-03 05:27:05'),(85,'Cara Mengirim Pengumuman ke Siswa','Guru','Guru dapat menyampaikan informasi penting melalui fitur Pengumuman.\r<br>Langkah:\r<br>1. Masuk menu Pengumuman.\r<br>2. Klik Tambah Pengumuman.\r<br>3. Isi judul dan isi pesan.\r<br>4. Klik Kirim.\r<br>Pengumuman akan tampil di dashboard siswa.','1763656678_p.pdf','<iframe src=\"https://www.youtube.com/embed/XGvhjm2vI7o?si=4b8AwPabGAJ3TG-6\" frameborder=\"0\" allowfullscreen></iframe>','Aktif','2026-03-03 05:27:05','2026-03-03 05:27:05'),(86,'Cara Mengganti Password Guru','Guru','Untuk menjaga keamanan akun:\r<br>1. Masuk ke menu Profil.\r<br>2. Pilih Ubah Password.\r<br>3. Masukkan password lama.\r<br>4. Masukkan password baru.\r<br>5. Klik Simpan.\r<br>Gunakan kombinasi huruf besar, kecil, dan angka.','1763656678_p.pdf','<iframe src=\"https://www.youtube.com/embed/XGvhjm2vI7o?si=4b8AwPabGAJ3TG-6\" frameborder=\"0\" allowfullscreen></iframe>','Aktif','2026-03-03 05:27:05','2026-03-03 05:27:05'),(87,'Cara Mengelola Beberapa Kelas','Guru','Guru dapat mengajar lebih dari satu kelas.\r<br>Untuk mengelola:\r<br>1. Pilih kelas dari dropdown pilihan kelas.\r<br>2. Pastikan saat membuat materi atau soal memilih kelas yang benar.\r<br>Data tiap kelas tersimpan terpisah sehingga tidak tercampur.','1763656678_p.pdf','<iframe src=\"https://www.youtube.com/embed/XGvhjm2vI7o?si=4b8AwPabGAJ3TG-6\" frameborder=\"0\" allowfullscreen></iframe>','Aktif','2026-03-03 05:27:05','2026-03-03 05:27:05'),(88,'Cara Mengaktifkan Lisensi Produk','Guru','Setelah membeli produk SCI:\r<br>1. Isi formulir lisensi.\r<br>2. Kirim foto lisensi ke admin resmi.\r<br>3. Tunggu konfirmasi aktivasi.\r<br>Akun akan aktif setelah diverifikasi oleh admin.','1763656678_p.pdf','<iframe src=\"https://www.youtube.com/embed/XGvhjm2vI7o?si=4b8AwPabGAJ3TG-6\" frameborder=\"0\" allowfullscreen></iframe>','Aktif','2026-03-03 05:27:05','2026-03-03 05:27:05'),(89,'Cara Menggunakan Bank Soal Utama','Guru','Bank soal utama sudah tersedia dalam sistem.\r<br>Guru cukup:\r<br>1. Pilih mata pelajaran.\r<br>2. Pilih paket soal.\r<br>3. Tentukan kelas.\r<br>4. Aktifkan soal.\r<br>Soal dapat langsung digunakan tanpa membuat ulang.','1763656678_p.pdf','<iframe src=\"https://www.youtube.com/embed/XGvhjm2vI7o?si=4b8AwPabGAJ3TG-6\" frameborder=\"0\" allowfullscreen></iframe>','Aktif','2026-03-03 05:27:05','2026-03-03 05:27:05'),(90,'Cara Menonaktifkan Akun Siswa','Guru','Jika siswa lulus atau pindah:\r<br>1. Masuk menu Data Siswa.\r<br>2. Pilih Nonaktifkan.\r<br>Akun tidak dapat digunakan login namun data nilai tetap tersimpan.','1763656678_p.pdf','<iframe src=\"https://www.youtube.com/embed/XGvhjm2vI7o?si=4b8AwPabGAJ3TG-6\" frameborder=\"0\" allowfullscreen></iframe>','Aktif','2026-03-03 05:27:05','2026-03-03 05:27:05'),(91,'Cara Masuk ke Forum Kelas','Siswa','Setelah login, siswa akan melihat daftar forum kelas yang tersedia.\r<br>Klik tombol Masuk pada kelas yang sesuai.\r<br>Siswa kemudian dapat melihat materi, tugas, dan ulangan.','1763656678_p.pdf','<iframe src=\"https://www.youtube.com/embed/XGvhjm2vI7o?si=4b8AwPabGAJ3TG-6\" frameborder=\"0\" allowfullscreen></iframe>','Aktif','2026-03-03 05:53:07','2026-03-03 05:53:07'),(92,'Cara Melihat Materi Pembelajaran','Siswa','Masuk ke menu Kegiatan Pembelajaran.\r<br>Klik materi yang dibagikan guru.\r<br>Baca atau unduh materi sesuai kebutuhan.','1763656678_p.pdf','<iframe src=\"https://www.youtube.com/embed/XGvhjm2vI7o?si=4b8AwPabGAJ3TG-6\" frameborder=\"0\" allowfullscreen></iframe>','Aktif','2026-03-03 05:53:07','2026-03-03 05:53:07'),(93,'Cara Mengunduh Lampiran Materi','Siswa','Klik file lampiran pada materi.\r<br>File akan otomatis terunduh ke perangkat siswa.','1763656678_p.pdf','<iframe src=\"https://www.youtube.com/embed/XGvhjm2vI7o?si=4b8AwPabGAJ3TG-6\" frameborder=\"0\" allowfullscreen></iframe>','Aktif','2026-03-03 05:53:07','2026-03-03 05:53:07'),(94,'Cara Melihat Tugas dari Guru','Siswa','Masuk ke menu Tugas.\r<br>Pilih tugas yang aktif.\r<br>Baca instruksi sebelum mengerjakan.','1763656678_p.pdf','<iframe src=\"https://www.youtube.com/embed/XGvhjm2vI7o?si=4b8AwPabGAJ3TG-6\" frameborder=\"0\" allowfullscreen></iframe>','Aktif','2026-03-03 05:53:07','2026-03-03 05:53:07'),(95,'Cara Mengumpulkan Tugas','Siswa','Klik tugas yang ingin dikumpulkan.\r<br>Unggah file jawaban sesuai format yang diminta.\r<br>Klik Kirim untuk menyelesaikan.','1763656678_p.pdf','<iframe src=\"https://www.youtube.com/embed/XGvhjm2vI7o?si=4b8AwPabGAJ3TG-6\" frameborder=\"0\" allowfullscreen></iframe>','Aktif','2026-03-03 05:53:07','2026-03-03 05:53:07'),(96,'Cara Melihat Nilai Tugas','Siswa','Masuk ke menu Tugas.\r<br>Klik detail tugas.\r<br>Nilai dan komentar guru akan terlihat setelah dinilai.','1763656678_p.pdf','<iframe src=\"https://www.youtube.com/embed/XGvhjm2vI7o?si=4b8AwPabGAJ3TG-6\" frameborder=\"0\" allowfullscreen></iframe>','Aktif','2026-03-03 05:53:07','2026-03-03 05:53:07'),(97,'Cara Mengerjakan Ulangan','Siswa','Masuk ke menu Ulangan.\r<br>Klik Mulai pada soal yang aktif.\r<br>Jawab semua pertanyaan lalu klik Selesai.','1763656678_p.pdf','<iframe src=\"https://www.youtube.com/embed/XGvhjm2vI7o?si=4b8AwPabGAJ3TG-6\" frameborder=\"0\" allowfullscreen></iframe>','Aktif','2026-03-03 05:53:07','2026-03-03 05:53:07'),(98,'Cara Melihat Hasil Ulangan','Siswa','Setelah menyelesaikan ulangan, nilai akan muncul otomatis jika sistem menggunakan penilaian otomatis.','1763656678_p.pdf','<iframe src=\"https://www.youtube.com/embed/XGvhjm2vI7o?si=4b8AwPabGAJ3TG-6\" frameborder=\"0\" allowfullscreen></iframe>','Aktif','2026-03-03 05:53:07','2026-03-03 05:53:07'),(99,'Apa yang Terjadi Jika Waktu Ulangan Habis','Siswa','Jika waktu habis, sistem otomatis mengakhiri ujian dan menyimpan jawaban yang sudah diisi.','1763656678_p.pdf','<iframe src=\"https://www.youtube.com/embed/XGvhjm2vI7o?si=4b8AwPabGAJ3TG-6\" frameborder=\"0\" allowfullscreen></iframe>','Aktif','2026-03-03 05:53:07','2026-03-03 05:53:07'),(100,'Cara Keluar dari Forum Kelas','Siswa','Klik tombol Keluar pada sidebar untuk kembali ke halaman utama akun siswa.','1763656678_p.pdf','<iframe src=\"https://www.youtube.com/embed/XGvhjm2vI7o?si=4b8AwPabGAJ3TG-6\" frameborder=\"0\" allowfullscreen></iframe>','Aktif','2026-03-03 05:53:07','2026-03-03 05:53:07'),(101,'Cara Mengunduh Materi Pembelajaran','Siswa','Siswa dapat mengunduh file materi jika tersedia.\r<br>Langkah:\r<br>1. Masuk ke menu Pembelajaran.\r<br>2. Klik materi.\r<br>3. Klik tombol Download.\r<br>File akan tersimpan di perangkat untuk dipelajari kembali.','1763656678_p.pdf','<iframe src=\"https://www.youtube.com/embed/XGvhjm2vI7o?si=4b8AwPabGAJ3TG-6\" frameborder=\"0\" allowfullscreen></iframe>','Aktif','2026-03-03 05:27:05','2026-03-03 05:27:05'),(102,'Apa yang Terjadi Jika Waktu Ulangan Habis','Siswa','Jika waktu habis:\r<br>1. Sistem otomatis menutup ujian.\r<br>2. Jawaban terakhir akan tersimpan.\r<br>3. Nilai langsung diproses jika pilihan ganda.\r<br>Pastikan mengerjakan sebelum waktu berakhir.','1763656678_p.pdf','<iframe src=\"https://www.youtube.com/embed/XGvhjm2vI7o?si=4b8AwPabGAJ3TG-6\" frameborder=\"0\" allowfullscreen></iframe>','Aktif','2026-03-03 05:27:05','2026-03-03 05:27:05'),(103,'Cara Mengupload Jawaban Tugas Berupa File','Siswa','Untuk tugas berbentuk file:\r<br>1. Klik Buka Tugas.\r<br>2. Pilih Upload File.\r<br>3. Pilih file dari perangkat.\r<br>4. Klik Kirim.\r<br>Pastikan ukuran file tidak melebihi batas yang ditentukan.','1763656678_p.pdf','<iframe src=\"https://www.youtube.com/embed/XGvhjm2vI7o?si=4b8AwPabGAJ3TG-6\" frameborder=\"0\" allowfullscreen></iframe>','Aktif','2026-03-03 05:27:05','2026-03-03 05:27:05'),(104,'Apakah Bisa Mengulang Ujian','Siswa','Pengulangan ujian tergantung pengaturan guru.\r<br>Jika guru mengaktifkan kesempatan ulang, siswa dapat mengerjakan kembali sesuai batas yang ditentukan.','1763656678_p.pdf','<iframe src=\"https://www.youtube.com/embed/XGvhjm2vI7o?si=4b8AwPabGAJ3TG-6\" frameborder=\"0\" allowfullscreen></iframe>','Aktif','2026-03-03 05:27:05','2026-03-03 05:27:05'),(105,'Cara Melihat Pengumuman dari Guru','Siswa','Siswa dapat melihat pengumuman pada dashboard atau menu Pengumuman.\r<br>Bacalah informasi terbaru agar tidak ketinggalan tugas atau jadwal penting.','1763656678_p.pdf','<iframe src=\"https://www.youtube.com/embed/XGvhjm2vI7o?si=4b8AwPabGAJ3TG-6\" frameborder=\"0\" allowfullscreen></iframe>','Aktif','2026-03-03 05:27:05','2026-03-03 05:27:05'),(106,'Cara Mengatur Jadwal Ulangan','Guru','Saat membuat soal tambahan, guru dapat menentukan waktu mulai dan waktu selesai ulangan agar siswa mengerjakan sesuai jadwal.','1763656678_p.pdf','<iframe src=\"https://www.youtube.com/embed/XGvhjm2vI7o?si=4b8AwPabGAJ3TG-6\" frameborder=\"0\" allowfullscreen></iframe>','Aktif','2026-03-03 05:53:07','2026-03-03 05:53:07'),(107,'Cara Mengatur Durasi Ujian','Guru','Pada pengaturan soal, tentukan durasi pengerjaan dalam menit.\r<br>Sistem akan menghitung mundur waktu siswa.','1763656678_p.pdf','<iframe src=\"https://www.youtube.com/embed/XGvhjm2vI7o?si=4b8AwPabGAJ3TG-6\" frameborder=\"0\" allowfullscreen></iframe>','Aktif','2026-03-03 05:53:07','2026-03-03 05:53:07'),(108,'Cara Mengaktifkan atau Menonaktifkan Ulangan','Guru','Gunakan tombol Share untuk mengaktifkan dan tombol Hide untuk menonaktifkan ulangan.','1763656678_p.pdf','<iframe src=\"https://www.youtube.com/embed/XGvhjm2vI7o?si=4b8AwPabGAJ3TG-6\" frameborder=\"0\" allowfullscreen></iframe>','Aktif','2026-03-03 05:53:07','2026-03-03 05:53:07'),(109,'Cara Mengelola Soal PTS dan PAS','Guru','Masuk ke menu Soal Tambahan.\r<br>Pilih tipe ujian (PTS/PAS).\r<br>Kelola pertanyaan sesuai kebutuhan evaluasi.','1763656678_p.pdf','<iframe src=\"https://www.youtube.com/embed/XGvhjm2vI7o?si=4b8AwPabGAJ3TG-6\" frameborder=\"0\" allowfullscreen></iframe>','Aktif','2026-03-03 05:53:07','2026-03-03 05:53:07'),(110,'Cara Mengarsipkan Soal Lama','Guru','Guru dapat menyembunyikan soal lama agar tidak muncul lagi tanpa menghapus data.','1763656678_p.pdf','<iframe src=\"https://www.youtube.com/embed/XGvhjm2vI7o?si=4b8AwPabGAJ3TG-6\" frameborder=\"0\" allowfullscreen></iframe>','Aktif','2026-03-03 05:53:07','2026-03-03 05:53:07'),(111,'Bagaimana Jika Internet Terputus Saat Ujian','Umum','Jika koneksi internet terputus:\r<br>1. Segera sambungkan kembali.\r<br>2. Login ulang jika ter-logout.\r<br>3. Lanjutkan ujian jika waktu masih tersedia.\r<br>Gunakan jaringan stabil sebelum memulai ujian.','1763656678_p.pdf','<iframe src=\"https://www.youtube.com/embed/XGvhjm2vI7o?si=4b8AwPabGAJ3TG-6\" frameborder=\"0\" allowfullscreen></iframe>','Aktif','2026-03-03 05:27:05','2026-03-03 05:27:05'),(112,'Apakah Aplikasi Aman Digunakan','Umum','Sistem dirancang untuk menjaga keamanan data pengguna.\r<br>Login dilindungi username dan password serta pengelolaan akses sesuai peran pengguna.','1763656678_p.pdf','<iframe src=\"https://www.youtube.com/embed/XGvhjm2vI7o?si=4b8AwPabGAJ3TG-6\" frameborder=\"0\" allowfullscreen></iframe>','Aktif','2026-03-03 05:27:05','2026-03-03 05:27:05'),(113,'Apakah Bisa Digunakan untuk Semua Mata Pelajaran','Umum','Ya, aplikasi dapat digunakan untuk semua mata pelajaran sesuai kurikulum yang berlaku di sekolah.','1763656678_p.pdf','<iframe src=\"https://www.youtube.com/embed/XGvhjm2vI7o?si=4b8AwPabGAJ3TG-6\" frameborder=\"0\" allowfullscreen></iframe>','Aktif','2026-03-03 05:27:05','2026-03-03 05:27:05'),(114,'Apakah Data Nilai Bisa Diarsipkan','Umum','Semua nilai tersimpan dalam sistem dan dapat diunduh dalam bentuk Excel atau PDF untuk arsip sekolah.','1763656678_p.pdf','<iframe src=\"https://www.youtube.com/embed/XGvhjm2vI7o?si=4b8AwPabGAJ3TG-6\" frameborder=\"0\" allowfullscreen></iframe>','Aktif','2026-03-03 05:27:05','2026-03-03 05:27:05'),(115,'Apakah Aplikasi Mendukung Pembelajaran Jarak Jauh','Umum','Sangat mendukung pembelajaran jarak jauh melalui materi digital, tugas online, ulangan berbasis sistem, dan kelas virtual.','1763656678_p.pdf','<iframe src=\"https://www.youtube.com/embed/XGvhjm2vI7o?si=4b8AwPabGAJ3TG-6\" frameborder=\"0\" allowfullscreen></iframe>','Aktif','2026-03-03 05:27:05','2026-03-03 05:27:05'),(116,'Berapa Lama Data Tersimpan di Sistem','Umum','Data tersimpan selama akun aktif dan tidak dihapus oleh admin.\r<br>Disarankan tetap mengunduh backup nilai secara berkala.','1763656678_p.pdf','<iframe src=\"https://www.youtube.com/embed/XGvhjm2vI7o?si=4b8AwPabGAJ3TG-6\" frameborder=\"0\" allowfullscreen></iframe>','Aktif','2026-03-03 05:27:05','2026-03-03 05:27:05'),(117,'Apakah Bisa Digunakan untuk Ujian Sekolah','Umum','Ya, sistem dapat digunakan untuk Ulangan Harian, PTS, PAS, hingga Ujian Sekolah sesuai kebutuhan guru.','1763656678_p.pdf','<iframe src=\"https://www.youtube.com/embed/XGvhjm2vI7o?si=4b8AwPabGAJ3TG-6\" frameborder=\"0\" allowfullscreen></iframe>','Aktif','2026-03-03 05:27:05','2026-03-03 05:27:05'),(118,'Apakah Bisa Mengurangi Penggunaan Kertas','Umum','Ya, sistem digital membantu mengurangi penggunaan kertas karena soal, tugas, dan rekap nilai dilakukan secara online.','1763656678_p.pdf','<iframe src=\"https://www.youtube.com/embed/XGvhjm2vI7o?si=4b8AwPabGAJ3TG-6\" frameborder=\"0\" allowfullscreen></iframe>','Aktif','2026-03-03 05:27:05','2026-03-03 05:27:05'),(119,'Apakah Bisa Digunakan oleh Sekolah Swasta dan Negeri','Umum','Aplikasi dapat digunakan oleh sekolah negeri maupun swasta yang ingin menerapkan sistem pembelajaran digital.','1763656678_p.pdf','<iframe src=\"https://www.youtube.com/embed/XGvhjm2vI7o?si=4b8AwPabGAJ3TG-6\" frameborder=\"0\" allowfullscreen></iframe>','Aktif','2026-03-03 05:27:05','2026-03-03 05:27:05'),(120,'Apa Keunggulan SCI Media Online Dibanding Sistem Manual','Umum','Keunggulan utama:\r<br>1. Penilaian otomatis.\r<br>2. Rekap nilai instan.\r<br>3. Akses materi kapan saja.\r<br>4. Monitoring siswa real-time.\r<br>5. Efisiensi waktu dan administrasi guru.','1763656678_p.pdf','<iframe src=\"https://www.youtube.com/embed/XGvhjm2vI7o?si=4b8AwPabGAJ3TG-6\" frameborder=\"0\" allowfullscreen></iframe>','Aktif','2026-03-03 05:27:05','2026-03-03 05:27:05'),(121,'Cara Reset Password Siswa Secara Manual','Guru','Jika siswa lupa password dan tidak bisa login, guru dapat melakukan reset secara manual.\r<br>Langkah-langkah:\r<br>1. Masuk ke menu Data Siswa.\r<br>2. Klik tombol Edit pada siswa yang bersangkutan.\r<br>3. Ganti password dengan password baru.\r<br>4. Klik Simpan.\r<br>Berikan password baru kepada siswa dan sarankan untuk segera menggantinya kembali demi keamanan.','1763656678_p.pdf','<iframe src=\"https://www.youtube.com/embed/XGvhjm2vI7o?si=4b8AwPabGAJ3TG-6\" frameborder=\"0\" allowfullscreen></iframe>','Aktif','2026-03-03 05:27:05','2026-03-03 05:27:05'),(122,'Cara Mengatur Bobot Penilaian','Guru','Guru dapat mengatur bobot penilaian sesuai kebijakan sekolah.\r<br>Contoh:\r<br>1. Ulangan Harian 40%.\r<br>2. Tugas 30%.\r<br>3. PTS 15%.\r<br>4. PAS 15%.\r<br>Pengaturan bobot membantu sistem menghitung nilai akhir secara otomatis dan adil.','1763656678_p.pdf','<iframe src=\"https://www.youtube.com/embed/XGvhjm2vI7o?si=4b8AwPabGAJ3TG-6\" frameborder=\"0\" allowfullscreen></iframe>','Aktif','2026-03-03 05:27:05','2026-03-03 05:27:05'),(123,'Cara Memberikan Remedial kepada Siswa','Guru','Jika siswa belum mencapai KKM:\r<br>1. Buat soal remedial.\r<br>2. Atur khusus untuk siswa tertentu.\r<br>3. Tentukan batas waktu pengerjaan.\r<br>4. Nilai remedial dapat menggantikan atau menambah nilai sebelumnya sesuai kebijakan.','1763656678_p.pdf','<iframe src=\"https://www.youtube.com/embed/XGvhjm2vI7o?si=4b8AwPabGAJ3TG-6\" frameborder=\"0\" allowfullscreen></iframe>','Aktif','2026-03-03 05:27:05','2026-03-03 05:27:05'),(124,'Cara Membuat Bank Soal Pribadi','Guru','Guru dapat menyusun bank soal pribadi untuk digunakan kembali.\r<br>Langkahnya:\r<br>1. Buat soal tambahan.\r<br>2. Simpan tanpa langsung membagikan.\r<br>3. Kelola soal berdasarkan tema atau jenis ujian.\r<br>Bank soal membantu efisiensi dalam persiapan evaluasi berikutnya.','1763656678_p.pdf','<iframe src=\"https://www.youtube.com/embed/XGvhjm2vI7o?si=4b8AwPabGAJ3TG-6\" frameborder=\"0\" allowfullscreen></iframe>','Aktif','2026-03-03 06:20:34','2026-03-03 06:20:34'),(125,'Cara Mengelompokkan Siswa Berdasarkan Kelas','Guru','Guru dapat membagi siswa berdasarkan kelas atau rombongan belajar.\r<br>Pastikan saat input data siswa memilih kelas yang sesuai.\r<br>Hal ini penting agar materi dan soal tidak salah sasaran.','1763656678_p.pdf','<iframe src=\"https://www.youtube.com/embed/XGvhjm2vI7o?si=4b8AwPabGAJ3TG-6\" frameborder=\"0\" allowfullscreen></iframe>','Aktif','2026-03-03 05:27:05','2026-03-03 05:27:05'),(126,'Cara Mengedit Materi yang Sudah Diposting','Guru','Jika terdapat kesalahan pada materi:\r<br>1. Masuk ke menu Pembelajaran.\r<br>2. Klik Edit pada materi yang diinginkan.\r<br>3. Perbaiki isi atau link.\r<br>4. Klik Simpan.\r<br>Perubahan akan langsung terlihat pada akun siswa.','1763656678_p.pdf','<iframe src=\"https://www.youtube.com/embed/XGvhjm2vI7o?si=4b8AwPabGAJ3TG-6\" frameborder=\"0\" allowfullscreen></iframe>','Aktif','2026-03-03 05:27:05','2026-03-03 05:27:05'),(127,'Cara Menghapus Materi Pembelajaran','Guru','Untuk menghapus materi:\r<br>1. Masuk ke menu Pembelajaran.\r<br>2. Klik Hapus.\r<br>3. Konfirmasi tindakan.\r<br>Materi akan hilang dari tampilan siswa.','1763656678_p.pdf','<iframe src=\"https://www.youtube.com/embed/XGvhjm2vI7o?si=4b8AwPabGAJ3TG-6\" frameborder=\"0\" allowfullscreen></iframe>','Aktif','2026-03-03 05:27:05','2026-03-03 05:27:05'),(128,'Cara Melihat Aktivitas Siswa','Guru','Guru dapat memonitor aktivitas siswa seperti:\r<br>1. Waktu login.\r<br>2. Waktu pengerjaan soal.\r<br>3. Status pengumpulan tugas.\r<br>Data ini membantu memantau kedisiplinan dan partisipasi siswa.','1763656678_p.pdf','<iframe src=\"https://www.youtube.com/embed/XGvhjm2vI7o?si=4b8AwPabGAJ3TG-6\" frameborder=\"0\" allowfullscreen></iframe>','Aktif','2026-03-03 05:27:05','2026-03-03 05:27:05'),(129,'Cara Menggunakan Grafik Analisis Nilai','Guru','Sistem menyediakan grafik analisis nilai kelas.\r<br>Guru dapat melihat distribusi nilai dalam bentuk visual.\r<br>Fitur ini memudahkan evaluasi pembelajaran secara cepat dan efisien.','1763656678_p.pdf','<iframe src=\"https://www.youtube.com/embed/XGvhjm2vI7o?si=4b8AwPabGAJ3TG-6\" frameborder=\"0\" allowfullscreen></iframe>','Aktif','2026-03-03 05:27:05','2026-03-03 05:27:05'),(130,'Cara Mengelola Tahun Ajaran Baru','Guru','Saat memasuki tahun ajaran baru:\r<br>1. Perbarui data kelas.\r<br>2. Tambahkan siswa baru.\r<br>3. Arsipkan data lama jika diperlukan.\r<br>Pastikan pengelolaan dilakukan sebelum pembelajaran dimulai.','1763656678_p.pdf','<iframe src=\"https://www.youtube.com/embed/XGvhjm2vI7o?si=4b8AwPabGAJ3TG-6\" frameborder=\"0\" allowfullscreen></iframe>','Aktif','2026-03-03 05:27:05','2026-03-03 05:27:05'),(131,'Cara Mengelola Banyak Kelas Sekaligus','Guru','Jika guru memiliki lebih dari satu kelas, setiap kelas akan tampil terpisah pada dashboard.\r<br>Langkah pengelolaan:\r<br>1. Pilih forum kelas yang ingin dikelola.\r<br>2. Tambahkan siswa sesuai kelas masing-masing.\r<br>3. Materi dan soal dapat dibagikan berbeda untuk tiap kelas.\r<br>Dengan sistem ini guru dapat mengatur pembelajaran tanpa tercampur antar kelas.','1763656678_p.pdf','<iframe src=\"https://www.youtube.com/embed/XGvhjm2vI7o?si=4b8AwPabGAJ3TG-6\" frameborder=\"0\" allowfullscreen></iframe>','Aktif','2026-03-03 05:57:59','2026-03-03 05:57:59'),(132,'Cara Memastikan Siswa Sudah Login','Guru','Guru dapat mengecek aktivitas siswa melalui:\r<br>1. Menu Data Siswa.\r<br>2. Laporan aktivitas.\r<br>3. Status pengumpulan tugas dan pengerjaan soal.\r<br>Jika siswa belum terlihat aktif, guru dapat mengingatkan melalui komunikasi langsung.','1763656678_p.pdf','<iframe src=\"https://www.youtube.com/embed/XGvhjm2vI7o?si=4b8AwPabGAJ3TG-6\" frameborder=\"0\" allowfullscreen></iframe>','Aktif','2026-03-03 05:57:59','2026-03-03 05:57:59'),(133,'Cara Menangani Siswa Tidak Bisa Login','Guru','Jika siswa tidak bisa login:\r<br>1. Periksa username dan password.\r<br>2. Pastikan tidak ada kesalahan pengetikan.\r<br>3. Reset password jika diperlukan.\r<br>4. Hubungi admin jika masalah berlanjut.','1763656678_p.pdf','<iframe src=\"https://www.youtube.com/embed/XGvhjm2vI7o?si=4b8AwPabGAJ3TG-6\" frameborder=\"0\" allowfullscreen></iframe>','Aktif','2026-03-03 05:57:59','2026-03-03 05:57:59'),(134,'Cara Mengganti Password Siswa','Guru','Masuk ke menu Data Siswa.\r<br>Klik Edit pada siswa yang dipilih.\r<br>Ubah kolom password lalu klik Simpan.\r<br>Sampaikan password baru kepada siswa secara aman.','1763656678_p.pdf','<iframe src=\"https://www.youtube.com/embed/XGvhjm2vI7o?si=4b8AwPabGAJ3TG-6\" frameborder=\"0\" allowfullscreen></iframe>','Aktif','2026-03-03 05:57:59','2026-03-03 05:57:59'),(135,'Cara Menghindari Duplikasi Username','Guru','Sebelum menambahkan siswa:\r<br>1. Pastikan username belum digunakan.\r<br>2. Gunakan format standar (misal: nama+angka).\r<br>3. Hindari spasi atau karakter khusus.\r<br>Username harus unik agar tidak terjadi konflik login.','1763656678_p.pdf','<iframe src=\"https://www.youtube.com/embed/XGvhjm2vI7o?si=4b8AwPabGAJ3TG-6\" frameborder=\"0\" allowfullscreen></iframe>','Aktif','2026-03-03 05:57:59','2026-03-03 05:57:59'),(136,'Cara Menjelaskan Tata Cara Penggunaan ke Siswa','Guru','Sebelum pembelajaran dimulai:\r<br>1. Berikan panduan login.\r<br>2. Jelaskan menu materi, tugas, dan ulangan.\r<br>3. Simulasikan pengerjaan soal.\r<br>4. Pastikan siswa memahami alur penggunaan.','1763656678_p.pdf','<iframe src=\"https://www.youtube.com/embed/XGvhjm2vI7o?si=4b8AwPabGAJ3TG-6\" frameborder=\"0\" allowfullscreen></iframe>','Aktif','2026-03-03 05:57:59','2026-03-03 05:57:59'),(137,'Cara Mengontrol Waktu Pengerjaan Ulangan','Guru','Guru dapat:\r<br>1. Menentukan jadwal aktif.\r<br>2. Mengatur durasi menit pengerjaan.\r<br>3. Menutup akses setelah waktu selesai.\r<br>Sistem otomatis menghentikan ujian saat waktu habis.','1763656678_p.pdf','<iframe src=\"https://www.youtube.com/embed/XGvhjm2vI7o?si=4b8AwPabGAJ3TG-6\" frameborder=\"0\" allowfullscreen></iframe>','Aktif','2026-03-03 05:57:59','2026-03-03 05:57:59'),(138,'Cara Menghapus Forum Kelas','Guru','Jika forum kelas sudah tidak digunakan:\r<br>1. Keluarkan semua siswa.\r<br>2. Pastikan data sudah diarsipkan.\r<br>3. Hubungi admin jika diperlukan penghapusan permanen.\r<br>Langkah ini mencegah kehilangan data penting.','1763656678_p.pdf','<iframe src=\"https://www.youtube.com/embed/XGvhjm2vI7o?si=4b8AwPabGAJ3TG-6\" frameborder=\"0\" allowfullscreen></iframe>','Aktif','2026-03-03 05:57:59','2026-03-03 05:57:59'),(139,'Cara Mengamankan Akun Guru','Guru','Untuk menjaga keamanan akun:\r<br>1. Jangan membagikan password.\r<br>2. Logout setelah selesai.\r<br>3. Gunakan password yang kuat.\r<br>4. Ganti password secara berkala.','1763656678_p.pdf','<iframe src=\"https://www.youtube.com/embed/XGvhjm2vI7o?si=4b8AwPabGAJ3TG-6\" frameborder=\"0\" allowfullscreen></iframe>','Aktif','2026-03-03 05:57:59','2026-03-03 05:57:59'),(140,'Langkah Awal Sebelum Memulai Pembelajaran Online','Guru','Sebelum memulai:\r<br>1. Pastikan semua siswa sudah terdaftar.\r<br>2. Cek koneksi internet.\r<br>3. Siapkan materi dan soal.\r<br>4. Tentukan jadwal pembelajaran.\r<br>Persiapan yang baik akan membuat proses belajar lebih efektif.','1763656678_p.pdf','<iframe src=\"https://www.youtube.com/embed/XGvhjm2vI7o?si=4b8AwPabGAJ3TG-6\" frameborder=\"0\" allowfullscreen></iframe>','Aktif','2026-03-03 05:57:59','2026-03-03 05:57:59'),(141,'Cara Memastikan Jawaban Tersimpan','Siswa','Saat mengerjakan soal:\r<br>1. Pastikan setiap jawaban sudah dipilih.\r<br>2. Klik tombol Simpan atau Selesai.\r<br>3. Tunggu hingga muncul notifikasi berhasil.\r<br>Jangan langsung menutup aplikasi sebelum konfirmasi tersimpan.','1763656678_p.pdf','<iframe src=\"https://www.youtube.com/embed/XGvhjm2vI7o?si=4b8AwPabGAJ3TG-6\" frameborder=\"0\" allowfullscreen></iframe>','Aktif','2026-03-03 05:27:05','2026-03-03 05:27:05'),(142,'Cara Mengatasi Aplikasi Lambat','Siswa','Jika aplikasi terasa lambat:\r<br>1. Tutup aplikasi lain di perangkat.\r<br>2. Periksa koneksi internet.\r<br>3. Restart perangkat jika perlu.\r<br>4. Gunakan browser versi terbaru untuk akses web.','1763656678_p.pdf','<iframe src=\"https://www.youtube.com/embed/XGvhjm2vI7o?si=4b8AwPabGAJ3TG-6\" frameborder=\"0\" allowfullscreen></iframe>','Aktif','2026-03-03 05:27:05','2026-03-03 05:27:05'),(143,'Cara Mengecek Status Tugas','Siswa','Siswa dapat melihat status tugas:\r<br>1. Masuk ke menu Tugas.\r<br>2. Periksa status (Sudah Dikumpulkan / Belum).\r<br>3. Jika belum terkirim, segera klik Kirim sebelum batas waktu.','1763656678_p.pdf','<iframe src=\"https://www.youtube.com/embed/XGvhjm2vI7o?si=4b8AwPabGAJ3TG-6\" frameborder=\"0\" allowfullscreen></iframe>','Aktif','2026-03-03 05:27:05','2026-03-03 05:27:05'),(144,'Cara Mengikuti Remedial','Siswa','Jika guru memberikan remedial:\r<br>1. Masuk ke menu Soal.\r<br>2. Pilih paket remedial.\r<br>3. Kerjakan sesuai waktu yang ditentukan.\r<br>Nilai remedial akan diproses sesuai kebijakan guru.','1763656678_p.pdf','<iframe src=\"https://www.youtube.com/embed/XGvhjm2vI7o?si=4b8AwPabGAJ3TG-6\" frameborder=\"0\" allowfullscreen></iframe>','Aktif','2026-03-03 05:27:05','2026-03-03 05:27:05'),(145,'Cara Menjaga Keamanan Akun','Siswa','Untuk menjaga akun tetap aman:\r<br>1. Jangan membagikan password.\r<br>2. Logout setelah selesai menggunakan.\r<br>3. Gunakan password yang kuat.\r<br>4. Ganti password secara berkala.','1763656678_p.pdf','<iframe src=\"https://www.youtube.com/embed/XGvhjm2vI7o?si=4b8AwPabGAJ3TG-6\" frameborder=\"0\" allowfullscreen></iframe>','Aktif','2026-03-03 05:27:05','2026-03-03 05:27:05'),(146,'Cara Melihat Riwayat Aktivitas Belajar','Siswa','Siswa dapat memantau aktivitas belajar yang telah dilakukan.\r<br>Langkahnya:\r<br>1. Masuk ke forum kelas.\r<br>2. Buka menu yang menampilkan tugas atau ulangan yang sudah dikerjakan.\r<br>3. Periksa status dan nilai.\r<br>Fitur ini membantu siswa mengetahui progres belajarnya secara mandiri.','1763656678_p.pdf','<iframe src=\"https://www.youtube.com/embed/XGvhjm2vI7o?si=4b8AwPabGAJ3TG-6\" frameborder=\"0\" allowfullscreen></iframe>','Aktif','2026-03-03 06:20:34','2026-03-03 06:20:34'),(147,'Cara Memastikan Tugas Sudah Terkirim','Siswa','Setelah mengunggah tugas:\r<br>1. Pastikan muncul notifikasi berhasil.\r<br>2. Cek kembali status tugas.\r<br>3. Jika file tampil, berarti tugas sudah terkirim.\r<br>Simpan bukti jika diperlukan.','1763656678_p.pdf','<iframe src=\"https://www.youtube.com/embed/XGvhjm2vI7o?si=4b8AwPabGAJ3TG-6\" frameborder=\"0\" allowfullscreen></iframe>','Aktif','2026-03-03 06:02:29','2026-03-03 06:02:29'),(148,'Cara Mengganti File Tugas Sebelum Dinilai','Siswa','Jika guru belum memberi nilai:\r<br>1. Buka kembali tugas.\r<br>2. Unggah ulang file yang benar.\r<br>3. Klik Kirim kembali.\r<br>Pastikan file terbaru sudah terupdate.','1763656678_p.pdf','<iframe src=\"https://www.youtube.com/embed/XGvhjm2vI7o?si=4b8AwPabGAJ3TG-6\" frameborder=\"0\" allowfullscreen></iframe>','Aktif','2026-03-03 06:02:29','2026-03-03 06:02:29'),(149,'Cara Menghindari Kesalahan Saat Ujian Online','Siswa','Sebelum memulai ujian:\r<br>1. Pastikan koneksi internet stabil.\r<br>2. Gunakan perangkat yang baterainya cukup.\r<br>3. Baca soal dengan teliti.\r<br>4. Perhatikan waktu pengerjaan.','1763656678_p.pdf','<iframe src=\"https://www.youtube.com/embed/XGvhjm2vI7o?si=4b8AwPabGAJ3TG-6\" frameborder=\"0\" allowfullscreen></iframe>','Aktif','2026-03-03 06:02:29','2026-03-03 06:02:29'),(150,'Apa yang Harus Dilakukan Jika Sistem Error','Siswa','Jika terjadi error:\r<br>1. Refresh halaman.\r<br>2. Login ulang jika diperlukan.\r<br>3. Periksa koneksi internet.\r<br>4. Hubungi guru apabila masalah tidak terselesaikan.','1763656678_p.pdf','<iframe src=\"https://www.youtube.com/embed/XGvhjm2vI7o?si=4b8AwPabGAJ3TG-6\" frameborder=\"0\" allowfullscreen></iframe>','Aktif','2026-03-03 06:02:29','2026-03-03 06:02:29'),(151,'Apakah Sistem Mendukung Kurikulum Nasional','Umum','Sistem dirancang mengikuti struktur kurikulum nasional yang berlaku di Indonesia.\r<br>Guru dapat menyesuaikan mata pelajaran dan materi sesuai kebutuhan sekolah.','1763656678_p.pdf','<iframe src=\"https://www.youtube.com/embed/XGvhjm2vI7o?si=4b8AwPabGAJ3TG-6\" frameborder=\"0\" allowfullscreen></iframe>','Aktif','2026-03-03 05:27:05','2026-03-03 05:27:05'),(152,'Apakah Bisa Digunakan di Luar Sekolah','Umum','Aplikasi dapat digunakan untuk bimbingan belajar, kelas privat, atau lembaga pendidikan non formal selama memiliki akun aktif.','1763656678_p.pdf','<iframe src=\"https://www.youtube.com/embed/XGvhjm2vI7o?si=4b8AwPabGAJ3TG-6\" frameborder=\"0\" allowfullscreen></iframe>','Aktif','2026-03-03 05:27:05','2026-03-03 05:27:05'),(153,'Bagaimana Proses Pembelian Produk SCI','Umum','Produk dapat dibeli melalui toko resmi atau marketplace yang bekerja sama.\r<br>Setelah pembelian, lakukan aktivasi lisensi agar akun dapat digunakan.','1763656678_p.pdf','<iframe src=\"https://www.youtube.com/embed/XGvhjm2vI7o?si=4b8AwPabGAJ3TG-6\" frameborder=\"0\" allowfullscreen></iframe>','Aktif','2026-03-03 05:27:05','2026-03-03 05:27:05'),(154,'Apakah Tersedia Dukungan Teknis','Umum','SCI Media menyediakan dukungan teknis melalui Pusat Layanan Pelanggan dan WhatsApp resmi untuk membantu kendala penggunaan.','1763656678_p.pdf','<iframe src=\"https://www.youtube.com/embed/XGvhjm2vI7o?si=4b8AwPabGAJ3TG-6\" frameborder=\"0\" allowfullscreen></iframe>','Aktif','2026-03-03 05:27:05','2026-03-03 05:27:05'),(155,'Apakah Sistem Bisa Diakses 24 Jam','Umum','Sistem dapat diakses 24 jam selama server dalam kondisi normal dan koneksi internet tersedia.','1763656678_p.pdf','<iframe src=\"https://www.youtube.com/embed/XGvhjm2vI7o?si=4b8AwPabGAJ3TG-6\" frameborder=\"0\" allowfullscreen></iframe>','Aktif','2026-03-03 05:27:05','2026-03-03 05:27:05'),(156,'Apakah Data Bisa Dicadangkan','Umum','Guru disarankan secara berkala mengunduh backup nilai dalam bentuk Excel atau PDF sebagai cadangan data.','1763656678_p.pdf','<iframe src=\"https://www.youtube.com/embed/XGvhjm2vI7o?si=4b8AwPabGAJ3TG-6\" frameborder=\"0\" allowfullscreen></iframe>','Aktif','2026-03-03 05:27:05','2026-03-03 05:27:05'),(157,'Apakah Sistem Menggunakan Penyimpanan Cloud','Umum','Semua data tersimpan secara online sehingga dapat diakses dari berbagai perangkat dengan akun yang sama.','1763656678_p.pdf','<iframe src=\"https://www.youtube.com/embed/XGvhjm2vI7o?si=4b8AwPabGAJ3TG-6\" frameborder=\"0\" allowfullscreen></iframe>','Aktif','2026-03-03 05:27:05','2026-03-03 05:27:05'),(158,'Apakah Perlu Instalasi Tambahan untuk Web','Umum','Tidak diperlukan instalasi tambahan untuk versi web.\r<br>Pengguna cukup menggunakan browser yang diperbarui dan koneksi internet stabil.','1763656678_p.pdf','<iframe src=\"https://www.youtube.com/embed/XGvhjm2vI7o?si=4b8AwPabGAJ3TG-6\" frameborder=\"0\" allowfullscreen></iframe>','Aktif','2026-03-03 05:27:05','2026-03-03 05:27:05'),(159,'Bagaimana Jika Akun Terkunci','Umum','Jika akun terkunci karena salah password berulang:\r<br>1. Tunggu beberapa menit.\r<br>2. Hubungi guru atau admin untuk reset.\r<br>Jangan mencoba login berulang kali dengan password salah.','1763656678_p.pdf','<iframe src=\"https://www.youtube.com/embed/XGvhjm2vI7o?si=4b8AwPabGAJ3TG-6\" frameborder=\"0\" allowfullscreen></iframe>','Aktif','2026-03-03 05:27:05','2026-03-03 05:27:05'),(160,'Apa Tujuan Utama SCI Media Online','Umum','Tujuan utama aplikasi adalah membantu transformasi pembelajaran digital agar lebih efektif, efisien, transparan, dan mudah dipantau oleh guru maupun siswa.','1763656678_p.pdf','<iframe src=\"https://www.youtube.com/embed/XGvhjm2vI7o?si=4b8AwPabGAJ3TG-6\" frameborder=\"0\" allowfullscreen></iframe>','Aktif','2026-03-03 05:27:05','2026-03-03 05:27:05'),(161,'Cara Mengatur Batas Percobaan Ujian','Guru','Guru dapat membatasi jumlah percobaan pengerjaan ujian.\r<br>Langkah:\r<br>1. Saat membuat atau mengedit soal.\r<br>2. Tentukan jumlah maksimal percobaan (misal 1 atau 2 kali).\r<br>3. Simpan pengaturan.\r<br>Sistem akan otomatis menolak akses jika batas percobaan telah tercapai.','1763656678_p.pdf','<iframe src=\"https://www.youtube.com/embed/XGvhjm2vI7o?si=4b8AwPabGAJ3TG-6\" frameborder=\"0\" allowfullscreen></iframe>','Aktif','2026-03-03 05:27:05','2026-03-03 05:27:05'),(162,'Cara Melihat Daftar Siswa yang Belum Mengerjakan Ujian','Guru','Guru dapat memonitor siswa yang belum mengikuti ujian.\r<br>Masuk ke menu Soal → Lihat Hasil.\r<br>Sistem akan menampilkan daftar siswa dengan status:\r<br>1. Sudah Mengerjakan.\r<br>2. Belum Mengerjakan.\r<br>Data ini membantu guru melakukan tindak lanjut.','1763656678_p.pdf','<iframe src=\"https://www.youtube.com/embed/XGvhjm2vI7o?si=4b8AwPabGAJ3TG-6\" frameborder=\"0\" allowfullscreen></iframe>','Aktif','2026-03-03 05:27:05','2026-03-03 05:27:05'),(163,'Cara Mengunci Ujian Secara Manual','Guru','Jika diperlukan, guru dapat menghentikan ujian sebelum waktu berakhir.\r<br>Caranya:\r<br>1. Masuk ke daftar ujian aktif.\r<br>2. Klik Nonaktifkan atau Tutup Ujian.\r<br>Semua siswa tidak dapat lagi mengakses soal tersebut.','1763656678_p.pdf','<iframe src=\"https://www.youtube.com/embed/XGvhjm2vI7o?si=4b8AwPabGAJ3TG-6\" frameborder=\"0\" allowfullscreen></iframe>','Aktif','2026-03-03 05:27:05','2026-03-03 05:27:05'),(164,'Cara Mengatur Notifikasi Tugas','Guru','Guru dapat memastikan siswa mendapat pemberitahuan tugas baru.\r<br>Pastikan saat membuat tugas:\r<br>1. Klik Kirim/Publikasikan.\r<br>2. Periksa status aktif.\r<br>Siswa akan melihat notifikasi pada dashboard mereka.','1763656678_p.pdf','<iframe src=\"https://www.youtube.com/embed/XGvhjm2vI7o?si=4b8AwPabGAJ3TG-6\" frameborder=\"0\" allowfullscreen></iframe>','Aktif','2026-03-03 05:27:05','2026-03-03 05:27:05'),(165,'Cara Mengganti Foto Profil Guru','Guru','Untuk memperbarui foto profil:\r<br>1. Masuk ke menu Profil.\r<br>2. Klik Ubah Foto.\r<br>3. Pilih gambar dari perangkat.\r<br>4. Klik Simpan.\r<br>Gunakan foto formal untuk identitas profesional.','1763656678_p.pdf','<iframe src=\"https://www.youtube.com/embed/XGvhjm2vI7o?si=4b8AwPabGAJ3TG-6\" frameborder=\"0\" allowfullscreen></iframe>','Aktif','2026-03-03 05:27:05','2026-03-03 05:27:05'),(166,'Cara Mengecek Kapasitas Penyimpanan Tugas','Guru','Guru perlu memastikan file tugas siswa tidak melebihi batas.\r<br>Periksa:\r<br>1. Ukuran maksimal upload.\r<br>2. Format file yang diperbolehkan.\r<br>Jika penuh, hapus file lama yang tidak diperlukan.','1763656678_p.pdf','<iframe src=\"https://www.youtube.com/embed/XGvhjm2vI7o?si=4b8AwPabGAJ3TG-6\" frameborder=\"0\" allowfullscreen></iframe>','Aktif','2026-03-03 05:27:05','2026-03-03 05:27:05'),(167,'Cara Mengatur Format Penilaian','Guru','Guru dapat menentukan apakah nilai ditampilkan dalam:\r<br>1. Angka.\r<br>2. Predikat (A, B, C).\r<br>3. Deskripsi.\r<br>Pengaturan ini dapat disesuaikan dengan kebijakan sekolah.','1763656678_p.pdf','<iframe src=\"https://www.youtube.com/embed/XGvhjm2vI7o?si=4b8AwPabGAJ3TG-6\" frameborder=\"0\" allowfullscreen></iframe>','Aktif','2026-03-03 05:27:05','2026-03-03 05:27:05'),(168,'Cara Menghapus Ujian yang Salah Buat','Guru','Jika terjadi kesalahan saat membuat ujian:\r<br>1. Masuk ke daftar soal.\r<br>2. Pilih Hapus.\r<br>3. Konfirmasi penghapusan.\r<br>Pastikan ujian belum memiliki data nilai sebelum dihapus.','1763656678_p.pdf','<iframe src=\"https://www.youtube.com/embed/XGvhjm2vI7o?si=4b8AwPabGAJ3TG-6\" frameborder=\"0\" allowfullscreen></iframe>','Aktif','2026-03-03 05:27:05','2026-03-03 05:27:05'),(169,'Cara Mengatur Akses Siswa Per Mapel','Guru','Guru dapat memastikan siswa hanya melihat mapel yang sesuai.\r<br>Pastikan pengaturan kelas dan mata pelajaran sudah benar saat input data siswa.','1763656678_p.pdf','<iframe src=\"https://www.youtube.com/embed/XGvhjm2vI7o?si=4b8AwPabGAJ3TG-6\" frameborder=\"0\" allowfullscreen></iframe>','Aktif','2026-03-03 05:27:05','2026-03-03 05:27:05'),(170,'Cara Mengevaluasi Hasil Pembelajaran','Guru','Gunakan fitur rekap dan grafik analisis nilai untuk:\r<br>1. Melihat tren hasil belajar.\r<br>2. Mengidentifikasi siswa yang perlu bimbingan.\r<br>3. Menentukan strategi pembelajaran berikutnya.','1763656678_p.pdf','<iframe src=\"https://www.youtube.com/embed/XGvhjm2vI7o?si=4b8AwPabGAJ3TG-6\" frameborder=\"0\" allowfullscreen></iframe>','Aktif','2026-03-03 05:27:05','2026-03-03 05:27:05'),(171,'Cara Menganalisis Kelemahan Materi dari Hasil Nilai','Guru','Guru dapat menggunakan data nilai untuk mengevaluasi efektivitas materi.\r<br>Langkah analisis:\r<br>1. Bandingkan nilai rata-rata tiap mata pelajaran.\r<br>2. Identifikasi soal dengan tingkat kesalahan tinggi.\r<br>3. Lakukan pembelajaran ulang pada materi yang belum dipahami.\r<br>Pendekatan ini membantu meningkatkan kualitas pembelajaran berikutnya.','1763656678_p.pdf','<iframe src=\"https://www.youtube.com/embed/XGvhjm2vI7o?si=4b8AwPabGAJ3TG-6\" frameborder=\"0\" allowfullscreen></iframe>','Aktif','2026-03-03 06:20:34','2026-03-03 06:20:34'),(172,'Cara Memberikan Umpan Balik ke Siswa','Guru','Saat memberi nilai tugas:\r<br>1. Tambahkan komentar.\r<br>2. Berikan saran perbaikan.\r<br>3. Motivasi siswa untuk meningkatkan hasil belajar.','1763656678_p.pdf','<iframe src=\"https://www.youtube.com/embed/XGvhjm2vI7o?si=4b8AwPabGAJ3TG-6\" frameborder=\"0\" allowfullscreen></iframe>','Aktif','2026-03-03 06:02:42','2026-03-03 06:02:42'),(173,'Cara Mengarsipkan Data Pembelajaran','Guru','Simpan file rekap nilai dalam format Excel atau PDF.\r<br>Arsipkan materi dan soal untuk referensi di semester berikutnya.','1763656678_p.pdf','<iframe src=\"https://www.youtube.com/embed/XGvhjm2vI7o?si=4b8AwPabGAJ3TG-6\" frameborder=\"0\" allowfullscreen></iframe>','Aktif','2026-03-03 06:02:42','2026-03-03 06:02:42'),(174,'Cara Mengelola Pembelajaran Secara Efektif','Guru','Rencanakan jadwal pembelajaran.\r<br>Gunakan variasi materi dan soal.\r<br>Pantau perkembangan siswa secara rutin melalui sistem.','1763656678_p.pdf','<iframe src=\"https://www.youtube.com/embed/XGvhjm2vI7o?si=4b8AwPabGAJ3TG-6\" frameborder=\"0\" allowfullscreen></iframe>','Aktif','2026-03-03 06:02:42','2026-03-03 06:02:42'),(175,'Tips Sukses Menggunakan SCI Media Online','Guru','1. Siapkan materi sebelum kelas dimulai.\r<br>2. Gunakan fitur share secara tepat.\r<br>3. Pantau nilai secara berkala.\r<br>4. Jaga komunikasi dengan siswa.','1763656678_p.pdf','<iframe src=\"https://www.youtube.com/embed/XGvhjm2vI7o?si=4b8AwPabGAJ3TG-6\" frameborder=\"0\" allowfullscreen></iframe>','Aktif','2026-03-03 06:02:42','2026-03-03 06:02:42'),(176,'Cara Mengatasi File Gagal Upload','Siswa','Jika file gagal diupload:\r<br>1. Periksa ukuran file.\r<br>2. Pastikan format sesuai ketentuan.\r<br>3. Periksa koneksi internet.\r<br>4. Coba upload ulang.\r<br>Jika tetap gagal, hubungi guru.','1763656678_p.pdf','<iframe src=\"https://www.youtube.com/embed/XGvhjm2vI7o?si=4b8AwPabGAJ3TG-6\" frameborder=\"0\" allowfullscreen></iframe>','Aktif','2026-03-03 05:27:05','2026-03-03 05:27:05'),(177,'Cara Mengecek Jadwal Ujian','Siswa','Siswa dapat melihat jadwal ujian pada menu Soal atau Dashboard.\r<br>Pastikan memperhatikan tanggal dan jam mulai agar tidak terlambat.','1763656678_p.pdf','<iframe src=\"https://www.youtube.com/embed/XGvhjm2vI7o?si=4b8AwPabGAJ3TG-6\" frameborder=\"0\" allowfullscreen></iframe>','Aktif','2026-03-03 05:27:05','2026-03-03 05:27:05'),(178,'Cara Melihat Detail Nilai Ujian','Siswa','Siswa dapat melihat detail nilai termasuk skor dan jawaban benar/salah jika diaktifkan oleh guru.','1763656678_p.pdf','<iframe src=\"https://www.youtube.com/embed/XGvhjm2vI7o?si=4b8AwPabGAJ3TG-6\" frameborder=\"0\" allowfullscreen></iframe>','Aktif','2026-03-03 05:27:05','2026-03-03 05:27:05'),(179,'Cara Menggunakan Aplikasi dengan Aman','Siswa','Gunakan aplikasi hanya untuk kegiatan pembelajaran.\r<br>Hindari membagikan akun kepada teman agar tidak terjadi penyalahgunaan.','1763656678_p.pdf','<iframe src=\"https://www.youtube.com/embed/XGvhjm2vI7o?si=4b8AwPabGAJ3TG-6\" frameborder=\"0\" allowfullscreen></iframe>','Aktif','2026-03-03 05:27:05','2026-03-03 05:27:05'),(180,'Apa yang Harus Dilakukan Jika Nilai Tidak Muncul','Siswa','Jika nilai belum muncul:\r<br>1. Tunggu proses koreksi guru.\r<br>2. Refresh halaman.\r<br>3. Hubungi guru jika dirasa sudah terlalu lama.','1763656678_p.pdf','<iframe src=\"https://www.youtube.com/embed/XGvhjm2vI7o?si=4b8AwPabGAJ3TG-6\" frameborder=\"0\" allowfullscreen></iframe>','Aktif','2026-03-03 05:27:05','2026-03-03 05:27:05'),(181,'Ringkasan Fitur Utama SCI Media Online','Umum','Platform ini menyediakan:\r<br>1. Materi lengkap.\r<br>2. Soal otomatis.\r<br>3. Rekap nilai instan.\r<br>4. Akses fleksibel via web dan Android.','1763656678_p.pdf','<iframe src=\"https://www.youtube.com/embed/XGvhjm2vI7o?si=4b8AwPabGAJ3TG-6\" frameborder=\"0\" allowfullscreen></iframe>','Aktif','2026-03-03 06:02:51','2026-03-03 06:02:51'),(182,'Siapa yang Bisa Menggunakan Platform Ini','Umum','Dapat digunakan oleh guru dan siswa jenjang SD, MI, dan SMP yang memiliki akun aktif.','1763656678_p.pdf','<iframe src=\"https://www.youtube.com/embed/XGvhjm2vI7o?si=4b8AwPabGAJ3TG-6\" frameborder=\"0\" allowfullscreen></iframe>','Aktif','2026-03-03 06:02:51','2026-03-03 06:02:51'),(183,'Apakah Data Aman di Sistem','Umum','Sistem dilengkapi pengamanan login.\r<br>Akun hanya bisa diakses dengan username dan password masing-masing.','1763656678_p.pdf','<iframe src=\"https://www.youtube.com/embed/XGvhjm2vI7o?si=4b8AwPabGAJ3TG-6\" frameborder=\"0\" allowfullscreen></iframe>','Aktif','2026-03-03 06:02:51','2026-03-03 06:02:51'),(184,'Apa Manfaat Rekap Nilai Otomatis','Umum','Rekap otomatis membantu guru menghemat waktu dalam perhitungan nilai dan pembuatan laporan.','1763656678_p.pdf','<iframe src=\"https://www.youtube.com/embed/XGvhjm2vI7o?si=4b8AwPabGAJ3TG-6\" frameborder=\"0\" allowfullscreen></iframe>','Aktif','2026-03-03 06:02:51','2026-03-03 06:02:51'),(185,'Apakah Bisa Digunakan untuk Ujian Semester','Umum','Ya, guru dapat membuat soal PTS dan PAS lengkap dengan pengaturan waktu dan rekap nilai.','1763656678_p.pdf','<iframe src=\"https://www.youtube.com/embed/XGvhjm2vI7o?si=4b8AwPabGAJ3TG-6\" frameborder=\"0\" allowfullscreen></iframe>','Aktif','2026-03-03 06:02:51','2026-03-03 06:02:51'),(186,'Bagaimana Jika Ingin Upgrade Fitur','Umum','Hubungi admin resmi SCI Media untuk informasi paket dan lisensi tambahan.','1763656678_p.pdf','<iframe src=\"https://www.youtube.com/embed/XGvhjm2vI7o?si=4b8AwPabGAJ3TG-6\" frameborder=\"0\" allowfullscreen></iframe>','Aktif','2026-03-03 06:02:51','2026-03-03 06:02:51'),(187,'Apakah Bisa Digunakan untuk Belajar Mandiri','Umum','Siswa dapat mengakses materi kapan saja sehingga mendukung pembelajaran mandiri.','1763656678_p.pdf','<iframe src=\"https://www.youtube.com/embed/XGvhjm2vI7o?si=4b8AwPabGAJ3TG-6\" frameborder=\"0\" allowfullscreen></iframe>','Aktif','2026-03-03 06:02:51','2026-03-03 06:02:51'),(188,'Bagaimana Cara Mendapat Bantuan Teknis','Umum','Pengguna dapat menghubungi admin melalui kontak resmi untuk bantuan teknis.','1763656678_p.pdf','<iframe src=\"https://www.youtube.com/embed/XGvhjm2vI7o?si=4b8AwPabGAJ3TG-6\" frameborder=\"0\" allowfullscreen></iframe>','Aktif','2026-03-03 06:02:51','2026-03-03 06:02:51'),(189,'Apakah Platform Mendukung Pembelajaran Hybrid','Umum','SCI Media Online dapat digunakan untuk pembelajaran tatap muka maupun daring (hybrid).','1763656678_p.pdf','<iframe src=\"https://www.youtube.com/embed/XGvhjm2vI7o?si=4b8AwPabGAJ3TG-6\" frameborder=\"0\" allowfullscreen></iframe>','Aktif','2026-03-03 06:02:51','2026-03-03 06:02:51'),(190,'Mengapa Guru Perlu Menggunakan LMS','Umum','LMS membantu pengelolaan pembelajaran menjadi lebih terstruktur, efisien, dan terdokumentasi dengan baik.','1763656678_p.pdf','<iframe src=\"https://www.youtube.com/embed/XGvhjm2vI7o?si=4b8AwPabGAJ3TG-6\" frameborder=\"0\" allowfullscreen></iframe>','Aktif','2026-03-03 06:02:51','2026-03-03 06:02:51'),(191,'Apakah Aplikasi Bisa Digunakan Saat Libur Sekolah','Umum','Sistem tetap dapat diakses saat libur sekolah selama akun masih aktif dan server dalam kondisi normal.','1763656678_p.pdf','<iframe src=\"https://www.youtube.com/embed/XGvhjm2vI7o?si=4b8AwPabGAJ3TG-6\" frameborder=\"0\" allowfullscreen></iframe>','Aktif','2026-03-03 05:27:05','2026-03-03 05:27:05'),(192,'Apakah Perlu Update Aplikasi Secara Berkala','Umum','Pengguna Android disarankan memperbarui aplikasi melalui Play Store untuk mendapatkan fitur terbaru dan perbaikan bug.','1763656678_p.pdf','<iframe src=\"https://www.youtube.com/embed/XGvhjm2vI7o?si=4b8AwPabGAJ3TG-6\" frameborder=\"0\" allowfullscreen></iframe>','Aktif','2026-03-03 05:27:05','2026-03-03 05:27:05'),(193,'Apakah Sistem Mendukung Banyak Guru dalam Satu Sekolah','Umum','Sistem dapat digunakan oleh banyak guru dalam satu sekolah selama masing-masing memiliki akun aktif.','1763656678_p.pdf','<iframe src=\"https://www.youtube.com/embed/XGvhjm2vI7o?si=4b8AwPabGAJ3TG-6\" frameborder=\"0\" allowfullscreen></iframe>','Aktif','2026-03-03 05:27:05','2026-03-03 05:27:05'),(194,'Apakah Bisa Digunakan untuk Try Out','Umum','Sistem sangat cocok digunakan untuk try out karena mendukung penilaian otomatis dan analisis hasil cepat.','1763656678_p.pdf','<iframe src=\"https://www.youtube.com/embed/XGvhjm2vI7o?si=4b8AwPabGAJ3TG-6\" frameborder=\"0\" allowfullscreen></iframe>','Aktif','2026-03-03 05:27:05','2026-03-03 05:27:05'),(195,'Apakah Sistem Mendukung Evaluasi Berkelanjutan','Umum','Guru dapat melakukan evaluasi rutin melalui tugas, ulangan, dan analisis nilai yang tersedia di sistem.','1763656678_p.pdf','<iframe src=\"https://www.youtube.com/embed/XGvhjm2vI7o?si=4b8AwPabGAJ3TG-6\" frameborder=\"0\" allowfullscreen></iframe>','Aktif','2026-03-03 05:27:05','2026-03-03 05:27:05'),(196,'Apakah Bisa Digunakan untuk Kelas Kecil atau Privat','Umum','Sistem tetap efektif digunakan untuk kelas kecil, bimbel, maupun les privat dengan jumlah siswa terbatas.','1763656678_p.pdf','<iframe src=\"https://www.youtube.com/embed/XGvhjm2vI7o?si=4b8AwPabGAJ3TG-6\" frameborder=\"0\" allowfullscreen></iframe>','Aktif','2026-03-03 05:27:05','2026-03-03 05:27:05'),(197,'Apa Dampak Rekap Nilai Otomatis bagi Administrasi Sekolah','Umum','Rekap otomatis membantu sekolah menghemat waktu administrasi, mengurangi kesalahan perhitungan manual, dan mempercepat proses pelaporan nilai.','1763656678_p.pdf','<iframe src=\"https://www.youtube.com/embed/XGvhjm2vI7o?si=4b8AwPabGAJ3TG-6\" frameborder=\"0\" allowfullscreen></iframe>','Aktif','2026-03-03 05:27:05','2026-03-03 05:27:05'),(198,'Apakah Sistem Bisa Digunakan Bersamaan oleh Banyak Pengguna','Umum','Sistem dirancang untuk mendukung banyak pengguna secara bersamaan selama koneksi internet stabil.','1763656678_p.pdf','<iframe src=\"https://www.youtube.com/embed/XGvhjm2vI7o?si=4b8AwPabGAJ3TG-6\" frameborder=\"0\" allowfullscreen></iframe>','Aktif','2026-03-03 05:27:05','2026-03-03 05:27:05'),(199,'Bagaimana Cara Mendapat Informasi Terbaru','Umum','Informasi terbaru dapat diperoleh melalui website resmi, media sosial, atau pengumuman dari admin SCI Media.','1763656678_p.pdf','<iframe src=\"https://www.youtube.com/embed/XGvhjm2vI7o?si=4b8AwPabGAJ3TG-6\" frameborder=\"0\" allowfullscreen></iframe>','Aktif','2026-03-03 05:27:05','2026-03-03 05:27:05'),(200,'Kesimpulan Penggunaan SCI Media Online','Umum','SCI Media Online merupakan solusi pembelajaran digital yang membantu guru dan siswa dalam mengelola materi, tugas, ujian, serta penilaian secara efisien dan transparan.','1763656678_p.pdf','<iframe src=\"https://www.youtube.com/embed/XGvhjm2vI7o?si=4b8AwPabGAJ3TG-6\" frameborder=\"0\" allowfullscreen></iframe>','Aktif','2026-03-03 05:27:05','2026-03-03 05:27:05');
/*!40000 ALTER TABLE `question_categories` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `reports`
--

DROP TABLE IF EXISTS `reports`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `reports` (
  `id` int NOT NULL AUTO_INCREMENT,
  `serial_id` int NOT NULL,
  `student_id` int NOT NULL,
  `report` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `img` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `reports_serial_id_foreign` (`serial_id`),
  KEY `reports_student_id_foreign` (`student_id`),
  CONSTRAINT `reports_serial_id_foreign` FOREIGN KEY (`serial_id`) REFERENCES `serials` (`id`) ON DELETE CASCADE,
  CONSTRAINT `reports_student_id_foreign` FOREIGN KEY (`student_id`) REFERENCES `students` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `reports`
--

LOCK TABLES `reports` WRITE;
/*!40000 ALTER TABLE `reports` DISABLE KEYS */;
/*!40000 ALTER TABLE `reports` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `role_has_permissions`
--

DROP TABLE IF EXISTS `role_has_permissions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `role_has_permissions` (
  `permission_id` bigint unsigned NOT NULL,
  `role_id` bigint unsigned NOT NULL,
  PRIMARY KEY (`permission_id`,`role_id`),
  KEY `role_has_permissions_role_id_foreign` (`role_id`),
  CONSTRAINT `role_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE,
  CONSTRAINT `role_has_permissions_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `role_has_permissions`
--

LOCK TABLES `role_has_permissions` WRITE;
/*!40000 ALTER TABLE `role_has_permissions` DISABLE KEYS */;
/*!40000 ALTER TABLE `role_has_permissions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `roles`
--

DROP TABLE IF EXISTS `roles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `roles` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `roles_name_guard_name_unique` (`name`,`guard_name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `roles`
--

LOCK TABLES `roles` WRITE;
/*!40000 ALTER TABLE `roles` DISABLE KEYS */;
/*!40000 ALTER TABLE `roles` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `serial_logs`
--

DROP TABLE IF EXISTS `serial_logs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `serial_logs` (
  `id` int NOT NULL AUTO_INCREMENT,
  `serial_id` int NOT NULL,
  `active` varchar(3) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` enum('Baru','Perpanjang') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Baru',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `serial_logs_serial_id_foreign` (`serial_id`),
  CONSTRAINT `serial_logs_serial_id_foreign` FOREIGN KEY (`serial_id`) REFERENCES `serials` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `serial_logs`
--

LOCK TABLES `serial_logs` WRITE;
/*!40000 ALTER TABLE `serial_logs` DISABLE KEYS */;
INSERT INTO `serial_logs` VALUES (1,1,'6','Baru','2025-12-28 13:08:53','2025-12-28 13:08:53'),(2,2,'12','Baru','2025-12-28 13:09:29','2025-12-28 13:09:29'),(3,3,'6','Baru','2026-01-08 13:52:19','2026-01-08 13:52:19');
/*!40000 ALTER TABLE `serial_logs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `serials`
--

DROP TABLE IF EXISTS `serials`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `serials` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int DEFAULT NULL,
  `product_id` int NOT NULL,
  `serial` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `paket` varchar(1) COLLATE utf8mb4_unicode_ci NOT NULL,
  `active` varchar(3) COLLATE utf8mb4_unicode_ci NOT NULL,
  `expired_at` timestamp NULL DEFAULT NULL,
  `notif` enum('Tidak_ada','Peringatan','Kedaluwarsa') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Tidak_ada',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `serials_serial_unique` (`serial`),
  KEY `serials_user_id_foreign` (`user_id`),
  KEY `serials_product_id_foreign` (`product_id`),
  CONSTRAINT `serials_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE,
  CONSTRAINT `serials_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `serials`
--

LOCK TABLES `serials` WRITE;
/*!40000 ALTER TABLE `serials` DISABLE KEYS */;
INSERT INTO `serials` VALUES (1,1,1,'QD3JH-8H4YH-E8K6N-RZREW','1','6','2024-06-28 13:12:39','Tidak_ada','2025-12-28 13:08:52','2026-03-03 10:41:37'),(2,2,1,'7HNAK-FJPKQ-IX9JB-VM4AQ','2','12','2026-04-01 15:59:18','Tidak_ada','2025-12-28 13:09:29','2026-03-03 10:41:38'),(3,3,1,'FRERA-VDKLO-2DASQ-8MC8H','1','6','2026-03-01 15:59:18','Tidak_ada','2026-01-08 13:52:19','2026-01-08 13:52:19');
/*!40000 ALTER TABLE `serials` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `share_exercises`
--

DROP TABLE IF EXISTS `share_exercises`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `share_exercises` (
  `serial_id` int NOT NULL,
  `exercise_id` int NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`serial_id`,`exercise_id`),
  KEY `share_exercises_exercise_id_foreign` (`exercise_id`),
  CONSTRAINT `share_exercises_exercise_id_foreign` FOREIGN KEY (`exercise_id`) REFERENCES `exercises` (`id`) ON DELETE CASCADE,
  CONSTRAINT `share_exercises_serial_id_foreign` FOREIGN KEY (`serial_id`) REFERENCES `serials` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `share_exercises`
--

LOCK TABLES `share_exercises` WRITE;
/*!40000 ALTER TABLE `share_exercises` DISABLE KEYS */;
/*!40000 ALTER TABLE `share_exercises` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `students`
--

DROP TABLE IF EXISTS `students`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `students` (
  `id` int NOT NULL AUTO_INCREMENT,
  `serial_id` int NOT NULL,
  `user_id` int NOT NULL,
  `classroom_id` int NOT NULL,
  `name` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `username` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password_text` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nis` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `students_serial_id_foreign` (`serial_id`),
  KEY `students_user_id_foreign` (`user_id`),
  KEY `students_classroom_id_foreign` (`classroom_id`),
  CONSTRAINT `students_classroom_id_foreign` FOREIGN KEY (`classroom_id`) REFERENCES `classrooms` (`id`) ON DELETE CASCADE,
  CONSTRAINT `students_serial_id_foreign` FOREIGN KEY (`serial_id`) REFERENCES `serials` (`id`) ON DELETE CASCADE,
  CONSTRAINT `students_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `students`
--

LOCK TABLES `students` WRITE;
/*!40000 ALTER TABLE `students` DISABLE KEYS */;
INSERT INTO `students` VALUES (1,1,1,1,'A','A','$2y$12$f7/TnQ6V418XUrx9BbB1z.nXe5ZtuLAcDlMFsWl6.iXoteALqumve','Siswa1234',NULL,NULL,NULL,'2025-12-28 13:13:00','2025-12-28 13:13:00');
/*!40000 ALTER TABLE `students` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `subthemes`
--

DROP TABLE IF EXISTS `subthemes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `subthemes` (
  `id` int NOT NULL AUTO_INCREMENT,
  `lesson_id` int NOT NULL,
  `theme_id` int NOT NULL,
  `subtheme` int NOT NULL,
  `name` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `subthemes_lesson_id_foreign` (`lesson_id`),
  KEY `subthemes_theme_id_foreign` (`theme_id`),
  CONSTRAINT `subthemes_lesson_id_foreign` FOREIGN KEY (`lesson_id`) REFERENCES `lessons` (`id`) ON DELETE CASCADE,
  CONSTRAINT `subthemes_theme_id_foreign` FOREIGN KEY (`theme_id`) REFERENCES `themes` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `subthemes`
--

LOCK TABLES `subthemes` WRITE;
/*!40000 ALTER TABLE `subthemes` DISABLE KEYS */;
INSERT INTO `subthemes` VALUES (1,1,1,1,'Bagian-bagian Tubuh',NULL,NULL),(2,1,1,2,'Merawat Tubuhku',NULL,NULL),(3,1,2,1,'Anggota Keluarga',NULL,NULL),(4,1,3,1,'Lingkungan Sehat & Tidak Sehat',NULL,NULL),(5,1,4,1,'Macam-macam Benda',NULL,NULL),(6,1,5,1,'Bentuk dan Perubahan',NULL,NULL),(7,1,6,1,'Kegunaan Benda',NULL,NULL),(8,1,7,1,'Jenis Gerak',NULL,NULL),(9,1,8,1,'Cuaca',NULL,NULL);
/*!40000 ALTER TABLE `subthemes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tasks`
--

DROP TABLE IF EXISTS `tasks`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tasks` (
  `id` int NOT NULL AUTO_INCREMENT,
  `serial_id` int NOT NULL,
  `post_id` int NOT NULL,
  `student_id` int NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `attachment` text COLLATE utf8mb4_unicode_ci,
  `point` varchar(3) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `tasks_serial_id_foreign` (`serial_id`),
  KEY `tasks_post_id_foreign` (`post_id`),
  KEY `tasks_student_id_foreign` (`student_id`),
  CONSTRAINT `tasks_post_id_foreign` FOREIGN KEY (`post_id`) REFERENCES `posts` (`id`) ON DELETE CASCADE,
  CONSTRAINT `tasks_serial_id_foreign` FOREIGN KEY (`serial_id`) REFERENCES `serials` (`id`) ON DELETE CASCADE,
  CONSTRAINT `tasks_student_id_foreign` FOREIGN KEY (`student_id`) REFERENCES `students` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tasks`
--

LOCK TABLES `tasks` WRITE;
/*!40000 ALTER TABLE `tasks` DISABLE KEYS */;
/*!40000 ALTER TABLE `tasks` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `themes`
--

DROP TABLE IF EXISTS `themes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `themes` (
  `id` int NOT NULL AUTO_INCREMENT,
  `lesson_id` int NOT NULL,
  `theme` int NOT NULL,
  `name` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `themes_lesson_id_foreign` (`lesson_id`),
  CONSTRAINT `themes_lesson_id_foreign` FOREIGN KEY (`lesson_id`) REFERENCES `lessons` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `themes`
--

LOCK TABLES `themes` WRITE;
/*!40000 ALTER TABLE `themes` DISABLE KEYS */;
INSERT INTO `themes` VALUES (1,1,1,'Tubuhku','2025-12-29 04:22:28','2025-12-29 04:22:28'),(2,1,2,'Identitas Diri & Keluarga','2025-12-29 04:22:28','2025-12-29 04:22:28'),(3,1,3,'Lingkungan Sekitarku','2025-12-29 04:22:28','2025-12-29 04:22:28'),(4,1,4,'Benda di Sekitarku','2025-12-29 04:22:28','2025-12-29 04:22:28'),(5,1,5,'Perubahan Bentuk Benda','2025-12-29 04:22:28','2025-12-29 04:22:28'),(6,1,6,'Benda dan Kegunaannya','2025-12-29 04:22:28','2025-12-29 04:22:28'),(7,1,7,'Gerak Benda','2025-12-29 04:22:28','2025-12-29 04:22:28'),(8,1,8,'Benda Langit & Cuaca','2025-12-29 04:22:28','2025-12-29 04:22:28');
/*!40000 ALTER TABLE `themes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `unanswered_questions`
--

DROP TABLE IF EXISTS `unanswered_questions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `unanswered_questions` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `question` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `keyword` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `count` int NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `unanswered_questions_keyword_unique` (`keyword`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `unanswered_questions`
--

LOCK TABLES `unanswered_questions` WRITE;
/*!40000 ALTER TABLE `unanswered_questions` DISABLE KEYS */;
INSERT INTO `unanswered_questions` VALUES (1,'info lowongan kerja jadi admin','lowongan admin',10,'2026-02-24 15:22:24','2026-02-24 15:22:24'),(2,'erdtfygudzserty','hh',1,NULL,NULL);
/*!40000 ALTER TABLE `unanswered_questions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `users` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `username` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `role` tinyint NOT NULL,
  `address` text COLLATE utf8mb4_unicode_ci,
  `phone` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `img` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `login_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_username_unique` (`username`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'JG','J','$2y$12$7OfZST1m5VAqWqNGt60quuHvN7wvE5/0uEGfi8DnekPhwtVnpnJ/i','gian123ivan@gmail.com',1,NULL,NULL,NULL,NULL,'2025-12-28 13:08:10','2025-12-28 13:08:10'),(2,'Q','Q','$2y$12$vyKX0wN5z2zhZ6/p08ShCu72PWXBFHNnLUogYxhZYItMUYeTBP60C','gian123ivan@gmail.com',1,NULL,NULL,NULL,NULL,'2026-01-08 15:55:01','2026-01-08 15:55:01'),(3,'S','S','$2y$12$uDDeN8e6chPkdpt6swtCW.yaZGMXWIbXGdAAPD8DYQeqOtEi5kMCO',NULL,1,NULL,NULL,NULL,NULL,'2026-02-25 12:37:50','2026-02-25 12:37:50');
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

-- Dump completed on 2026-03-03 18:35:14
