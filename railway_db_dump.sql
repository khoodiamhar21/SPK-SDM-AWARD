-- MySQL dump 10.13  Distrib 8.0.30, for Win64 (x86_64)
--
-- Host: localhost    Database: spk_sdmaward
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
-- Table structure for table `banners`
--

DROP TABLE IF EXISTS `banners`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `banners` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `foto_path` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `judul` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `urutan` int NOT NULL DEFAULT '0',
  `aktif` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `banners`
--

LOCK TABLES `banners` WRITE;
/*!40000 ALTER TABLE `banners` DISABLE KEYS */;
/*!40000 ALTER TABLE `banners` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `beritas`
--

DROP TABLE IF EXISTS `beritas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `beritas` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `judul` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `kategori` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Prestasi',
  `tanggal` date NOT NULL,
  `isi` text COLLATE utf8mb4_unicode_ci,
  `foto_path` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `beritas`
--

LOCK TABLES `beritas` WRITE;
/*!40000 ALTER TABLE `beritas` DISABLE KEYS */;
/*!40000 ALTER TABLE `beritas` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `bobots`
--

DROP TABLE IF EXISTS `bobots`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `bobots` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `kriteria_id` bigint unsigned NOT NULL,
  `bobot` decimal(5,4) NOT NULL DEFAULT '0.0000',
  `periode_id` bigint unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `bobots_kriteria_id_foreign` (`kriteria_id`),
  KEY `bobots_periode_id_foreign` (`periode_id`),
  CONSTRAINT `bobots_kriteria_id_foreign` FOREIGN KEY (`kriteria_id`) REFERENCES `kriterias` (`id`) ON DELETE CASCADE,
  CONSTRAINT `bobots_periode_id_foreign` FOREIGN KEY (`periode_id`) REFERENCES `periodes` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `bobots`
--

LOCK TABLES `bobots` WRITE;
/*!40000 ALTER TABLE `bobots` DISABLE KEYS */;
INSERT INTO `bobots` VALUES (1,1,0.5000,1,'2026-07-17 07:14:51','2026-07-17 07:14:51'),(2,2,0.3000,1,'2026-07-17 07:14:51','2026-07-17 07:14:51'),(3,3,0.2000,1,'2026-07-17 07:14:51','2026-07-17 07:14:51');
/*!40000 ALTER TABLE `bobots` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cache`
--

DROP TABLE IF EXISTS `cache`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `cache` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` bigint NOT NULL,
  PRIMARY KEY (`key`),
  KEY `cache_expiration_index` (`expiration`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cache`
--

LOCK TABLES `cache` WRITE;
/*!40000 ALTER TABLE `cache` DISABLE KEYS */;
/*!40000 ALTER TABLE `cache` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cache_locks`
--

DROP TABLE IF EXISTS `cache_locks`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `cache_locks` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` bigint NOT NULL,
  PRIMARY KEY (`key`),
  KEY `cache_locks_expiration_index` (`expiration`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cache_locks`
--

LOCK TABLES `cache_locks` WRITE;
/*!40000 ALTER TABLE `cache_locks` DISABLE KEYS */;
/*!40000 ALTER TABLE `cache_locks` ENABLE KEYS */;
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
  `connection` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`),
  KEY `failed_jobs_connection_queue_failed_at_index` (`connection`,`queue`,`failed_at`)
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
-- Table structure for table `job_batches`
--

DROP TABLE IF EXISTS `job_batches`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `job_batches` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_jobs` int NOT NULL,
  `pending_jobs` int NOT NULL,
  `failed_jobs` int NOT NULL,
  `failed_job_ids` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `options` mediumtext COLLATE utf8mb4_unicode_ci,
  `cancelled_at` int DEFAULT NULL,
  `created_at` int NOT NULL,
  `finished_at` int DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `job_batches`
--

LOCK TABLES `job_batches` WRITE;
/*!40000 ALTER TABLE `job_batches` DISABLE KEYS */;
/*!40000 ALTER TABLE `job_batches` ENABLE KEYS */;
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
  `attempts` smallint unsigned NOT NULL,
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
-- Table structure for table `kelas`
--

DROP TABLE IF EXISTS `kelas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `kelas` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `nama` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `urutan` tinyint NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `kelas`
--

LOCK TABLES `kelas` WRITE;
/*!40000 ALTER TABLE `kelas` DISABLE KEYS */;
INSERT INTO `kelas` VALUES (1,'I',1,'2026-07-17 07:14:47','2026-07-17 07:14:47'),(2,'II',2,'2026-07-17 07:14:47','2026-07-17 07:14:47'),(3,'III',3,'2026-07-17 07:14:47','2026-07-17 07:14:47'),(4,'IV',4,'2026-07-17 07:14:47','2026-07-17 07:14:47'),(5,'V',5,'2026-07-17 07:14:47','2026-07-17 07:14:47'),(6,'VI',6,'2026-07-17 07:14:47','2026-07-17 07:14:47');
/*!40000 ALTER TABLE `kelas` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `kriterias`
--

DROP TABLE IF EXISTS `kriterias`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `kriterias` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `kode` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nama` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `keterangan` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `kriterias`
--

LOCK TABLES `kriterias` WRITE;
/*!40000 ALTER TABLE `kriterias` DISABLE KEYS */;
INSERT INTO `kriterias` VALUES (1,'C1','Tingkat Nasional','bobot 0.5','2026-07-17 07:14:51','2026-07-17 07:14:51'),(2,'C2','Tingkat Provinsi','bobot 0.3','2026-07-17 07:14:51','2026-07-17 07:14:51'),(3,'C3','Tingkat Kabupaten/Kota','bobot 0.2','2026-07-17 07:14:51','2026-07-17 07:14:51');
/*!40000 ALTER TABLE `kriterias` ENABLE KEYS */;
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
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migrations`
--

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` VALUES (1,'0001_01_01_000000_create_users_table',1),(2,'0001_01_01_000001_create_cache_table',1),(3,'0001_01_01_000002_create_jobs_table',1),(4,'2026_07_16_000003_add_role_to_users_table',1),(5,'2026_07_16_000004_create_spk_tables',1),(6,'2026_07_16_000005_create_content_tables',1),(7,'2026_07_16_000006_create_rankings_table',1),(8,'2026_07_16_154651_add_penyelenggara_jenis_nilai_rubrik_to_prestasis_table',1),(9,'2026_07_16_154654_create_rubriks_table',1),(10,'2026_07_17_000001_create_kelas_table',1),(11,'2026_07_17_000002_update_siswas_table',1),(12,'2026_07_17_000003_add_nisn_to_users_table',1);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
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
-- Table structure for table `pengumumans`
--

DROP TABLE IF EXISTS `pengumumans`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `pengumumans` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `judul` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `isi` text COLLATE utf8mb4_unicode_ci,
  `tanggal` date NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pengumumans`
--

LOCK TABLES `pengumumans` WRITE;
/*!40000 ALTER TABLE `pengumumans` DISABLE KEYS */;
/*!40000 ALTER TABLE `pengumumans` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `periodes`
--

DROP TABLE IF EXISTS `periodes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `periodes` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `nama` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tahun` year NOT NULL,
  `tgl_buka` date DEFAULT NULL,
  `tgl_tutup` date DEFAULT NULL,
  `aktif` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `periodes`
--

LOCK TABLES `periodes` WRITE;
/*!40000 ALTER TABLE `periodes` DISABLE KEYS */;
INSERT INTO `periodes` VALUES (1,'SDM Award 2025/2026',2025,'2026-07-01','2026-08-08',1,'2026-07-17 07:14:47','2026-07-17 07:50:51');
/*!40000 ALTER TABLE `periodes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `prestasis`
--

DROP TABLE IF EXISTS `prestasis`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `prestasis` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `siswa_id` bigint unsigned NOT NULL,
  `periode_id` bigint unsigned NOT NULL,
  `nama_kegiatan` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tingkat` enum('kabupaten','provinsi','nasional','internasional') COLLATE utf8mb4_unicode_ci NOT NULL,
  `peringkat` enum('juara1','juara2','juara3') COLLATE utf8mb4_unicode_ci NOT NULL,
  `penyelenggara` enum('pemerintah','swasta') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pemerintah',
  `jenis` enum('perorangan','beregu') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'perorangan',
  `nilai_rubrik` decimal(5,2) DEFAULT NULL,
  `tanggal` date NOT NULL,
  `sertifikat_path` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status_validasi` enum('menunggu','valid','ditolak') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'menunggu',
  `catatan` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `prestasis_siswa_id_foreign` (`siswa_id`),
  KEY `prestasis_periode_id_foreign` (`periode_id`),
  CONSTRAINT `prestasis_periode_id_foreign` FOREIGN KEY (`periode_id`) REFERENCES `periodes` (`id`) ON DELETE CASCADE,
  CONSTRAINT `prestasis_siswa_id_foreign` FOREIGN KEY (`siswa_id`) REFERENCES `siswas` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `prestasis`
--

LOCK TABLES `prestasis` WRITE;
/*!40000 ALTER TABLE `prestasis` DISABLE KEYS */;
INSERT INTO `prestasis` VALUES (1,1,1,'OSN Matematika','nasional','juara1','pemerintah','perorangan',100.00,'2025-06-10',NULL,'valid',NULL,'2026-07-17 07:14:51','2026-07-17 07:14:51'),(2,1,1,'Festival Seni','provinsi','juara2','pemerintah','perorangan',70.00,'2025-08-15',NULL,'valid',NULL,'2026-07-17 07:14:51','2026-07-17 07:14:51'),(3,2,1,'Olimpiade Sains','nasional','juara3','pemerintah','perorangan',90.00,'2025-09-20',NULL,'valid',NULL,'2026-07-17 07:14:51','2026-07-17 07:14:51'),(4,2,1,'Lomba Tahfidz','kabupaten','juara1','pemerintah','perorangan',90.00,'2025-03-05',NULL,'menunggu',NULL,'2026-07-17 07:14:51','2026-07-17 07:14:51'),(5,3,1,'Lomba Pidato','provinsi','juara1','pemerintah','perorangan',80.00,'2025-07-12',NULL,'valid',NULL,'2026-07-17 07:14:51','2026-07-17 07:14:51'),(6,3,1,'MTQ Tingkat Kota','kabupaten','juara2','pemerintah','perorangan',85.00,'2025-04-18',NULL,'valid',NULL,'2026-07-17 07:14:51','2026-07-17 07:14:51'),(7,4,1,'Lomba Melukis','nasional','juara2','swasta','perorangan',85.00,'2025-10-01',NULL,'valid',NULL,'2026-07-17 07:14:51','2026-07-17 07:14:51'),(8,4,1,'Lomba Menyanyi','provinsi','juara3','swasta','perorangan',NULL,'2025-05-22',NULL,'menunggu',NULL,'2026-07-17 07:14:51','2026-07-17 07:14:51'),(9,5,1,'Olympiade IPS','nasional','juara1','pemerintah','beregu',95.00,'2025-11-03',NULL,'valid',NULL,'2026-07-17 07:14:51','2026-07-17 07:14:51'),(10,5,1,'Lomba Basket','kabupaten','juara1','swasta','beregu',75.00,'2025-02-14',NULL,'valid',NULL,'2026-07-17 07:14:51','2026-07-17 07:14:51');
/*!40000 ALTER TABLE `prestasis` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `rankings`
--

DROP TABLE IF EXISTS `rankings`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `rankings` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `periode_id` bigint unsigned NOT NULL,
  `panitia_id` bigint unsigned NOT NULL,
  `hasil` json NOT NULL,
  `disetujui_oleh` bigint unsigned DEFAULT NULL,
  `disetujui_at` timestamp NULL DEFAULT NULL,
  `diumumkan_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `rankings_periode_id_foreign` (`periode_id`),
  KEY `rankings_panitia_id_foreign` (`panitia_id`),
  KEY `rankings_disetujui_oleh_foreign` (`disetujui_oleh`),
  CONSTRAINT `rankings_disetujui_oleh_foreign` FOREIGN KEY (`disetujui_oleh`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  CONSTRAINT `rankings_panitia_id_foreign` FOREIGN KEY (`panitia_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  CONSTRAINT `rankings_periode_id_foreign` FOREIGN KEY (`periode_id`) REFERENCES `periodes` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `rankings`
--

LOCK TABLES `rankings` WRITE;
/*!40000 ALTER TABLE `rankings` DISABLE KEYS */;
/*!40000 ALTER TABLE `rankings` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `rubriks`
--

DROP TABLE IF EXISTS `rubriks`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `rubriks` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `penyelenggara` enum('pemerintah','swasta') COLLATE utf8mb4_unicode_ci NOT NULL,
  `peringkat` enum('juara1','juara2','juara3') COLLATE utf8mb4_unicode_ci NOT NULL,
  `jenis` enum('perorangan','beregu') COLLATE utf8mb4_unicode_ci NOT NULL,
  `tingkat` enum('nasional','provinsi','kabupaten') COLLATE utf8mb4_unicode_ci NOT NULL,
  `kode` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `skor` decimal(5,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `rubrik_uniq` (`penyelenggara`,`peringkat`,`jenis`,`tingkat`)
) ENGINE=InnoDB AUTO_INCREMENT=27 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `rubriks`
--

LOCK TABLES `rubriks` WRITE;
/*!40000 ALTER TABLE `rubriks` DISABLE KEYS */;
INSERT INTO `rubriks` VALUES (1,'pemerintah','juara1','perorangan','nasional','AA1',100.00,'2026-07-17 07:14:51','2026-07-17 07:14:51'),(2,'pemerintah','juara2','perorangan','nasional','AA2',95.00,'2026-07-17 07:14:51','2026-07-17 07:14:51'),(3,'pemerintah','juara3','perorangan','nasional','AA3',90.00,'2026-07-17 07:14:51','2026-07-17 07:14:51'),(4,'pemerintah','juara1','beregu','nasional','AA4',95.00,'2026-07-17 07:14:51','2026-07-17 07:14:51'),(5,'pemerintah','juara2','beregu','nasional','AA5',90.00,'2026-07-17 07:14:51','2026-07-17 07:14:51'),(6,'pemerintah','juara3','beregu','nasional','AA6',85.00,'2026-07-17 07:14:51','2026-07-17 07:14:51'),(7,'pemerintah','juara1','perorangan','provinsi','BA6',80.00,'2026-07-17 07:14:51','2026-07-17 07:14:51'),(8,'pemerintah','juara2','perorangan','provinsi','BB6',70.00,'2026-07-17 07:14:51','2026-07-17 07:14:51'),(9,'pemerintah','juara1','perorangan','kabupaten','CA1',90.00,'2026-07-17 07:14:51','2026-07-17 07:14:51'),(10,'pemerintah','juara2','perorangan','kabupaten','CA2',85.00,'2026-07-17 07:14:51','2026-07-17 07:14:51'),(11,'pemerintah','juara3','perorangan','kabupaten','CA3',80.00,'2026-07-17 07:14:51','2026-07-17 07:14:51'),(12,'pemerintah','juara1','beregu','kabupaten','CA4',85.00,'2026-07-17 07:14:51','2026-07-17 07:14:51'),(13,'pemerintah','juara2','beregu','kabupaten','CA5',80.00,'2026-07-17 07:14:51','2026-07-17 07:14:51'),(14,'pemerintah','juara3','beregu','kabupaten','CA6',75.00,'2026-07-17 07:14:51','2026-07-17 07:14:51'),(15,'swasta','juara1','perorangan','nasional','AB1',90.00,'2026-07-17 07:14:51','2026-07-17 07:14:51'),(16,'swasta','juara2','perorangan','nasional','AB2',85.00,'2026-07-17 07:14:51','2026-07-17 07:14:51'),(17,'swasta','juara3','perorangan','nasional','AB3',80.00,'2026-07-17 07:14:51','2026-07-17 07:14:51'),(18,'swasta','juara1','beregu','nasional','AB4',85.00,'2026-07-17 07:14:51','2026-07-17 07:14:51'),(19,'swasta','juara2','beregu','nasional','AB5',80.00,'2026-07-17 07:14:51','2026-07-17 07:14:51'),(20,'swasta','juara3','beregu','nasional','AB6',75.00,'2026-07-17 07:14:51','2026-07-17 07:14:51'),(21,'swasta','juara1','perorangan','kabupaten','CB1',80.00,'2026-07-17 07:14:51','2026-07-17 07:14:51'),(22,'swasta','juara2','perorangan','kabupaten','CB2',75.00,'2026-07-17 07:14:51','2026-07-17 07:14:51'),(23,'swasta','juara3','perorangan','kabupaten','CB3',70.00,'2026-07-17 07:14:51','2026-07-17 07:14:51'),(24,'swasta','juara1','beregu','kabupaten','CB4',75.00,'2026-07-17 07:14:51','2026-07-17 07:14:51'),(25,'swasta','juara2','beregu','kabupaten','CB5',70.00,'2026-07-17 07:14:51','2026-07-17 07:14:51'),(26,'swasta','juara3','beregu','kabupaten','CB6',65.00,'2026-07-17 07:14:51','2026-07-17 07:14:51');
/*!40000 ALTER TABLE `rubriks` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sessions`
--

DROP TABLE IF EXISTS `sessions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `sessions` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint unsigned DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `sessions_user_id_index` (`user_id`),
  KEY `sessions_last_activity_index` (`last_activity`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sessions`
--

LOCK TABLES `sessions` WRITE;
/*!40000 ALTER TABLE `sessions` DISABLE KEYS */;
INSERT INTO `sessions` VALUES ('1N4LuLsl4jTFEAnSddaNTEviZYxhCTdU1ZG48XH5',NULL,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36','eyJfdG9rZW4iOiI0NHR4cTZUS0ZxT1ZkVHZCM01vNzgxV2x0d1dQUEVhQWwwMTIwb1VMIiwiX2ZsYXNoIjp7Im9sZCI6W10sIm5ldyI6W119LCJfcHJldmlvdXMiOnsidXJsIjoiaHR0cDpcL1wvMTI3LjAuMC4xOjgwMDAiLCJyb3V0ZSI6ImxhbmRpbmcifX0=',1784361214),('2idLeU0mQBs0ZpSOOwORRRIWGOsTPwgkee0XyurD',1,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36','eyJfdG9rZW4iOiJWRklkUzBPdWpjMklsSTdOYTBGMnpZb1gzR05ycmx0Tm56VTJQenFNIiwiX2ZsYXNoIjp7Im9sZCI6W10sIm5ldyI6W119LCJfcHJldmlvdXMiOnsidXJsIjoiaHR0cDpcL1wvMTI3LjAuMC4xOjgwMDBcL3BhbmVsXC9yYW5raW5nIiwicm91dGUiOiJwYW5lbC5yYW5raW5nIn0sImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjoxfQ==',1784309683),('2jTPc02cbVgIqNsGaqaoFC6kNv0HWC7GT6QfFulv',NULL,'127.0.0.1','curl/8.17.0','eyJfdG9rZW4iOiJXQlpKY3JhNjZabWF6Vlp0MTNFU3hPZkVzR3ViWEZOT1ZrYlQ3WVY3IiwiX3ByZXZpb3VzIjp7InVybCI6Imh0dHA6XC9cL3Nway1zZG1hd2FyZC50ZXN0Iiwicm91dGUiOiJsYW5kaW5nIn0sIl9mbGFzaCI6eyJvbGQiOltdLCJuZXciOltdfX0=',1784309159),('40sy4y98kZOVz8KGu0dXuSTi5Cy4zlNjQwP71rQp',NULL,'127.0.0.1','curl/8.17.0','eyJfdG9rZW4iOiJ6N1Z5UHE2MVBFSXR6YzI2UFFrdmxwT3hnbGJPTWNyWDZQRVZFU3E0IiwidXJsIjp7ImludGVuZGVkIjoiaHR0cDpcL1wvMTI3LjAuMC4xOjgwMDBcL3BhbmVsXC92YWxpZGFzaVwva2VsYXMifSwiX3ByZXZpb3VzIjp7InVybCI6Imh0dHA6XC9cLzEyNy4wLjAuMTo4MDAwXC9wYW5lbFwvdmFsaWRhc2lcL2tlbGFzIiwicm91dGUiOiJwYW5lbC52YWxpZGFzaS5rZWxhcyJ9LCJfZmxhc2giOnsib2xkIjpbXSwibmV3IjpbXX19',1784304099),('6CGNVq45WzpSd2kgS2yR11mQSodk7f32awdlsTsd',NULL,'127.0.0.1','curl/8.17.0','eyJfdG9rZW4iOiJHM3dndVBrSkVwelJvNWh5ZDZGeVM2eklvbWtKNFpiUG0wazFuOGtxIiwiX3ByZXZpb3VzIjp7InVybCI6Imh0dHA6XC9cL3Nway1zZG1hd2FyZC50ZXN0Iiwicm91dGUiOiJsYW5kaW5nIn0sIl9mbGFzaCI6eyJvbGQiOltdLCJuZXciOltdfX0=',1784351456),('8HfbSnESJnVayogAWDXkfl2GNVHMDhNz6RKoiZAc',NULL,'127.0.0.1','curl/8.17.0','eyJfdG9rZW4iOiIwU3ZLb0FOZE43aGpROVhYcjRHSzFLSjdaNE9LSWJYSWZlYm5ORURhIiwiX3ByZXZpb3VzIjp7InVybCI6Imh0dHA6XC9cL3Nway1zZG1hd2FyZC50ZXN0XC9wYW5lbFwvcGVuaWxhaWFuXC9rZWxhcyIsInJvdXRlIjoicGFuZWwucGVuaWxhaWFuLmtlbGFzIn0sIl9mbGFzaCI6eyJvbGQiOltdLCJuZXciOltdfSwidXJsIjp7ImludGVuZGVkIjoiaHR0cDpcL1wvc3BrLXNkbWF3YXJkLnRlc3RcL3BhbmVsXC9wZW5pbGFpYW5cL2tlbGFzIn19',1784309196),('9H0dCQmtONnIRpLdyNtL946lpE13GOmnbtXWNyFq',NULL,'127.0.0.1','curl/8.17.0','eyJfdG9rZW4iOiJHUHJOQ2pVazVKVG16UTJBSkZjUlM2dnhiMFdwMmtNNUNvMFRGbHhWIiwidXJsIjp7ImludGVuZGVkIjoiaHR0cDpcL1wvMTI3LjAuMC4xOjgwMDBcL3BhbmVsXC92YWxpZGFzaVwva2VsYXMifSwiX3ByZXZpb3VzIjp7InVybCI6Imh0dHA6XC9cLzEyNy4wLjAuMTo4MDAwXC9wYW5lbFwvdmFsaWRhc2lcL2tlbGFzIiwicm91dGUiOiJwYW5lbC52YWxpZGFzaS5rZWxhcyJ9LCJfZmxhc2giOnsib2xkIjpbXSwibmV3IjpbXX19',1784308665),('aMM7qyZvPG6ePJJN2KjrlrxlfWd5aJUKK1bQKmxE',NULL,'127.0.0.1','curl/8.17.0','eyJfdG9rZW4iOiJtUTVleVJFRDVxejduY3Ywa2hPSHVvVTN5alZaNUlLS0VkVXBOb3FUIiwidXJsIjp7ImludGVuZGVkIjoiaHR0cDpcL1wvMTI3LjAuMC4xOjgwMDBcL3BhbmVsXC92YWxpZGFzaVwva2VsYXMifSwiX3ByZXZpb3VzIjp7InVybCI6Imh0dHA6XC9cLzEyNy4wLjAuMTo4MDAwXC9wYW5lbFwvdmFsaWRhc2lcL2tlbGFzIiwicm91dGUiOiJwYW5lbC52YWxpZGFzaS5rZWxhcyJ9LCJfZmxhc2giOnsib2xkIjpbXSwibmV3IjpbXX19',1784303227),('AshTcfp6pB3mDyBn0ypbFwLkDF4VE20uirC8cXi7',NULL,'127.0.0.1','curl/8.17.0','eyJfdG9rZW4iOiJoZWYwbXpIajBiU09zRG5sUlczbG5aa2ZsbHB1Z2NCSlVNSUNWMXlyIiwiX3ByZXZpb3VzIjp7InVybCI6Imh0dHA6XC9cL3Nway1zZG1hd2FyZC50ZXN0Iiwicm91dGUiOiJsYW5kaW5nIn0sIl9mbGFzaCI6eyJvbGQiOltdLCJuZXciOltdfX0=',1784309159),('bzIvzEgvNPxpuWWAyCzMv4xhDzhO3AIs3T4LEvkM',NULL,'127.0.0.1','curl/8.17.0','eyJfdG9rZW4iOiJhQ2JCVUtaaGFzZjFBemtoVHJ5YVkyNUVtOTFKVThTNjIyRGFaeE95IiwiX3ByZXZpb3VzIjp7InVybCI6Imh0dHA6XC9cL3Nway1zZG1hd2FyZC50ZXN0Iiwicm91dGUiOiJsYW5kaW5nIn0sIl9mbGFzaCI6eyJvbGQiOltdLCJuZXciOltdfX0=',1784343432),('CEDGx44INDx8BhsLztvW9T7RzOnvQ9EH7Wpd5pfj',NULL,'127.0.0.1','curl/8.17.0','eyJfdG9rZW4iOiI2VnZ6NlY4TlhITk1YeE55eGFDelNLZ0xLS0hQOXRwTkFsT0dnT0JlIiwiX3ByZXZpb3VzIjp7InVybCI6Imh0dHA6XC9cLzEyNy4wLjAuMTo4MDAwIiwicm91dGUiOiJsYW5kaW5nIn0sIl9mbGFzaCI6eyJvbGQiOltdLCJuZXciOltdfX0=',1784304227),('d5Bl6x8RZl8wQKKIkrrYCTd2tdBhrJTwxagdwQzF',NULL,'127.0.0.1','curl/8.17.0','eyJfdG9rZW4iOiJlTEdObDJzQXRUM0VtaUl6ekRjd0laZmxmMVRvaHlxRkxueWpxRXBGIiwidXJsIjp7ImludGVuZGVkIjoiaHR0cDpcL1wvc3BrLXNkbWF3YXJkLnRlc3RcL3BhbmVsXC9yYW5raW5nIn0sIl9wcmV2aW91cyI6eyJ1cmwiOiJodHRwOlwvXC9zcGstc2RtYXdhcmQudGVzdFwvcGFuZWxcL3JhbmtpbmciLCJyb3V0ZSI6InBhbmVsLnJhbmtpbmcifSwiX2ZsYXNoIjp7Im9sZCI6W10sIm5ldyI6W119fQ==',1784309039),('DAVjhxWv2BEG1mP9MKKULLEyi2EvBOcoz60mtbAe',NULL,'127.0.0.1','curl/8.17.0','eyJfdG9rZW4iOiJRUmo1YkV5U2ZLV05KUjhXcDE5M2oycm5ZRmdaTUthQmtEcVl1YlREIiwiX3ByZXZpb3VzIjp7InVybCI6Imh0dHA6XC9cL3Nway1zZG1hd2FyZC50ZXN0Iiwicm91dGUiOiJsYW5kaW5nIn0sIl9mbGFzaCI6eyJvbGQiOltdLCJuZXciOltdfX0=',1784352502),('gBVLu1hCvVg5v1nLHLhrdgfELu7MGyiCR2LqJIB0',NULL,'127.0.0.1','curl/8.17.0','eyJfdG9rZW4iOiJ6b1VIQ3pKWjJkaW9KN0YyZzFsbGxmeUl2OUJGZ2ZNN3RUWlNIUUljIiwiX3ByZXZpb3VzIjp7InVybCI6Imh0dHA6XC9cLzEyNy4wLjAuMTo4MDAwIiwicm91dGUiOiJsYW5kaW5nIn0sIl9mbGFzaCI6eyJvbGQiOltdLCJuZXciOltdfX0=',1784303372),('Gpi7JFdMDI1sicKOaf6dGanxocPUpNsIPVT1uIYu',NULL,'127.0.0.1','curl/8.17.0','eyJfdG9rZW4iOiJNcGFtZXFSUnlJNFY4RDg0eGpNRXl5Y2czSGxPZ0tNbDNQVGRVTFQ2IiwidXJsIjp7ImludGVuZGVkIjoiaHR0cDpcL1wvMTI3LjAuMC4xOjgwMDBcL3BhbmVsXC92YWxpZGFzaVwva2VsYXMifSwiX3ByZXZpb3VzIjp7InVybCI6Imh0dHA6XC9cLzEyNy4wLjAuMTo4MDAwXC9wYW5lbFwvdmFsaWRhc2lcL2tlbGFzIiwicm91dGUiOiJwYW5lbC52YWxpZGFzaS5rZWxhcyJ9LCJfZmxhc2giOnsib2xkIjpbXSwibmV3IjpbXX19',1784304100),('jiseDRlb0KgF798kWYSMSqNXv4S4uVqNC2T6tLWx',NULL,'127.0.0.1','curl/8.17.0','eyJfdG9rZW4iOiJZNWlVcTc2ZzQ3bEs5T0dLSk5rMWdrejB4YkdYZzVOVDVtZnY1Mk1FIiwiX3ByZXZpb3VzIjp7InVybCI6Imh0dHA6XC9cLzEyNy4wLjAuMTo4MDAwXC9sb2dpbiIsInJvdXRlIjoibG9naW4ifSwiX2ZsYXNoIjp7Im9sZCI6W10sIm5ldyI6W119fQ==',1784308664),('jmvjVw5JjPH6Ms1aKA7hlKCwEjrGyX6BbEz7YouS',NULL,'127.0.0.1','curl/8.17.0','eyJfdG9rZW4iOiJpN1JEVUJMc3QwdTZ6bFpaUU5udjdLMWdsV1hHN2VOZmcyVXZScHo1IiwiX3ByZXZpb3VzIjp7InVybCI6Imh0dHA6XC9cLzEyNy4wLjAuMTo4MDAwIiwicm91dGUiOiJsYW5kaW5nIn0sIl9mbGFzaCI6eyJvbGQiOltdLCJuZXciOltdfX0=',1784303159),('K6AM6yPyzvDW9ww78jGNBI48BKBvz2qp7YmTOSjM',NULL,'127.0.0.1','curl/8.17.0','eyJfdG9rZW4iOiIzdVdrREpZYzVrTnZyUVpJdGhGUTN3N0NzcDNqZjUyZGxPaWFjcU9pIiwiX3ByZXZpb3VzIjp7InVybCI6Imh0dHA6XC9cL3Nway1zZG1hd2FyZC50ZXN0XC9sb2dpbiIsInJvdXRlIjoibG9naW4ifSwiX2ZsYXNoIjp7Im9sZCI6W10sIm5ldyI6W119fQ==',1784309075),('KcC6qVdwERix4LfxyN5GvquoqgyNPcksNGYhBaj2',NULL,'127.0.0.1','curl/8.17.0','eyJfdG9rZW4iOiJ2WE50SjRtMUZOOGRSbmJIZHFBZE04ZHZ1a1BGZlV1Mk9ZOFBnQVhrIiwiX3ByZXZpb3VzIjp7InVybCI6Imh0dHA6XC9cLzEyNy4wLjAuMTo4MDAwIiwicm91dGUiOiJsYW5kaW5nIn0sIl9mbGFzaCI6eyJvbGQiOltdLCJuZXciOltdfX0=',1784306014),('kHQfeKBKNbo6SZTPUKOJyGw7jeNSbR9tsdYhx6Ac',NULL,'127.0.0.1','curl/8.17.0','eyJfdG9rZW4iOiJhaVNWNkRjMUdPQ1dqdzI1YVRwa1JHSTYwWTQ5azAyaGlsZWVGY2JCIiwidXJsIjp7ImludGVuZGVkIjoiaHR0cDpcL1wvMTI3LjAuMC4xOjgwMDBcL3BhbmVsXC9wZW5pbGFpYW5cL2tlbGFzIn0sIl9wcmV2aW91cyI6eyJ1cmwiOiJodHRwOlwvXC8xMjcuMC4wLjE6ODAwMFwvcGFuZWxcL3BlbmlsYWlhblwva2VsYXMiLCJyb3V0ZSI6InBhbmVsLnBlbmlsYWlhbi5rZWxhcyJ9LCJfZmxhc2giOnsib2xkIjpbXSwibmV3IjpbXX19',1784308666),('kmaGzZ8aOMWeiND5Yj8jJV67pT4BVEHHmTpoh9Nt',NULL,'127.0.0.1','curl/8.17.0','eyJfdG9rZW4iOiJzQUdrWnlnRHJvd1o3ODJpalRqbHE5d2Naa1piZmhjNjE3YTZvNTFKIiwiX3ByZXZpb3VzIjp7InVybCI6Imh0dHA6XC9cL3Nway1zZG1hd2FyZC50ZXN0XC9sb2dpbiIsInJvdXRlIjoibG9naW4ifSwiX2ZsYXNoIjp7Im9sZCI6W10sIm5ldyI6W119fQ==',1784309076),('kUvPD5yJUkIwnFas8HWHnCMrQVN6O6olY30nEolA',NULL,'127.0.0.1','curl/8.17.0','eyJfdG9rZW4iOiJJbmJ0OW5kelVzem9mYTNkVHg3S3JqbXlHTzRtcEllM1FNek5kd29jIiwiX3ByZXZpb3VzIjp7InVybCI6Imh0dHA6XC9cLzEyNy4wLjAuMTo4MDAwIiwicm91dGUiOiJsYW5kaW5nIn0sIl9mbGFzaCI6eyJvbGQiOltdLCJuZXciOltdfX0=',1784308662),('KvcLwCGGRtVmDzwgn1j5uJqGrDHpGqsHeljZZbiZ',NULL,'127.0.0.1','curl/8.17.0','eyJfdG9rZW4iOiJEQlVjaWQ1cFc1TU9SNWVWcEFGcGNiR3JRQVJNN1hLZThlRTlPdjN6IiwiX3ByZXZpb3VzIjp7InVybCI6Imh0dHA6XC9cL3Nway1zZG1hd2FyZC50ZXN0Iiwicm91dGUiOiJsYW5kaW5nIn0sIl9mbGFzaCI6eyJvbGQiOltdLCJuZXciOltdfX0=',1784309038),('lldYDZwXJDfucjG2ZsuaBfXS7eN2rhCLzm1nqHi4',NULL,'127.0.0.1','curl/8.17.0','eyJfdG9rZW4iOiJDcmRIZGI1RkVOc2ZQbWRxZmh3SW1WbzVZcFpGT2J3cDJ3NWJ0c2FpIiwiX3ByZXZpb3VzIjp7InVybCI6Imh0dHA6XC9cLzEyNy4wLjAuMTo4MDAwIiwicm91dGUiOiJsYW5kaW5nIn0sIl9mbGFzaCI6eyJvbGQiOltdLCJuZXciOltdfX0=',1784308722),('m1V3ai868W62I7c66HMQan7fEBhs4Mk0UaZIndZM',NULL,'127.0.0.1','curl/8.17.0','eyJfdG9rZW4iOiJSVkpIS2dCNWpUQms3em0wejlMUm9WTTh0Wm9OOFRyV3JIa3VlUVpWIiwiX3ByZXZpb3VzIjp7InVybCI6Imh0dHA6XC9cLzEyNy4wLjAuMTo4MDAwIiwicm91dGUiOiJsYW5kaW5nIn0sIl9mbGFzaCI6eyJvbGQiOltdLCJuZXciOltdfX0=',1784304816),('mGt9oRR0ixJtht5gESYIfQwim3hbGHupz1cOKcTP',NULL,'127.0.0.1','curl/8.17.0','eyJfdG9rZW4iOiJOc1FRUWJ2Um04VnU3d2NtRG0xSHZoUm1FS1NlZ0k4MVVqeThLWTQxIiwiX3ByZXZpb3VzIjp7InVybCI6Imh0dHA6XC9cL3Nway1zZG1hd2FyZC50ZXN0Iiwicm91dGUiOiJsYW5kaW5nIn0sIl9mbGFzaCI6eyJvbGQiOltdLCJuZXciOltdfX0=',1784342346),('mkpC9xl7FQk3u7nykRRSR8sYVuiu3K9U4rbhI5JU',NULL,'127.0.0.1','curl/8.17.0','eyJfdG9rZW4iOiI3YTFlb2FJUUFFb0ZXSmVXV3hFeW9xUTFPWnQyMmhjUWZhaGxxN25tIiwiX3ByZXZpb3VzIjp7InVybCI6Imh0dHA6XC9cLzEyNy4wLjAuMTo4MDAwIiwicm91dGUiOiJsYW5kaW5nIn0sIl9mbGFzaCI6eyJvbGQiOltdLCJuZXciOltdfX0=',1784303991),('NiiVMeVg6vNgl0fg2te6gRAHjb1JqM1ZsuZEGiZY',NULL,'127.0.0.1','curl/8.17.0','eyJfdG9rZW4iOiJlOUFUMFRSdTQxMnJYNFMzVUJBQ0xQRE1xSnZoTFZITjJTSkdqdDRMIiwidXJsIjp7ImludGVuZGVkIjoiaHR0cDpcL1wvMTI3LjAuMC4xOjgwMDBcL3BhbmVsXC9yYW5raW5nIn0sIl9wcmV2aW91cyI6eyJ1cmwiOiJodHRwOlwvXC8xMjcuMC4wLjE6ODAwMFwvcGFuZWxcL3JhbmtpbmciLCJyb3V0ZSI6InBhbmVsLnJhbmtpbmcifSwiX2ZsYXNoIjp7Im9sZCI6W10sIm5ldyI6W119fQ==',1784307485),('NPc8biZgbnwYeO5KFcoj6gxsnbwNE6rDwcXYFj0Q',NULL,'127.0.0.1','curl/8.17.0','eyJfdG9rZW4iOiJBbWdicGhMRmk0T3g1UFM1N09ld1A5eUtaVDNacG5yenJrQWwzTlBKIiwiX3ByZXZpb3VzIjp7InVybCI6Imh0dHA6XC9cL3Nway1zZG1hd2FyZC50ZXN0Iiwicm91dGUiOiJsYW5kaW5nIn0sIl9mbGFzaCI6eyJvbGQiOltdLCJuZXciOltdfX0=',1784309158),('NSx1OPs0ZsSBtT4z3TsRBSRy79FG0spxcrycGb39',NULL,'127.0.0.1','curl/8.17.0','eyJfdG9rZW4iOiJGWm9YMXpSb09aTXI4djBkRGZheVJlN3dXcnR6SWx4bmFmSkFNRXU2IiwidXJsIjp7ImludGVuZGVkIjoiaHR0cDpcL1wvMTI3LjAuMC4xOjgwMDBcL3BhbmVsXC92YWxpZGFzaVwva2VsYXMifSwiX3ByZXZpb3VzIjp7InVybCI6Imh0dHA6XC9cLzEyNy4wLjAuMTo4MDAwXC9wYW5lbFwvdmFsaWRhc2lcL2tlbGFzIiwicm91dGUiOiJwYW5lbC52YWxpZGFzaS5rZWxhcyJ9LCJfZmxhc2giOnsib2xkIjpbXSwibmV3IjpbXX19',1784303228),('OcEG40LYeAJ74o0XVTXwpzymCeA1gcEvjZKYOtqM',NULL,'127.0.0.1','curl/8.17.0','eyJfdG9rZW4iOiIzVmtwR2JLaHVmVkRtWGtzS0lYN2hOSEdGcHU5VnJ4VGVBdWZybXlXIiwiX3ByZXZpb3VzIjp7InVybCI6Imh0dHA6XC9cLzEyNy4wLjAuMTo4MDAwIiwicm91dGUiOiJsYW5kaW5nIn0sIl9mbGFzaCI6eyJvbGQiOltdLCJuZXciOltdfX0=',1784308459),('oThQ4iM3bMd3fyxLTx4tCYJIC5UgjFyj4QC0TM0z',NULL,'127.0.0.1','curl/8.17.0','eyJfdG9rZW4iOiJRUHVldWgxb0dRMlMyUjRjSWlvY21qV011elQzQTBpZU1VTXJxU1Y0IiwiX3ByZXZpb3VzIjp7InVybCI6Imh0dHA6XC9cLzEyNy4wLjAuMTo4MDAwIiwicm91dGUiOiJsYW5kaW5nIn0sIl9mbGFzaCI6eyJvbGQiOltdLCJuZXciOltdfX0=',1784302865),('PQs1BSAnU22naeeMtfyy9xGmmNXLbIfprxlFijgB',NULL,'127.0.0.1','curl/8.17.0','eyJfdG9rZW4iOiIwYnpoandrbFRUWHNZZDhMZHZhd3Mzdnp2enl0VVFONGJ0aWxZUVp0IiwiX3ByZXZpb3VzIjp7InVybCI6Imh0dHA6XC9cL3Nway1zZG1hd2FyZC50ZXN0XC9sb2dpbiIsInJvdXRlIjoibG9naW4ifSwiX2ZsYXNoIjp7Im9sZCI6W10sIm5ldyI6W119fQ==',1784309074),('PSFS0ZwDeZzEpUmWG8xkUSK3WeUFVgGpWBhMbwxX',NULL,'127.0.0.1','curl/8.17.0','eyJfdG9rZW4iOiJlTEtvNkFBYkxMOUt2RnpodzM4V2c2UXg3NGI0aDdrU1poMDZVVzZkIiwidXJsIjp7ImludGVuZGVkIjoiaHR0cDpcL1wvMTI3LjAuMC4xOjgwMDBcL3BhbmVsXC9yZWthcCJ9LCJfcHJldmlvdXMiOnsidXJsIjoiaHR0cDpcL1wvMTI3LjAuMC4xOjgwMDBcL3BhbmVsXC9yZWthcCIsInJvdXRlIjoicGFuZWwucmVrYXAuaW5kZXgifSwiX2ZsYXNoIjp7Im9sZCI6W10sIm5ldyI6W119fQ==',1784307137),('pycQyAEzfKVm2u9yHDck7dZcbvpdiftz7qrhT1vV',NULL,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36','eyJfdG9rZW4iOiJMVkdsRnlWRnlqTW1xQnEwU3h5aUdCa0QyOTJMYTdzWnYxN3BPN3hIIiwiX2ZsYXNoIjp7Im9sZCI6W10sIm5ldyI6W119fQ==',1784308372),('Q2KFi9XGuzoZr0yxZzHe0ICqbYpsC1LXlRYDX1vb',NULL,'127.0.0.1','curl/8.17.0','eyJfdG9rZW4iOiJ4U0NhMXQ0TzBSRE9SeE52YjdKbXBxUGFwZTUwdnNUcXkweXZWTlJSIiwiX3ByZXZpb3VzIjp7InVybCI6Imh0dHA6XC9cLzEyNy4wLjAuMTo4MDAwXC9sb2dpbiIsInJvdXRlIjoibG9naW4ifSwiX2ZsYXNoIjp7Im9sZCI6W10sIm5ldyI6W119fQ==',1784308292),('RdsWaapiR6yDa7MdLh1odmLE3acUBnvzXh4gWqda',NULL,'127.0.0.1','curl/8.17.0','eyJfdG9rZW4iOiJUcUE5YmxmbmNTS3VaYUMzWDZmZ3Z6STRHRmRMNUg4b3puT2g5eGREIiwiX3ByZXZpb3VzIjp7InVybCI6Imh0dHA6XC9cLzEyNy4wLjAuMTo4MDAwXC9sb2dpbiIsInJvdXRlIjoibG9naW4ifSwiX2ZsYXNoIjp7Im9sZCI6W10sIm5ldyI6W119fQ==',1784308724),('SGndYZTPOLXc1UgqyDDDsIrs8AEtbCsA4cF6IqH5',NULL,'127.0.0.1','curl/8.17.0','eyJfdG9rZW4iOiJpS2hRYmxNSVRPcnpXa05rcE9ZUzR6V2FNTkRrVTdTTVZKTlQwYjJOIiwidXJsIjp7ImludGVuZGVkIjoiaHR0cDpcL1wvMTI3LjAuMC4xOjgwMDBcL3BhbmVsXC9yYW5raW5nIn0sIl9wcmV2aW91cyI6eyJ1cmwiOiJodHRwOlwvXC8xMjcuMC4wLjE6ODAwMFwvcGFuZWxcL3JhbmtpbmciLCJyb3V0ZSI6InBhbmVsLnJhbmtpbmcifSwiX2ZsYXNoIjp7Im9sZCI6W10sIm5ldyI6W119fQ==',1784308668),('SIQhvmCJCAZ9G87amOrDTd69UCCNRcdBODjDboct',NULL,'127.0.0.1','curl/8.17.0','eyJfdG9rZW4iOiI0ME5VYXp1MEhPSXV4aTQ1UmVwVUlCcU1pcGg0aEVtclI0Y09kS0hPIiwidXJsIjp7ImludGVuZGVkIjoiaHR0cDpcL1wvMTI3LjAuMC4xOjgwMDBcL3BhbmVsXC9yZWthcCJ9LCJfcHJldmlvdXMiOnsidXJsIjoiaHR0cDpcL1wvMTI3LjAuMC4xOjgwMDBcL3BhbmVsXC9yZWthcCIsInJvdXRlIjoicGFuZWwucmVrYXAuaW5kZXgifSwiX2ZsYXNoIjp7Im9sZCI6W10sIm5ldyI6W119fQ==',1784308667),('sogKt1GMOH8MtMtEN0Mp60ukxzRawGaY8fmmBDUM',NULL,'127.0.0.1','curl/8.17.0','eyJfdG9rZW4iOiI5ZDNNUms4Zmh2a21qNnp6aW54UU9YQkI0dWZwd09pc0lxNmE1eU9HIiwidXJsIjp7ImludGVuZGVkIjoiaHR0cDpcL1wvMTI3LjAuMC4xOjgwMDBcL3BhbmVsXC92YWxpZGFzaVwva2VsYXMifSwiX3ByZXZpb3VzIjp7InVybCI6Imh0dHA6XC9cLzEyNy4wLjAuMTo4MDAwXC9wYW5lbFwvdmFsaWRhc2lcL2tlbGFzIiwicm91dGUiOiJwYW5lbC52YWxpZGFzaS5rZWxhcyJ9LCJfZmxhc2giOnsib2xkIjpbXSwibmV3IjpbXX19',1784304122),('StXjKxPIhireycLANo3RAfDlzfTTWqaPVDUQpOc4',NULL,'127.0.0.1','curl/8.17.0','eyJfdG9rZW4iOiIyanRHRzEwaFFkTjQ1SWZPTlYzNndjRnBPb25pdTVsR0V3blBoWkZZIiwiX3ByZXZpb3VzIjp7InVybCI6Imh0dHA6XC9cLzEyNy4wLjAuMTo4MDAwIiwicm91dGUiOiJsYW5kaW5nIn0sIl9mbGFzaCI6eyJvbGQiOltdLCJuZXciOltdfX0=',1784304506),('SUMfgoTzTA7lYJ6QFYEnpipYuhmCDm8mJkxi3eee',NULL,'127.0.0.1','curl/8.17.0','eyJfdG9rZW4iOiJDVnRpRlYxS3pFY2JYdUVabE91S0JreXhJQmVIQnZkdW4yQkFzMG02IiwiX3ByZXZpb3VzIjp7InVybCI6Imh0dHA6XC9cLzEyNy4wLjAuMTo4MDAwIiwicm91dGUiOiJsYW5kaW5nIn0sIl9mbGFzaCI6eyJvbGQiOltdLCJuZXciOltdfX0=',1784305683),('uTFdO5hZ1g5VAPQdf8PtUXPXwTnLuv0thnoxXQu6',NULL,'127.0.0.1','curl/8.17.0','eyJfdG9rZW4iOiJoMWtXWHV3RXhjcVdhVEJZN1hIRld6MmhpQzg2c0hYUjJDU2lGbVRiIiwiX3ByZXZpb3VzIjp7InVybCI6Imh0dHA6XC9cL3Nway1zZG1hd2FyZC50ZXN0XC9sb2dpbiIsInJvdXRlIjoibG9naW4ifSwiX2ZsYXNoIjp7Im9sZCI6W10sIm5ldyI6W119fQ==',1784309159),('UvR5QwZbfFGWJK25wXYlZ5AJZAbj7ifno8IqO3fN',NULL,'127.0.0.1','curl/8.17.0','eyJfdG9rZW4iOiJKeEE3RFF1Nk00S1B4N3duRG94VzdDVTNEWEd0V05aYVdicjRhcEs0IiwiX3ByZXZpb3VzIjp7InVybCI6Imh0dHA6XC9cLzEyNy4wLjAuMTo4MDAwIiwicm91dGUiOiJsYW5kaW5nIn0sIl9mbGFzaCI6eyJvbGQiOltdLCJuZXciOltdfX0=',1784305846),('WDyA6j5ZEMGExqQB77A0nGTQpr4jOsHeePS6eeCt',NULL,'127.0.0.1','curl/8.17.0','eyJfdG9rZW4iOiJOMWFUc1RZVXJ2aTJUcWdQa0doSGdYYTRScXhOaFowRVFTejBEZHVpIiwiX3ByZXZpb3VzIjp7InVybCI6Imh0dHA6XC9cL3Nway1zZG1hd2FyZC50ZXN0XC9sb2dpbiIsInJvdXRlIjoibG9naW4ifSwiX2ZsYXNoIjp7Im9sZCI6W10sIm5ldyI6W119fQ==',1784309171),('wnoZJ5clJLKVcNc2jniHqU8tRoUkd0TdTCbQJlCl',NULL,'127.0.0.1','curl/8.17.0','eyJfdG9rZW4iOiI4ODNTbTBQTFFLem5wYlV4VHB5Q1VHa2x2WmdVUTE5VkJTdUx4SnFaIiwiX3ByZXZpb3VzIjp7InVybCI6Imh0dHA6XC9cLzEyNy4wLjAuMTo4MDAwIiwicm91dGUiOiJsYW5kaW5nIn0sIl9mbGFzaCI6eyJvbGQiOltdLCJuZXciOltdfX0=',1784303642),('xAUUFCeahao9Spac9JejH8MTUD5myDAtBAMsTSiM',NULL,'127.0.0.1','curl/8.17.0','eyJfdG9rZW4iOiJybFROdmFBT3FPT2lKVlpIM1F3Q1Zlb0hjbTh2dnJEdUJHeWNYNm1tIiwiX3ByZXZpb3VzIjp7InVybCI6Imh0dHA6XC9cL3Nway1zZG1hd2FyZC50ZXN0XC9sb2dpbiIsInJvdXRlIjoibG9naW4ifSwiX2ZsYXNoIjp7Im9sZCI6W10sIm5ldyI6W119fQ==',1784309158),('Xp919xUC2sUi11IyciIKzg7a0IksM1s6nunFb6no',NULL,'127.0.0.1','curl/8.17.0','eyJfdG9rZW4iOiJzTEhnVW9iSTFrcWxhZVlpeUtmc2o2dDd1NWtXM3N4RGo2SFdqaFZGIiwiX3ByZXZpb3VzIjp7InVybCI6Imh0dHA6XC9cL3Nway1zZG1hd2FyZC50ZXN0Iiwicm91dGUiOiJsYW5kaW5nIn0sIl9mbGFzaCI6eyJvbGQiOltdLCJuZXciOltdfX0=',1784309077),('xUNFAPizjXxz7GENf4fZll5IEiiTxGBOUxehdXxs',NULL,'127.0.0.1','curl/8.17.0','eyJfdG9rZW4iOiJpZXdOTjhjU3hMWXcyaW50RVFHMEUwOTIwU3pxb2lseEFOaWxsanBwIiwiX3ByZXZpb3VzIjp7InVybCI6Imh0dHA6XC9cL3Nway1zZG1hd2FyZC50ZXN0XC9sb2dpbiIsInJvdXRlIjoibG9naW4ifSwiX2ZsYXNoIjp7Im9sZCI6W10sIm5ldyI6W119fQ==',1784309158),('z5oZdgm8JkP6zpaWg6AmuoRHPcEOuv8tBOYV0AvZ',NULL,'127.0.0.1','curl/8.17.0','eyJfdG9rZW4iOiJ4a0JZQW41dkozOGJyYkk3Z00zcVJxRE9CVmQ1VUpYN2FnOWdjelBFIiwiX3ByZXZpb3VzIjp7InVybCI6Imh0dHA6XC9cL3Nway1zZG1hd2FyZC50ZXN0Iiwicm91dGUiOiJsYW5kaW5nIn0sIl9mbGFzaCI6eyJvbGQiOltdLCJuZXciOltdfX0=',1784351361),('z6LYGycwUqZa0dQnvDz2YfXHSehbcOZpIP4IegXd',NULL,'127.0.0.1','curl/8.17.0','eyJfdG9rZW4iOiJpbm9aTnY2RGpoOWxtekFmRmV0ZnFLZXpvNUFRaDBRSFpIdE1CM2lEIiwiX3ByZXZpb3VzIjp7InVybCI6Imh0dHA6XC9cLzEyNy4wLjAuMTo4MDAwIiwicm91dGUiOiJsYW5kaW5nIn0sIl9mbGFzaCI6eyJvbGQiOltdLCJuZXciOltdfX0=',1784306661);
/*!40000 ALTER TABLE `sessions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `siswas`
--

DROP TABLE IF EXISTS `siswas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `siswas` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint unsigned DEFAULT NULL,
  `nisn` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nama` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `kelas_id` bigint unsigned DEFAULT NULL,
  `foto` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tempat_lahir` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tanggal_lahir` date DEFAULT NULL,
  `jenis_kelamin` enum('L','P') COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `alamat` text COLLATE utf8mb4_unicode_ci,
  `no_hp_ortu` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `waktu_registrasi_pertama` timestamp NULL DEFAULT NULL,
  `periode_terakhir_ikuti` bigint unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `siswas_nisn_unique` (`nisn`),
  KEY `siswas_user_id_foreign` (`user_id`),
  KEY `siswas_kelas_id_foreign` (`kelas_id`),
  KEY `siswas_periode_terakhir_ikuti_foreign` (`periode_terakhir_ikuti`),
  CONSTRAINT `siswas_kelas_id_foreign` FOREIGN KEY (`kelas_id`) REFERENCES `kelas` (`id`) ON DELETE SET NULL,
  CONSTRAINT `siswas_periode_terakhir_ikuti_foreign` FOREIGN KEY (`periode_terakhir_ikuti`) REFERENCES `periodes` (`id`) ON DELETE SET NULL,
  CONSTRAINT `siswas_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `siswas`
--

LOCK TABLES `siswas` WRITE;
/*!40000 ALTER TABLE `siswas` DISABLE KEYS */;
INSERT INTO `siswas` VALUES (1,3,'2024001','Budi Santoso',5,NULL,NULL,NULL,NULL,NULL,NULL,'2026-07-17 07:14:49',1,'2026-07-17 07:14:48','2026-07-17 07:14:49'),(2,4,'2024002','Siti Aminah',6,NULL,NULL,NULL,NULL,NULL,NULL,'2026-07-17 07:14:49',1,'2026-07-17 07:14:49','2026-07-17 07:14:49'),(3,5,'2024003','Rizki Pratama',6,NULL,NULL,NULL,NULL,NULL,NULL,'2026-07-17 07:14:50',1,'2026-07-17 07:14:49','2026-07-17 07:53:47'),(4,6,'2024004','Nadia Lestari',5,NULL,NULL,NULL,NULL,NULL,NULL,'2026-07-17 07:14:50',1,'2026-07-17 07:14:50','2026-07-17 07:14:50'),(5,7,'2024005','Fajar Nugroho',6,NULL,NULL,NULL,NULL,NULL,NULL,'2026-07-17 07:14:51',1,'2026-07-17 07:14:50','2026-07-17 07:14:51'),(6,8,'0234540','ARIF HIDAYAT',5,NULL,'Lampung Tengah','2015-01-14','L','metro','0800000000000000','2026-07-17 07:27:17',1,'2026-07-17 07:26:27','2026-07-17 07:27:17');
/*!40000 ALTER TABLE `siswas` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `users` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nisn` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `role` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'siswa',
  `photo_path` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`),
  UNIQUE KEY `users_nisn_unique` (`nisn`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'Panitia SDM Award',NULL,'panitia@sdmaward.test',NULL,'$2y$12$1xTPRF4KRx/8QXSjdWcRoOirDo01ipaT2XBtv1Mcqis7UH8TTRgEO',NULL,'2026-07-17 07:14:48','2026-07-17 07:14:48','panitia',NULL),(2,'Waka Kesiswaan',NULL,'waka@sdmaward.test',NULL,'$2y$12$kdAMRw9Xeln5Sd5lVDGBeuVmtmDbDy0Ejo5WST5mDykv4oHMm0lz6',NULL,'2026-07-17 07:14:48','2026-07-17 07:14:48','wakasiswa',NULL),(3,'Budi Santoso','2024001','2024001@sdmaward.test',NULL,'$2y$12$a97fnG90Wod/1DdeFzm51OygV0zNOzHo9GBrAzyM4T9MIOMgYzldK',NULL,'2026-07-17 07:14:49','2026-07-17 07:14:49','siswa',NULL),(4,'Siti Aminah','2024002','2024002@sdmaward.test',NULL,'$2y$12$xckLYVTV7zqYCcpzzRIj3O7ZNUH3b437GQSIZlBgzV4XeFE527BVu',NULL,'2026-07-17 07:14:49','2026-07-17 07:14:49','siswa',NULL),(5,'Rizki Pratama','2024003','2024003@sdmaward.test',NULL,'$2y$12$PFWyJ9bajqCKUQqr8LTtB.VKfqQNyXhsKAjxoD/8dP6RgSbJxcN7S',NULL,'2026-07-17 07:14:50','2026-07-17 07:14:50','siswa',NULL),(6,'Nadia Lestari','2024004','2024004@sdmaward.test',NULL,'$2y$12$j6MO.hKkKNS/P1ZOCBd8n.sv/V8MxZWNE/CWd056k4ImJNAeIk4IK',NULL,'2026-07-17 07:14:50','2026-07-17 07:14:50','siswa',NULL),(7,'Fajar Nugroho','2024005','2024005@sdmaward.test',NULL,'$2y$12$40VOFbwHKSInpkE34MOzT.eDPvj4k87e33RhKRt9qqmKbVy9Mg.fq',NULL,'2026-07-17 07:14:51','2026-07-17 07:14:51','siswa',NULL),(8,'ARIF HIDAYAT','0234540','siswa1784298436@sdmaward.local',NULL,'$2y$12$DjgZpCkWztZYS3uzfh7ny./VBsDOnu8MIOjSqFOdklsP6YCAkDzim',NULL,'2026-07-17 07:27:17','2026-07-17 07:27:17','siswa',NULL);
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

-- Dump completed on 2026-07-18 15:07:25
