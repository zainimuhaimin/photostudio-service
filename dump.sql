-- MySQL dump 10.13  Distrib 9.3.0, for macos15.4 (arm64)
--
-- Host: localhost    Database: photostudio_service
-- ------------------------------------------------------
-- Server version	9.3.0

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
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `migrations` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `version` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `class` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `group` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `namespace` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `time` int NOT NULL,
  `batch` int unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=50 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migrations`
--

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` VALUES (41,'2025-06-09-071810','App\\Database\\Migrations\\TablePelanggan','default','App',1749536894,1),(42,'2025-06-09-072200','App\\Database\\Migrations\\UserAuthentication','default','App',1749536894,1),(43,'2025-06-09-072447','App\\Database\\Migrations\\Role','default','App',1749536894,1),(44,'2025-06-10-022147','App\\Database\\Migrations\\TabelJasa','default','App',1749536894,1),(45,'2025-06-10-022512','App\\Database\\Migrations\\TableAlat','default','App',1749536894,1),(46,'2025-06-10-022949','App\\Database\\Migrations\\TablePenyewaanAlat','default','App',1749536894,1),(47,'2025-06-10-023439','App\\Database\\Migrations\\TablePemensananJasa','default','App',1749536894,1),(48,'2025-06-10-023621','App\\Database\\Migrations\\TablePembayaran','default','App',1749536894,1),(49,'2025-06-10-084238','App\\Database\\Migrations\\TransactionTemp','default','App',1749545093,2);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `role`
--

DROP TABLE IF EXISTS `role`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `role` (
  `id_role` int unsigned NOT NULL AUTO_INCREMENT,
  `value` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  PRIMARY KEY (`id_role`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `role`
--

LOCK TABLES `role` WRITE;
/*!40000 ALTER TABLE `role` DISABLE KEYS */;
INSERT INTO `role` VALUES (1,'ADMIN'),(2,'USER');
/*!40000 ALTER TABLE `role` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `table_alat`
--

DROP TABLE IF EXISTS `table_alat`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `table_alat` (
  `id_alat` int unsigned NOT NULL AUTO_INCREMENT,
  `nama_alat` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `harga_alat` int NOT NULL,
  `deskripsi` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `created_by` varchar(100) COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'SYSTEM',
  `updated_at` datetime DEFAULT NULL,
  `updated_by` varchar(100) COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'SYSTEM',
  `is_deleted` int NOT NULL DEFAULT '0',
  `image_path` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  PRIMARY KEY (`id_alat`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `table_alat`
--

LOCK TABLES `table_alat` WRITE;
/*!40000 ALTER TABLE `table_alat` DISABLE KEYS */;
INSERT INTO `table_alat` VALUES (1,'Kipas Angin Ultraman Cosmos edited',10000,'segitu dah','2025-06-12 18:27:42','kadal','2025-06-14 04:43:35','kadal',0,'uploads/alat/alat_image_1749876215.jpg'),(2,'Hordeng Supreme Terang',50000000,'50 jt sejam','2025-06-12 18:28:49','kadal','2025-06-14 03:05:50','kadal',1,'uploads/alat/alat_image_1749752929.jpg'),(8,'Tupperware Emak',99000000,'sebiji segitu','2025-06-14 04:32:41','kadal','2025-06-14 04:44:00','kadal',0,'uploads/alat/alat_image_1749875561.jpg'),(9,'JOKO',900000,'JOKO','2025-06-14 08:51:32','kadal','2025-06-14 08:51:32','SYSTEM',0,'uploads/alat/alat_image_1749891092.jpg');
/*!40000 ALTER TABLE `table_alat` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `table_jasa`
--

DROP TABLE IF EXISTS `table_jasa`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `table_jasa` (
  `id_jasa` int unsigned NOT NULL AUTO_INCREMENT,
  `nama_jasa` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `harga_jasa` int NOT NULL,
  `deskripsi` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `created_by` varchar(100) COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'SYSTEM',
  `updated_by` varchar(100) COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'SYSTEM',
  `updated_at` datetime DEFAULT NULL,
  `is_deleted` int NOT NULL DEFAULT '0',
  PRIMARY KEY (`id_jasa`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `table_jasa`
--

LOCK TABLES `table_jasa` WRITE;
/*!40000 ALTER TABLE `table_jasa` DISABLE KEYS */;
INSERT INTO `table_jasa` VALUES (3,'Jasa 1',20000,'20 rebu sejam','2025-06-12 18:29:06','kadal','kadal','2025-06-14 04:58:16',1),(4,'Pasang Ban Mobil EDITED',10000,'segitu dah EDITED','2025-06-14 04:58:52','kadal','SYSTEM','2025-06-14 05:05:54',0),(5,'Pasang Ban Mobil EDITED',10000,'segitu dah EDITED','2025-06-14 05:04:05','kadal','SYSTEM','2025-06-14 05:04:05',1),(6,'Pasang Ban Mobil EDITED',20000,'segitu dah EDITED','2025-06-14 05:05:07','kadal','SYSTEM','2025-06-14 05:05:07',1),(7,'Tambal Ban Tank',90000000,'begitu dah','2025-06-14 07:29:27','kadal','SYSTEM','2025-06-14 07:29:27',0);
/*!40000 ALTER TABLE `table_jasa` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `table_pelanggan`
--

DROP TABLE IF EXISTS `table_pelanggan`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `table_pelanggan` (
  `id_pelanggan` int unsigned NOT NULL AUTO_INCREMENT,
  `id_user` int NOT NULL,
  `nama` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `alamat` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `no_telp` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `email` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `created_at` timestamp NOT NULL,
  `created_by` varchar(100) COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'SYSTEM',
  `updated_by` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `is_deleted` int NOT NULL DEFAULT '0',
  PRIMARY KEY (`id_pelanggan`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `table_pelanggan`
--

LOCK TABLES `table_pelanggan` WRITE;
/*!40000 ALTER TABLE `table_pelanggan` DISABLE KEYS */;
INSERT INTO `table_pelanggan` VALUES (2,2,'Panjul 2 EDITED','alamat pelanggan 1 edited lagi','081387999999','pelanggan1Panjuledited@mail.com','2025-06-09 23:41:21','kadal','2','2025-06-14 10:01:22',0),(3,3,'pelanggan2','bekasi','0812312412222','zenmuhaimin7@gmail.com','2025-06-11 03:44:57','kadal','kadal','2025-06-14 02:40:10',0),(4,4,'heleh','alksdjaslkdj','021839487','mail2@mail.com','2025-06-14 02:53:53','kadal','4','2025-06-14 09:54:23',0),(5,5,'enjen1','alksdjalsdalsd','98324203432','mail@mail.id','2025-06-14 02:58:54','kadal',NULL,'2025-06-14 09:58:54',0),(6,6,'Nama Regis','alamat','0824923423','regis@mail.com','2025-06-14 03:04:02','SYSTEM',NULL,'2025-06-14 10:04:02',0);
/*!40000 ALTER TABLE `table_pelanggan` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `table_pembayaran`
--

DROP TABLE IF EXISTS `table_pembayaran`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `table_pembayaran` (
  `id_pembayaran` int unsigned NOT NULL AUTO_INCREMENT,
  `id_penyewaan` int DEFAULT NULL,
  `id_pemensanan` int DEFAULT NULL,
  `metode_pembayaran` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `tanggal_pembayaran` date DEFAULT NULL,
  `bukti_pembayaran` blob,
  `status_pembayaran` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `created_by` varchar(100) COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'SYSTEM',
  `updated_at` datetime DEFAULT NULL,
  `updated_by` varchar(100) COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'SYSTEM',
  `is_deleted` int NOT NULL DEFAULT '0',
  `transaction_id` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  PRIMARY KEY (`id_pembayaran`)
) ENGINE=InnoDB AUTO_INCREMENT=33 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `table_pembayaran`
--

LOCK TABLES `table_pembayaran` WRITE;
/*!40000 ALTER TABLE `table_pembayaran` DISABLE KEYS */;
INSERT INTO `table_pembayaran` VALUES (32,28,NULL,'TRANSFER','2025-06-14',_binary 'uploads/bukti_tf/bukti_tf_image_1749896785.jpg','VALID','2025-06-14 10:26:15','pelanggan2','2025-06-14 11:21:26','kadal',0,'TRX000000001');
/*!40000 ALTER TABLE `table_pembayaran` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `table_pemensanan_jasa`
--

DROP TABLE IF EXISTS `table_pemensanan_jasa`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `table_pemensanan_jasa` (
  `id_pemensanan` int unsigned NOT NULL AUTO_INCREMENT,
  `id_jasa` int NOT NULL,
  `id_pelanggan` int NOT NULL,
  `tanggal` datetime NOT NULL,
  `total` int NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `created_by` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT 'SYSTEM',
  `updated_at` datetime DEFAULT NULL,
  `updated_by` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT 'SYSTEM',
  `is_deleted` int NOT NULL DEFAULT '0',
  PRIMARY KEY (`id_pemensanan`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `table_pemensanan_jasa`
--

LOCK TABLES `table_pemensanan_jasa` WRITE;
/*!40000 ALTER TABLE `table_pemensanan_jasa` DISABLE KEYS */;
/*!40000 ALTER TABLE `table_pemensanan_jasa` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `table_penyewaan_alat`
--

DROP TABLE IF EXISTS `table_penyewaan_alat`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `table_penyewaan_alat` (
  `id_penyewaan` int unsigned NOT NULL AUTO_INCREMENT,
  `id_alat` int NOT NULL,
  `id_pelanggan` int NOT NULL,
  `tanggal` datetime NOT NULL,
  `total` int NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `created_by` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  `updated_by` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `is_deleted` int NOT NULL DEFAULT '0',
  PRIMARY KEY (`id_penyewaan`)
) ENGINE=InnoDB AUTO_INCREMENT=29 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `table_penyewaan_alat`
--

LOCK TABLES `table_penyewaan_alat` WRITE;
/*!40000 ALTER TABLE `table_penyewaan_alat` DISABLE KEYS */;
INSERT INTO `table_penyewaan_alat` VALUES (21,1,2,'2025-06-14 09:00:00',120000,'2025-06-12 14:01:58','pelanggan1','2025-06-12 14:01:58','',0),(22,8,2,'2025-06-18 09:00:00',99000000,'2025-06-14 05:29:33','pelanggan1','2025-06-14 08:03:03','kadal',0),(23,8,2,'2025-06-15 10:00:00',99000000,'2025-06-14 05:38:17','pelanggan1','2025-06-14 07:20:45','pelanggan1',0),(24,1,2,'2025-06-20 12:00:00',10000,'2025-06-14 08:42:26','pelanggan1','2025-06-14 08:42:26','',0),(25,8,2,'2025-06-25 12:00:00',99000000,'2025-06-14 08:44:03','pelanggan1','2025-06-14 08:44:03','',0),(26,1,2,'2025-06-21 12:00:00',10000,'2025-06-14 08:45:08','pelanggan1','2025-06-14 08:45:08','',0),(27,9,2,'2025-06-18 12:00:00',900000,'2025-06-14 08:55:40','pelanggan1','2025-06-14 08:55:40','',0),(28,1,3,'2025-06-15 12:00:00',10000,'2025-06-14 10:26:15','pelanggan2','2025-06-14 10:26:15','',0);
/*!40000 ALTER TABLE `table_penyewaan_alat` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user_authentication`
--

DROP TABLE IF EXISTS `user_authentication`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `user_authentication` (
  `id_user` int unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `password` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `id_role` int NOT NULL,
  `created_at` datetime NOT NULL,
  `created_by` varchar(100) COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'SYSTEM',
  `updated_at` datetime DEFAULT NULL,
  `updated_by` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `is_deleted` int NOT NULL DEFAULT '0',
  PRIMARY KEY (`id_user`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user_authentication`
--

LOCK TABLES `user_authentication` WRITE;
/*!40000 ALTER TABLE `user_authentication` DISABLE KEYS */;
INSERT INTO `user_authentication` VALUES (1,'kadal','$2y$12$Cjt3J.ABYfrsCUhjm7qH9OgvbzcoKzPm35DxXl2ywTXcOqzBO8z1m',1,'2025-06-10 06:33:44','SYSTEM','2025-06-10 06:33:44',NULL,0),(2,'panjul2','$2y$12$.xfixeQ0qjb16idCNZopM.8wBRPkxQxK6wJ59IrpvN.ySnCd37LpO',2,'2025-06-14 09:53:53','kadal','2025-06-14 10:01:22','panjul2',0),(3,'pelanggan2','$2y$12$yl8BSD9k63hm4xN5/Bf13.39pnP/N3yiV6VSN8tTlxZubAwFJNhDO',2,'2025-06-11 10:44:57','kadal','2025-06-14 02:40:10','kadal',0),(5,'enjen1','$2y$12$DdroFPvkus3HLcTi3PvEUu.solLpNKBVyXD6JEz6iSK5s81OIZePG',2,'2025-06-14 09:58:54','kadal','2025-06-14 09:58:54',NULL,0),(6,'regis1','$2y$12$wrs9Wi9vdknPa0z5iK2qne3TPP/Fgv6FyQdefNjOmUlmPlD.KWUTy',2,'2025-06-14 10:04:02','SYSTEM','2025-06-14 10:04:02',NULL,0),(7,'kadal2','$2y$12$UWayJf1JkTCHG8U7DOWuV.UMBP8kjm90Ha7Tdp4uzTEQ7jScw31ay',1,'2025-06-14 10:16:11','kadal','2025-06-14 10:25:45','kadal2',0);
/*!40000 ALTER TABLE `user_authentication` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2025-06-14 18:23:41
