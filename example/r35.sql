-- MariaDB dump 10.19  Distrib 10.4.28-MariaDB, for Win64 (AMD64)
--
-- Host: localhost    Database: r35
-- ------------------------------------------------------
-- Server version	10.4.28-MariaDB

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `admin_login`
--

DROP TABLE IF EXISTS `admin_login`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `admin_login` (
  `UID` varchar(10) NOT NULL,
  `Name` varchar(255) NOT NULL,
  `Passwd` varchar(255) NOT NULL,
  PRIMARY KEY (`UID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `admin_login`
--

LOCK TABLES `admin_login` WRITE;
/*!40000 ALTER TABLE `admin_login` DISABLE KEYS */;
INSERT INTO `admin_login` VALUES ('admin1','Dipti Gupta','$2y$10$lBMwO7FRzF.5rozdKellfuYksf2qFpawt6ctxrNsVdBsK4wD3sgza'),('admin2','Koyel Choudhary','$2y$10$ySzr3.Y9N5KBNF0Fku4xre2CXCoXTu/NgJgQKzRN1lrrYXvtiynCi'),('admin3','Aryan Gupta','$2y$10$r/7aJnapi/RQKbHmv8d9Z.6k6BcSMWEtGcVyLUvu.oXucG335AWj2'),('admin4','Jayashri Mishra','$2y$10$AKusfp3NgSGSTq/Ha3EN0uV0AI5LnlPDCkT/CacwPdnlWENid783y');
/*!40000 ALTER TABLE `admin_login` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `leave_record`
--

DROP TABLE IF EXISTS `leave_record`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `leave_record` (
  `SN` int(50) NOT NULL AUTO_INCREMENT,
  `UID` varchar(10) NOT NULL,
  `Type` varchar(5) NOT NULL,
  `From` date NOT NULL,
  `To` date NOT NULL,
  `Days` int(3) NOT NULL,
  `Status` varchar(15) NOT NULL DEFAULT 'Pending',
  `Admin` varchar(10) DEFAULT NULL,
  PRIMARY KEY (`SN`),
  KEY `staff_rec_fk` (`UID`),
  KEY `admin_app_fk` (`Admin`),
  CONSTRAINT `admin_app_fk` FOREIGN KEY (`Admin`) REFERENCES `admin_login` (`UID`) ON DELETE SET NULL ON UPDATE CASCADE,
  CONSTRAINT `staff_rec_fk` FOREIGN KEY (`UID`) REFERENCES `staff_login` (`UID`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `status_ck` CHECK (`Status` in ('Pending','Approved','Denied'))
) ENGINE=InnoDB AUTO_INCREMENT=27 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `leave_record`
--

LOCK TABLES `leave_record` WRITE;
/*!40000 ALTER TABLE `leave_record` DISABLE KEYS */;
INSERT INTO `leave_record` VALUES (2,'staff3','LWP','2023-09-21','2023-09-22',2,'Approved','admin4'),(4,'staff2','OP','2023-09-13','2023-09-15',3,'Approved','admin4'),(6,'staff1','SL','2023-09-15','2023-09-18',3,'Denied','admin1'),(8,'staff4','CL','2023-10-03','2023-10-06',4,'Denied','admin4'),(9,'staff1','CL','2023-09-15','2023-09-18',3,'Approved','admin4'),(10,'staff2','CL','2023-09-18','2023-09-19',2,'Denied','admin2'),(11,'staff4','LWP','2023-09-18','2023-09-20',3,'Approved','admin4'),(12,'staff4','SL','2023-09-21','2023-09-25',4,'Denied','admin3'),(16,'staff3','EL','2023-09-25','2023-09-25',1,'Approved','admin4'),(19,'staff4','CL','2023-10-30','2023-10-31',2,'Approved','admin1'),(20,'staff2','SL','2023-09-25','2023-09-30',5,'Approved','admin1'),(21,'staff1','LWP','2023-09-29','2023-09-29',1,'Approved','admin1');
/*!40000 ALTER TABLE `leave_record` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `staff_leave`
--

DROP TABLE IF EXISTS `staff_leave`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `staff_leave` (
  `UID` varchar(10) NOT NULL,
  `EL` int(3) NOT NULL,
  `CL` int(2) NOT NULL,
  `SL` int(4) NOT NULL,
  PRIMARY KEY (`UID`),
  CONSTRAINT `staff_id_fk` FOREIGN KEY (`UID`) REFERENCES `staff_login` (`UID`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `staff_leave`
--

LOCK TABLES `staff_leave` WRITE;
/*!40000 ALTER TABLE `staff_leave` DISABLE KEYS */;
INSERT INTO `staff_leave` VALUES ('staff1',5,9,30),('staff2',5,12,25),('staff3',4,12,30),('staff4',5,10,30);
/*!40000 ALTER TABLE `staff_leave` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `staff_login`
--

DROP TABLE IF EXISTS `staff_login`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `staff_login` (
  `UID` varchar(10) NOT NULL,
  `Name` varchar(255) NOT NULL,
  `Passwd` varchar(255) NOT NULL,
  PRIMARY KEY (`UID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `staff_login`
--

LOCK TABLES `staff_login` WRITE;
/*!40000 ALTER TABLE `staff_login` DISABLE KEYS */;
INSERT INTO `staff_login` VALUES ('staff1','Pratik Das','$2y$10$oVeaN2Ek6WugGp4oyOKcmOALQl0U57Xe/b4A5LNhIZxYiwEHPZP3u'),('staff2','Manjusha Choudhary','$2y$10$Ca28Vet489B8a6SOXn5fuel/SHynVQ4fiAjiSHlz1GFHsIkpHBV56'),('staff3','Samir Das','$2y$10$O.f1qxneUeoOrglsyDb96ulAaShyKTexupaO8eiaImhHzb3zr/HQS'),('staff4','Noyon Ghosh','$2y$10$KGEmNHwxdF.SxIZ9LMcDCe9NmzJsLIdxMcl0OM8xdrHd4LQC702rG');
/*!40000 ALTER TABLE `staff_login` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2023-11-09 12:55:13
