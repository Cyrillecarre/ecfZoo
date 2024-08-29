-- MySQL dump 10.13  Distrib 9.0.1, for macos14.4 (arm64)
--
-- Host: localhost    Database: ecfZoo
-- ------------------------------------------------------
-- Server version	8.3.0

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
-- Table structure for table `admin`
--

DROP TABLE IF EXISTS `admin`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `admin` (
  `id` int NOT NULL AUTO_INCREMENT,
  `email` varchar(180) COLLATE utf8mb4_unicode_ci NOT NULL,
  `roles` json NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_IDENTIFIER_EMAIL` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `admin`
--

LOCK TABLES `admin` WRITE;
/*!40000 ALTER TABLE `admin` DISABLE KEYS */;
INSERT INTO `admin` VALUES (2,'cyrille@gmail.com','[\"ROLE_ADMIN\"]','$2y$13$LyBK3AjQ4MSt4NmpeEZOPOptTW3qt0VJUKLDrqNGtS3bsK7imMw7i');
/*!40000 ALTER TABLE `admin` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `animal`
--

DROP TABLE IF EXISTS `animal`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `animal` (
  `id` int NOT NULL AUTO_INCREMENT,
  `area_id` int NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `race` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_6AAB231FBD0F409C` (`area_id`),
  CONSTRAINT `FK_6AAB231FBD0F409C` FOREIGN KEY (`area_id`) REFERENCES `area` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=38 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `animal`
--

LOCK TABLES `animal` WRITE;
/*!40000 ALTER TABLE `animal` DISABLE KEYS */;
INSERT INTO `animal` VALUES (2,7,'Tagada','Gorille'),(3,7,'Chocolat','Gorille'),(4,7,'Réglisse','Gorille'),(5,8,'Dumbo','Elephant'),(6,8,'Moka','Elephant'),(7,8,'Grisouille','Elephant'),(8,9,'Caramel','Dromadaire'),(9,7,'Carambar','Jaguar'),(10,7,'Krema','Jaguar'),(11,7,'Haribo','Jaguar'),(12,7,'Banana','Singe'),(13,7,'Fruiti','Singe'),(14,7,'King kong','Singe'),(15,7,'Oleron','Tigre'),(16,7,'Tigrou','Tigre'),(17,7,'Ugo','Tigre'),(18,8,'Gigi','Girafe'),(19,8,'Celeste','Girafe'),(20,8,'Ambre','Girafe'),(21,8,'Caillou','Lion'),(22,8,'Simba','Lion'),(23,8,'King','Lion'),(24,8,'Pijama','Zebre'),(25,8,'Blanchette','Zebre'),(26,8,'Diabolo','Zebre'),(27,9,'Domino','Dromadaire'),(28,9,'Grenasse','Dromadaire'),(29,9,'Luna','Fennec'),(30,9,'Sable','Fennec'),(31,9,'Miel','Fennec'),(32,9,'Carotte','Lezard'),(33,9,'Macaron','Lezard'),(34,9,'Hari','Lezard'),(35,9,'Kipik','Scorpion'),(36,9,'Syphon','Scorpion'),(37,9,'Braise','Scorpion');
/*!40000 ALTER TABLE `animal` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `area`
--

DROP TABLE IF EXISTS `area`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `area` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `comment` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `image_path` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `area`
--

LOCK TABLES `area` WRITE;
/*!40000 ALTER TABLE `area` DISABLE KEYS */;
INSERT INTO `area` VALUES (7,'Tropical','L\'habitat tropical inclut une végétation dense, climat contrôlé, abris en hauteur, sources d\'eau pour l\'humidité et baignade, et des structures d\'enrichissement comme des ponts de corde pour encourager l\'exploration et l\'activité des animaux.',NULL,NULL),(8,'Savane','L\'habitat de la savane comprend de vastes étendues herbeuses, des abris naturels, des points d\'eau pour boire et se baigner, un sol sableux, et des enrichissements comme des rochers et branches pour encourager les comportements naturels des animaux.',NULL,NULL),(9,'Desert','L\'habitat désertique recrée un climat chaud et sec avec du sable, des rochers, et des plantes résistantes. Des abris ombragés et rares points d\'eau sont disponibles. L\'enrichissement inclut rochers, tunnels de sable, et objets naturels pour l\'exploration.',NULL,NULL);
/*!40000 ALTER TABLE `area` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `doctrine_migration_versions`
--

DROP TABLE IF EXISTS `doctrine_migration_versions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `doctrine_migration_versions` (
  `version` varchar(191) COLLATE utf8mb3_unicode_ci NOT NULL,
  `executed_at` datetime DEFAULT NULL,
  `execution_time` int DEFAULT NULL,
  PRIMARY KEY (`version`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `doctrine_migration_versions`
--

LOCK TABLES `doctrine_migration_versions` WRITE;
/*!40000 ALTER TABLE `doctrine_migration_versions` DISABLE KEYS */;
INSERT INTO `doctrine_migration_versions` VALUES ('DoctrineMigrations\\Version20240820114245','2024-08-20 11:49:32',10),('DoctrineMigrations\\Version20240820115712','2024-08-20 11:57:24',51),('DoctrineMigrations\\Version20240820131318','2024-08-20 13:13:27',45),('DoctrineMigrations\\Version20240820155937','2024-08-20 15:59:46',46),('DoctrineMigrations\\Version20240821154603','2024-08-21 15:46:12',37),('DoctrineMigrations\\Version20240822084515','2024-08-22 08:45:23',47),('DoctrineMigrations\\Version20240822093647','2024-08-28 14:22:25',26),('DoctrineMigrations\\Version20240828141700','2024-08-28 15:16:21',3);
/*!40000 ALTER TABLE `doctrine_migration_versions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `employe`
--

DROP TABLE IF EXISTS `employe`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `employe` (
  `id` int NOT NULL AUTO_INCREMENT,
  `email` varchar(180) COLLATE utf8mb4_unicode_ci NOT NULL,
  `roles` json NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_IDENTIFIER_EMAIL` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `employe`
--

LOCK TABLES `employe` WRITE;
/*!40000 ALTER TABLE `employe` DISABLE KEYS */;
INSERT INTO `employe` VALUES (1,'lowen@gmail.com','[\"ROLE_EMPLOYE\"]','$2y$13$uOiH2e/f9Ka/ohgTG9MGa.VsE52MpzPd1Li1gdnOJKWNitQObfYyK');
/*!40000 ALTER TABLE `employe` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `food`
--

DROP TABLE IF EXISTS `food`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `food` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `quantity` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=61 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `food`
--

LOCK TABLES `food` WRITE;
/*!40000 ALTER TABLE `food` DISABLE KEYS */;
INSERT INTO `food` VALUES (1,'viande',100),(2,'fruit',50),(3,'fruit',50),(4,'legume',150),(5,'fruit',200),(6,'legume',1000),(7,'foin',2000),(8,'fruit',1000),(9,'foin',2000),(10,'fruit',2000),(11,'legume',500),(12,'fruit',200),(13,'foin',2000),(14,'fruit',500),(15,'viande',100),(16,'fruit',50),(17,'fruit',1000),(18,'foin',100),(19,'fruit',200),(20,'fruit',50),(21,'legume',0),(22,'legume',400),(23,'fruit',500),(24,'legume',500),(25,'fruit',600),(26,'foin',1000),(27,'viande',300),(28,'viande',600),(29,'fruit',200),(30,'viande',1000),(31,'viande',700),(32,'viande',800),(33,'foin',1000),(34,'foin',600),(35,'graine',100),(36,'viande',50),(37,'viande',190),(38,'insecte',200),(39,'insecte',200),(40,'graine',100),(41,'graine',100),(42,'legume',500),(43,'foin',1000),(44,'viande',500),(45,'viande',1000),(46,'viande',300),(47,'fruit',200),(48,'viande',700),(49,'legume',1000),(50,'foin',2000),(51,'fruit',2000),(52,'legume',500),(53,'fruit',50),(54,'foin',2000),(55,'foin',1000),(56,'foin',600),(57,'graine',100),(58,'viande',50),(59,'viande',190),(60,'insecte',50);
/*!40000 ALTER TABLE `food` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `messenger_messages`
--

DROP TABLE IF EXISTS `messenger_messages`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `messenger_messages` (
  `id` bigint NOT NULL AUTO_INCREMENT,
  `body` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `headers` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue_name` varchar(190) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` datetime NOT NULL COMMENT '(DC2Type:datetime_immutable)',
  `available_at` datetime NOT NULL COMMENT '(DC2Type:datetime_immutable)',
  `delivered_at` datetime DEFAULT NULL COMMENT '(DC2Type:datetime_immutable)',
  PRIMARY KEY (`id`),
  KEY `IDX_75EA56E0FB7336F0` (`queue_name`),
  KEY `IDX_75EA56E0E3BD61CE` (`available_at`),
  KEY `IDX_75EA56E016BA31DB` (`delivered_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `messenger_messages`
--

LOCK TABLES `messenger_messages` WRITE;
/*!40000 ALTER TABLE `messenger_messages` DISABLE KEYS */;
/*!40000 ALTER TABLE `messenger_messages` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `monitoring`
--

DROP TABLE IF EXISTS `monitoring`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `monitoring` (
  `id` int NOT NULL AUTO_INCREMENT,
  `medicine` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `date` datetime NOT NULL,
  `state` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `report` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `comment` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `recommandation_veterinary_id` int DEFAULT NULL,
  `animal_id` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_BA4F975DABCC2E73` (`recommandation_veterinary_id`),
  KEY `IDX_BA4F975D8E962C16` (`animal_id`),
  CONSTRAINT `FK_BA4F975D8E962C16` FOREIGN KEY (`animal_id`) REFERENCES `animal` (`id`),
  CONSTRAINT `FK_BA4F975DABCC2E73` FOREIGN KEY (`recommandation_veterinary_id`) REFERENCES `recommandation_veterinary` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=34 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `monitoring`
--

LOCK TABLES `monitoring` WRITE;
/*!40000 ALTER TABLE `monitoring` DISABLE KEYS */;
INSERT INTO `monitoring` VALUES (6,'aucun','2024-08-21 00:00:00','Bléssé',NULL,NULL,6,6),(7,'aucun','2024-08-22 14:01:00','Bonne santé',NULL,NULL,4,4),(9,'aucun','2024-08-23 13:21:00','Bonne santé',NULL,NULL,13,2),(10,'aucun','2024-08-23 13:23:00','Bonne santé',NULL,NULL,15,9),(11,'aucun','2024-08-23 13:23:00','Bonne santé',NULL,NULL,17,11),(12,'Aucun','2024-08-23 13:24:00','Bonne santé',NULL,NULL,19,15),(13,'Aucun','2024-08-23 13:24:00','Bléssé',NULL,'crème posé avec succès',16,10),(14,'Aucun','2024-08-23 13:25:00','Bonne santé',NULL,NULL,18,12),(15,'Aucun','2024-08-23 13:26:00','En convalescence',NULL,NULL,20,16),(16,'Aucun','2024-08-23 13:26:00','Bonne santé',NULL,NULL,21,17),(17,'Aucun','2024-08-23 13:27:00','Bonne santé',NULL,NULL,5,5),(18,'antibiotique','2024-08-23 13:27:00','Malade',NULL,'medicament ok',7,7),(19,'Aucun','2024-08-23 13:28:00','En convalescence',NULL,NULL,8,18),(20,'Aucun','2024-08-23 13:28:00','Bonne santé',NULL,NULL,9,8),(21,'Aucun','2024-08-23 13:29:00','Bonne santé',NULL,NULL,22,27),(22,'Aucun','2024-08-23 13:29:00','Bonne santé',NULL,NULL,23,28),(23,'Aucun','2024-08-23 13:29:00','Bonne santé',NULL,NULL,24,29),(24,'Aucun','2024-08-23 13:30:00','Bonne santé',NULL,NULL,25,30),(25,'Aucun','2024-08-23 13:30:00','Bonne santé',NULL,NULL,26,31),(26,'Aucun','2024-08-23 13:30:00','Bonne santé',NULL,NULL,27,32),(27,'Aucun','2024-08-23 13:31:00','Malade',NULL,NULL,28,33),(28,'Aucun','2024-08-23 14:22:00','Bonne santé',NULL,NULL,31,19),(29,'Aucun','2024-08-23 14:22:00','Bonne santé',NULL,NULL,32,20),(30,'Aucun','2024-08-23 14:23:00','En convalescence',NULL,NULL,33,21),(31,'Aucun','2024-08-23 14:23:00','Bonne santé',NULL,NULL,34,22),(32,'Aucun','2024-08-23 14:23:00','Bléssé',NULL,NULL,35,23),(33,'Aucun','2024-08-23 14:24:00','Bonne santé',NULL,NULL,36,24);
/*!40000 ALTER TABLE `monitoring` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `monitoring_food`
--

DROP TABLE IF EXISTS `monitoring_food`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `monitoring_food` (
  `monitoring_id` int NOT NULL,
  `food_id` int NOT NULL,
  PRIMARY KEY (`monitoring_id`,`food_id`),
  KEY `IDX_CE50744DA4638B5` (`monitoring_id`),
  KEY `IDX_CE50744BA8E87C4` (`food_id`),
  CONSTRAINT `FK_CE50744BA8E87C4` FOREIGN KEY (`food_id`) REFERENCES `food` (`id`) ON DELETE CASCADE,
  CONSTRAINT `FK_CE50744DA4638B5` FOREIGN KEY (`monitoring_id`) REFERENCES `monitoring` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `monitoring_food`
--

LOCK TABLES `monitoring_food` WRITE;
/*!40000 ALTER TABLE `monitoring_food` DISABLE KEYS */;
INSERT INTO `monitoring_food` VALUES (6,17),(6,18),(7,19),(9,42),(10,43),(11,44),(12,45),(13,46),(14,47),(15,48),(17,49),(17,50),(18,51),(19,52),(19,53),(20,54),(21,55),(22,56),(23,57),(24,58),(25,59),(27,60);
/*!40000 ALTER TABLE `monitoring_food` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `picture_animal`
--

DROP TABLE IF EXISTS `picture_animal`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `picture_animal` (
  `id` int NOT NULL AUTO_INCREMENT,
  `animal_id` int NOT NULL,
  `file_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_FB4F950F8E962C16` (`animal_id`),
  CONSTRAINT `FK_FB4F950F8E962C16` FOREIGN KEY (`animal_id`) REFERENCES `animal` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=39 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `picture_animal`
--

LOCK TABLES `picture_animal` WRITE;
/*!40000 ALTER TABLE `picture_animal` DISABLE KEYS */;
INSERT INTO `picture_animal` VALUES (2,3,'66bb7652b83c1.jpg'),(3,4,'66bb76688df22.jpg'),(4,5,'66bb77c74f8a7.jpg'),(5,6,'66bb782534e31.jpg'),(6,7,'66bb783b39172.jpg'),(7,8,'66bb78973ac61.jpg'),(8,9,'66bc7c4b9e8e9.jpg'),(9,10,'66bc7c64308cf.jpg'),(10,11,'66bc7c7612e7f.jpg'),(11,12,'66bc7c90687dd.jpg'),(12,13,'66bc7caf9439c.jpg'),(13,14,'66bc7cc673f71.jpg'),(14,15,'66bc7ce56cbd5.jpg'),(15,16,'66bc7cf870cfa.jpg'),(16,17,'66bc7d08ef736.jpg'),(17,18,'66bc7d417e981.jpg'),(18,19,'66bc7d6e52117.jpg'),(19,20,'66bc7d8a9b3e3.jpg'),(20,21,'66bc7db3c9b27.jpg'),(21,22,'66bc7dcfd7729.jpg'),(22,23,'66bc7de9015c8.jpg'),(23,24,'66bc7e1025856.jpg'),(24,25,'66bc7e2740c05.jpg'),(25,26,'66bc7e3e3e32a.jpg'),(26,27,'66bc7e7026e19.jpg'),(27,28,'66bc7eeaeb904.jpg'),(28,29,'66bc7f06a5e77.jpg'),(29,30,'66bc7f1a3b253.jpg'),(30,31,'66bc7f2d30ec4.jpg'),(31,32,'66bc7f47d41c5.jpg'),(32,33,'66bc7f5ea1bda.jpg'),(33,34,'66bc7f819dbf9.jpg'),(34,35,'66bc7fa4c5f9e.jpg'),(35,36,'66bc7fba06972.jpg'),(36,37,'66bc7fceeb544.jpg'),(38,2,'66bcb9eb2c05b.jpg');
/*!40000 ALTER TABLE `picture_animal` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `picture_area`
--

DROP TABLE IF EXISTS `picture_area`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `picture_area` (
  `id` int NOT NULL AUTO_INCREMENT,
  `area_id` int NOT NULL,
  `path` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_6874B8FDBD0F409C` (`area_id`),
  CONSTRAINT `FK_6874B8FDBD0F409C` FOREIGN KEY (`area_id`) REFERENCES `area` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `picture_area`
--

LOCK TABLES `picture_area` WRITE;
/*!40000 ALTER TABLE `picture_area` DISABLE KEYS */;
INSERT INTO `picture_area` VALUES (4,7,'66ba3b0c400ef.jpg'),(5,7,'66ba3b0c40519.jpg'),(6,7,'66ba3b0c4064e.jpg'),(7,8,'66bb67ed27e78.jpg'),(8,8,'66bb67ed285dd.jpg'),(9,8,'66bb67ed28758.jpg'),(10,9,'66bb6995537cc.jpg'),(11,9,'66bb699553b55.jpg'),(12,9,'66bb699553cfc.jpg');
/*!40000 ALTER TABLE `picture_area` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `recommandation_veterinary`
--

DROP TABLE IF EXISTS `recommandation_veterinary`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `recommandation_veterinary` (
  `id` int NOT NULL AUTO_INCREMENT,
  `animal_id` int NOT NULL,
  `medicine` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `date` datetime NOT NULL,
  `state` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `recommandation` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `report` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_B73ACD478E962C16` (`animal_id`),
  CONSTRAINT `FK_B73ACD478E962C16` FOREIGN KEY (`animal_id`) REFERENCES `animal` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=37 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `recommandation_veterinary`
--

LOCK TABLES `recommandation_veterinary` WRITE;
/*!40000 ALTER TABLE `recommandation_veterinary` DISABLE KEYS */;
INSERT INTO `recommandation_veterinary` VALUES (4,4,'aucun','2024-08-19 15:05:00','Bonne santé','aucune',NULL),(5,5,'aucun','2024-08-20 10:48:00','Bonne santé','surveiller oreille gauche','ballon'),(6,6,'crème cicatrisante sur plaie cuisse','2024-08-20 10:49:00','Bonne santé','appliquer généreusement la crème',NULL),(7,7,'antibiotique','2024-08-20 10:51:00','Malade','ajouter la dose antibiotique aux fruits','ballon a fruit'),(8,18,'aucun','2024-08-20 10:53:00','En convalescence','aucune',NULL),(9,8,NULL,'2024-08-20 10:54:00','Bonne santé',NULL,NULL),(13,2,NULL,'2024-08-22 11:50:00','Bonne santé',NULL,NULL),(15,9,'aucun','2024-08-23 10:44:00','Bonne santé','aucune',NULL),(16,10,'aucun','2024-08-23 10:45:00','Bléssé','appliquer crème sur la patte gauche',NULL),(17,11,'aucun','2024-08-23 10:47:00','Bonne santé','aucune',NULL),(18,12,'aucun','2024-08-23 10:48:00','Bonne santé','aucune',NULL),(19,15,NULL,'2024-08-23 11:19:00','Bonne santé',NULL,NULL),(20,16,'aucun','2024-08-23 11:20:00','En convalescence','aucune',NULL),(21,17,NULL,'2024-08-23 11:20:00','Bonne santé',NULL,NULL),(22,27,'aucun','2024-08-23 11:21:00','Bonne santé','aucune',NULL),(23,28,'aucun','2024-08-23 11:21:00','Bonne santé','aucune',NULL),(24,29,NULL,'2024-08-23 11:22:00','Bonne santé',NULL,NULL),(25,30,'aucun','2024-08-23 11:22:00','Bonne santé','aucune',NULL),(26,31,'aucun','2024-08-23 11:22:00','Bonne santé','aucune',NULL),(27,32,'aucun','2024-08-23 11:23:00','Bonne santé','aucune',NULL),(28,33,'aucun','2024-08-23 11:23:00','Malade','aucune',NULL),(31,19,NULL,'2024-08-23 14:20:00','Bonne santé',NULL,NULL),(32,20,NULL,'2024-08-23 14:21:00','Bonne santé',NULL,NULL),(33,21,NULL,'2024-08-23 14:21:00','En convalescence',NULL,NULL),(34,22,NULL,'2024-08-23 14:21:00','Bonne santé',NULL,NULL),(35,23,NULL,'2024-08-23 14:21:00','Bléssé',NULL,NULL),(36,24,NULL,'2024-08-23 14:21:00','Bonne santé',NULL,NULL);
/*!40000 ALTER TABLE `recommandation_veterinary` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `recommandation_veterinary_food`
--

DROP TABLE IF EXISTS `recommandation_veterinary_food`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `recommandation_veterinary_food` (
  `recommandation_veterinary_id` int NOT NULL,
  `food_id` int NOT NULL,
  PRIMARY KEY (`recommandation_veterinary_id`,`food_id`),
  KEY `IDX_6591B357ABCC2E73` (`recommandation_veterinary_id`),
  KEY `IDX_6591B357BA8E87C4` (`food_id`),
  CONSTRAINT `FK_6591B357ABCC2E73` FOREIGN KEY (`recommandation_veterinary_id`) REFERENCES `recommandation_veterinary` (`id`) ON DELETE CASCADE,
  CONSTRAINT `FK_6591B357BA8E87C4` FOREIGN KEY (`food_id`) REFERENCES `food` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `recommandation_veterinary_food`
--

LOCK TABLES `recommandation_veterinary_food` WRITE;
/*!40000 ALTER TABLE `recommandation_veterinary_food` DISABLE KEYS */;
INSERT INTO `recommandation_veterinary_food` VALUES (4,5),(5,6),(5,7),(6,8),(6,9),(7,10),(8,11),(8,12),(9,13),(9,14),(13,24),(15,26),(16,27),(17,28),(18,29),(19,30),(20,31),(21,32),(22,33),(23,34),(24,35),(25,36),(26,37),(27,38),(28,39);
/*!40000 ALTER TABLE `recommandation_veterinary_food` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `review`
--

DROP TABLE IF EXISTS `review`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `review` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `count` int NOT NULL,
  `content` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `date` date NOT NULL,
  `is_approuved` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `review`
--

LOCK TABLES `review` WRITE;
/*!40000 ALTER TABLE `review` DISABLE KEYS */;
INSERT INTO `review` VALUES (1,'cyrille',5,'premier comm','2024-08-15',1),(11,'cyrille',1,'essai pour 1 etoile','2024-08-19',1),(12,'cyrille',4,'essai pour 4 etoiles','2024-08-24',1),(14,'Mookie',5,'Nous avons passé une belle journée au sein de ce zoo, nous avons pu profiter de la présence de plein d\'animaux.','2024-08-24',1),(16,'Cyr',2,'ajout du commentaire de validation','2024-08-27',0);
/*!40000 ALTER TABLE `review` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `service`
--

DROP TABLE IF EXISTS `service`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `service` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `descritpion` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `picture` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `service`
--

LOCK TABLES `service` WRITE;
/*!40000 ALTER TABLE `service` DISABLE KEYS */;
INSERT INTO `service` VALUES (1,'Restauration','Profitez de nos stands de restauration rapide pour une pause gourmande avec des menus adaptés à toute la famille.','/uploads/66bcd04a74797.jpg'),(2,'Train','une visite en train du zoo, pour ne rien manquer du parc','/uploads/66bce03ecae01.jpg'),(3,'Guide','Profitez d\'un guide pour votre visite sur le parc','/uploads/66bce1a665da2.jpg');
/*!40000 ALTER TABLE `service` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `veterinary`
--

DROP TABLE IF EXISTS `veterinary`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `veterinary` (
  `id` int NOT NULL AUTO_INCREMENT,
  `email` varchar(180) COLLATE utf8mb4_unicode_ci NOT NULL,
  `roles` json NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_IDENTIFIER_EMAIL` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `veterinary`
--

LOCK TABLES `veterinary` WRITE;
/*!40000 ALTER TABLE `veterinary` DISABLE KEYS */;
INSERT INTO `veterinary` VALUES (3,'swan@gmail.com','[\"ROLE_VETERINARY\"]','$2y$13$1ubV15jXiqNhYrnL1IeCFOviO.NtmYCjn5DJAjhkAwMtJnUk0OKF2');
/*!40000 ALTER TABLE `veterinary` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2024-08-29 16:41:22
