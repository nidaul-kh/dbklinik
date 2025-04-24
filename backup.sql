-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               8.0.30 - MySQL Community Server - GPL
-- Server OS:                    Win64
-- HeidiSQL Version:             12.1.0.6537
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- Dumping database structure for dbklinik
CREATE DATABASE IF NOT EXISTS `dbklinik` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci */ /*!80016 DEFAULT ENCRYPTION='N' */;
USE `dbklinik`;

-- Dumping structure for table dbklinik.obat
CREATE TABLE IF NOT EXISTS `obat` (
  `id_obat` int NOT NULL AUTO_INCREMENT,
  `id_rekam` int DEFAULT NULL,
  `nama_obat` varchar(100) NOT NULL,
  `dosis` varchar(50) NOT NULL,
  `jumlah` int NOT NULL,
  PRIMARY KEY (`id_obat`),
  KEY `id_rekam` (`id_rekam`),
  CONSTRAINT `obat_ibfk_1` FOREIGN KEY (`id_rekam`) REFERENCES `rekam_medis` (`id_rekam`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Data exporting was unselected.

-- Dumping structure for table dbklinik.pasien
CREATE TABLE IF NOT EXISTS `pasien` (
  `no_norm` varchar(10) NOT NULL,
  `nama_pasien` varchar(100) NOT NULL,
  `jk` enum('L','P') NOT NULL,
  `no_hp` varchar(15) DEFAULT NULL,
  `tgl_lahir` date NOT NULL,
  `tempat_lahir` varchar(50) NOT NULL,
  PRIMARY KEY (`no_norm`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Data exporting was unselected.

-- Dumping structure for table dbklinik.pembayaran
CREATE TABLE IF NOT EXISTS `pembayaran` (
  `id_pembayaran` int NOT NULL AUTO_INCREMENT,
  `no_norm` varchar(10) DEFAULT NULL,
  `tanggal_pembayaran` date NOT NULL,
  `jumlah` decimal(10,2) NOT NULL,
  `metode_pembayaran` enum('Tunai','Kartu Kredit','Transfer','BPJS') NOT NULL,
  PRIMARY KEY (`id_pembayaran`),
  KEY `no_norm` (`no_norm`),
  CONSTRAINT `pembayaran_ibfk_1` FOREIGN KEY (`no_norm`) REFERENCES `pasien` (`no_norm`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Data exporting was unselected.

-- Dumping structure for table dbklinik.rekam_medis
CREATE TABLE IF NOT EXISTS `rekam_medis` (
  `id_rekam` int NOT NULL AUTO_INCREMENT,
  `no_norm` varchar(10) DEFAULT NULL,
  `tanggal_kunjungan` date NOT NULL,
  `diagnosis` text NOT NULL,
  `tindakan` text,
  `dokter` varchar(100) NOT NULL,
  PRIMARY KEY (`id_rekam`),
  KEY `no_norm` (`no_norm`),
  CONSTRAINT `rekam_medis_ibfk_1` FOREIGN KEY (`no_norm`) REFERENCES `pasien` (`no_norm`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Data exporting was unselected.

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
