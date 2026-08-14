/*M!999999\- enable the sandbox mode */ 
-- MariaDB dump 10.19-12.3.2-MariaDB, for Linux (x86_64)
--
-- Host: localhost    Database: qltaichinh
-- ------------------------------------------------------
-- Server version	12.3.2-MariaDB

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*M!100616 SET @OLD_NOTE_VERBOSITY=@@NOTE_VERBOSITY, NOTE_VERBOSITY=0 */;

--
-- Table structure for table `chung_tu_dien_tu`
--

DROP TABLE IF EXISTS `chung_tu_dien_tu`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `chung_tu_dien_tu` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `hoa_don_id` int(11) NOT NULL,
  `loai_chung_tu` varchar(50) DEFAULT NULL,
  `ngay_tai_len` datetime DEFAULT NULL,
  `duong_dan_anh` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `hoa_don_id` (`hoa_don_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `chung_tu_dien_tu`
--

SET @OLD_AUTOCOMMIT=@@AUTOCOMMIT, @@AUTOCOMMIT=0;
LOCK TABLES `chung_tu_dien_tu` WRITE;
/*!40000 ALTER TABLE `chung_tu_dien_tu` DISABLE KEYS */;
INSERT INTO `chung_tu_dien_tu` VALUES
(1,9,'Ảnh chụp màn hình chuyển khoản','2026-08-12 13:38:31','assets/uploads/1786516711_e6624c14c6b347ed1ea2.jpg'),
(2,8,'Ảnh chụp màn hình chuyển khoản','2026-08-12 13:54:57','assets/uploads/1786517697_e6624c14c6b347ed1ea2.jpg'),
(3,7,'Ảnh chụp màn hình chuyển khoản','2026-08-12 15:05:19','resource/assets/uploads/1786521919_74925e9e-f00a-42be-97c3-5bb72263402b.jpeg');
/*!40000 ALTER TABLE `chung_tu_dien_tu` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;
SET AUTOCOMMIT=@OLD_AUTOCOMMIT;

--
-- Table structure for table `dich_vu`
--

DROP TABLE IF EXISTS `dich_vu`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `dich_vu` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `ten_dich_vu` varchar(255) NOT NULL,
  `mo_ta` text DEFAULT NULL,
  `nha_cung_cap_id` bigint(20) NOT NULL,
  `nguoi_dung_id` bigint(20) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `dich_vu`
--

SET @OLD_AUTOCOMMIT=@@AUTOCOMMIT, @@AUTOCOMMIT=0;
LOCK TABLES `dich_vu` WRITE;
/*!40000 ALTER TABLE `dich_vu` DISABLE KEYS */;
INSERT INTO `dich_vu` VALUES
(2,'Internet','',11,1);
/*!40000 ALTER TABLE `dich_vu` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;
SET AUTOCOMMIT=@OLD_AUTOCOMMIT;

--
-- Table structure for table `hoa_don`
--

DROP TABLE IF EXISTS `hoa_don`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `hoa_don` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `loai_hoa_don` tinyint(4) DEFAULT NULL,
  `ky_cuoc` varchar(20) DEFAULT NULL,
  `so_tien_can_dong` float DEFAULT NULL,
  `chi_so_tieu_thu` varchar(100) DEFAULT NULL,
  `ngay_han_chot` datetime DEFAULT NULL,
  `trang_thai` varchar(50) DEFAULT NULL,
  `ghi_chu_nen_tang` varchar(100) DEFAULT NULL,
  `ngay_tao` datetime DEFAULT NULL,
  `ngay_cap_nhat` datetime DEFAULT NULL,
  `nguoi_dung_id` bigint(20) NOT NULL DEFAULT 0,
  `nha_cung_cap_id` bigint(20) NOT NULL DEFAULT 0,
  `dich_vu_id` bigint(20) DEFAULT 0,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `hoa_don`
--

SET @OLD_AUTOCOMMIT=@@AUTOCOMMIT, @@AUTOCOMMIT=0;
LOCK TABLES `hoa_don` WRITE;
/*!40000 ALTER TABLE `hoa_don` DISABLE KEYS */;
INSERT INTO `hoa_don` VALUES
(4,0,'05/2026',200000,'','2026-07-04 00:00:00','1','Momo','2026-07-04 08:15:18','2026-07-04 08:24:51',0,1,0),
(5,0,'05/2026',180000,'','2026-07-07 00:00:00','1','Tiền mặt','2026-07-04 08:32:55','2026-07-04 08:33:40',0,3,0),
(7,0,'05/2026',190000,'','2026-07-13 00:00:00','1','BIDV SmartBanking','2026-08-12 13:06:25','2026-08-12 15:05:19',1,11,2),
(8,0,'06/2026',190000,'','2026-07-12 00:00:00','1','','2026-08-12 13:13:29','2026-08-12 13:55:06',1,11,2),
(10,0,'08/2026',190000,'','2026-08-12 00:00:00','0',NULL,'2026-08-12 14:27:58','2026-08-12 14:27:58',1,11,2);
/*!40000 ALTER TABLE `hoa_don` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;
SET AUTOCOMMIT=@OLD_AUTOCOMMIT;

--
-- Table structure for table `nguoi_dung`
--

DROP TABLE IF EXISTS `nguoi_dung`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `nguoi_dung` (
  `ma_nd` int(11) NOT NULL AUTO_INCREMENT,
  `ten_dang_nhap` varchar(50) NOT NULL,
  `mat_khau` varchar(255) NOT NULL,
  `ho_ten` varchar(100) NOT NULL,
  `email` varchar(100) DEFAULT NULL,
  `vai_tro` int(11) DEFAULT 0,
  `lan_dang_nhap_cuoi` datetime DEFAULT NULL,
  PRIMARY KEY (`ma_nd`),
  UNIQUE KEY `ten_dang_nhap` (`ten_dang_nhap`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `nguoi_dung`
--

SET @OLD_AUTOCOMMIT=@@AUTOCOMMIT, @@AUTOCOMMIT=0;
LOCK TABLES `nguoi_dung` WRITE;
/*!40000 ALTER TABLE `nguoi_dung` DISABLE KEYS */;
INSERT INTO `nguoi_dung` VALUES
(1,'admin','123456','Quản trị viên','admin@example.com',1,'2026-08-12 15:12:13'),
(2,'trung','123','Trung','codehappyness@gmail.com',0,'2026-08-12 15:11:18');
/*!40000 ALTER TABLE `nguoi_dung` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;
SET AUTOCOMMIT=@OLD_AUTOCOMMIT;

--
-- Table structure for table `nha_cung_cap`
--

DROP TABLE IF EXISTS `nha_cung_cap`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `nha_cung_cap` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `ten` varchar(155) DEFAULT NULL,
  `dia_chi` varchar(255) DEFAULT NULL,
  `so_dien_thoai` varchar(100) DEFAULT NULL,
  `nguoi_dung_id` bigint(20) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `nha_cung_cap`
--

SET @OLD_AUTOCOMMIT=@@AUTOCOMMIT, @@AUTOCOMMIT=0;
LOCK TABLES `nha_cung_cap` WRITE;
/*!40000 ALTER TABLE `nha_cung_cap` DISABLE KEYS */;
INSERT INTO `nha_cung_cap` VALUES
(1,'Test','Test Address','123456',0),
(3,'Viettel','Cần Thơ','0099999',0),
(5,'FPT','Cần Thơ','0999999999',0),
(7,'Điện lực miền nam','Cần Thơ','0000989',0),
(11,'VNPT','Cần Thơ','079',1),
(12,'Điện lực miền nam','Cần Thơ','11',1),
(13,'Viettel','Cần Thơ','1800',1);
/*!40000 ALTER TABLE `nha_cung_cap` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;
SET AUTOCOMMIT=@OLD_AUTOCOMMIT;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*M!100616 SET NOTE_VERBOSITY=@OLD_NOTE_VERBOSITY */;

-- Dump completed on 2026-08-14  8:12:31
