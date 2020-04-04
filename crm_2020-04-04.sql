# ************************************************************
# Sequel Pro SQL dump
# Version 5438
#
# https://www.sequelpro.com/
# https://github.com/sequelpro/sequelpro
#
# Host: 127.0.0.1 (MySQL 5.7.29-0ubuntu0.18.04.1)
# Database: crm
# Generation Time: 2020-04-04 14:35:01 +0000
# ************************************************************


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
SET NAMES utf8mb4;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


# Dump of table achievements
# ------------------------------------------------------------

DROP TABLE IF EXISTS `achievements`;

CREATE TABLE `achievements` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `start` int(11) DEFAULT NULL COMMENT '业绩范围开始值',
  `end` int(11) DEFAULT NULL COMMENT '业绩范围结束值',
  `percent` int(11) DEFAULT NULL COMMENT '提成百分比',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

LOCK TABLES `achievements` WRITE;
/*!40000 ALTER TABLE `achievements` DISABLE KEYS */;

INSERT INTO `achievements` (`id`, `user_id`, `start`, `end`, `percent`)
VALUES
	(7,6,0,5999,2),
	(8,6,6000,11999,4),
	(10,5,0,5999,2),
	(11,5,6000,11999,4),
	(12,5,12000,17999,6),
	(13,5,18000,23999,8),
	(14,5,24000,49999,10),
	(15,5,50000,79999,12),
	(16,5,80000,150000,15);

/*!40000 ALTER TABLE `achievements` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table adverts
# ------------------------------------------------------------

DROP TABLE IF EXISTS `adverts`;

CREATE TABLE `adverts` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `image` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

LOCK TABLES `adverts` WRITE;
/*!40000 ALTER TABLE `adverts` DISABLE KEYS */;

INSERT INTO `adverts` (`id`, `image`)
VALUES
	(1,'http://i8.mifile.cn/v1/a1/T1_1W_BgVv1RXrhCrK!720x360.jpg'),
	(2,'http://i8.mifile.cn/v1/a1/T12LdgBXZv1RXrhCrK!720x360.jpg'),
	(3,'http://i8.mifile.cn/v1/a1/T1zgZvBgK_1RXrhCrK!720x360.jpg');

/*!40000 ALTER TABLE `adverts` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table attendances
# ------------------------------------------------------------

DROP TABLE IF EXISTS `attendances`;

CREATE TABLE `attendances` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `userId` int(11) DEFAULT NULL COMMENT '教练编号',
  `timeResult` varchar(20) DEFAULT NULL COMMENT '打卡结果',
  `userCheckTime` timestamp NULL DEFAULT NULL COMMENT '打卡时间',
  `sourceType` varchar(100) DEFAULT NULL COMMENT '数据来源',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

LOCK TABLES `attendances` WRITE;
/*!40000 ALTER TABLE `attendances` DISABLE KEYS */;

INSERT INTO `attendances` (`id`, `userId`, `timeResult`, `userCheckTime`, `sourceType`)
VALUES
	(1,6,'Late','2020-03-29 09:09:01','DING_ATM'),
	(2,5,'Normal','2020-03-29 08:45:01','DING_ATM'),
	(3,6,'Late','2020-03-28 09:18:01','DING_ATM'),
	(4,5,'Normal','2020-03-28 08:35:01','DING_ATM'),
	(5,5,'Late','2020-03-27 09:10:01','DING_ATM'),
	(6,6,'Late','2020-03-27 09:05:01','DING_ATM'),
	(7,6,'Late','2020-03-29 09:09:01','DING_ATM'),
	(8,5,'Normal','2020-03-29 08:45:01','DING_ATM'),
	(9,6,'Late','2020-03-28 09:18:01','DING_ATM'),
	(10,5,'Normal','2020-03-28 08:35:01','DING_ATM'),
	(11,5,'Late','2020-03-27 09:10:01','DING_ATM'),
	(12,6,'Late','2020-03-27 09:05:01','DING_ATM'),
	(13,6,'Late','2020-03-29 09:09:01','DING_ATM'),
	(14,5,'Normal','2020-03-29 08:45:01','DING_ATM'),
	(15,6,'Late','2020-03-28 09:18:01','DING_ATM'),
	(16,5,'Normal','2020-03-28 08:35:01','DING_ATM'),
	(17,5,'Late','2020-03-27 09:10:01','DING_ATM'),
	(18,6,'Late','2020-03-27 09:05:01','DING_ATM');

/*!40000 ALTER TABLE `attendances` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table checkouts
# ------------------------------------------------------------

DROP TABLE IF EXISTS `checkouts`;

CREATE TABLE `checkouts` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `base_salary` decimal(10,2) DEFAULT NULL,
  `task` decimal(10,2) DEFAULT NULL,
  `total_hours` decimal(10,2) DEFAULT NULL,
  `amount` decimal(10,2) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

LOCK TABLES `checkouts` WRITE;
/*!40000 ALTER TABLE `checkouts` DISABLE KEYS */;

INSERT INTO `checkouts` (`id`, `user_id`, `base_salary`, `task`, `total_hours`, `amount`, `created_at`, `updated_at`)
VALUES
	(1,5,3000.00,6390.00,18.00,9408.00,'2020-03-29 22:20:20','2020-03-29 22:20:20'),
	(2,6,2000.00,3990.00,12.00,6002.00,'2020-03-30 14:56:41','2020-03-30 14:56:41');

/*!40000 ALTER TABLE `checkouts` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table course_properties
# ------------------------------------------------------------

DROP TABLE IF EXISTS `course_properties`;

CREATE TABLE `course_properties` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `customer_id` int(11) DEFAULT NULL,
  `course_id` int(11) DEFAULT NULL COMMENT '课程id',
  `c_hour` int(11) DEFAULT NULL COMMENT '课时',
  `c_price` decimal(10,2) DEFAULT NULL COMMENT '价格',
  `paid_at` timestamp NULL DEFAULT NULL COMMENT '购买时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

LOCK TABLES `course_properties` WRITE;
/*!40000 ALTER TABLE `course_properties` DISABLE KEYS */;

INSERT INTO `course_properties` (`id`, `customer_id`, `course_id`, `c_hour`, `c_price`, `paid_at`)
VALUES
	(9,6,3,10,50.00,'2020-03-16 12:29:36'),
	(10,6,4,10,80.00,'2020-03-16 12:30:35'),
	(11,7,4,10,200.00,'2020-03-16 18:05:53'),
	(12,8,4,60,300.00,'2020-03-16 22:26:21'),
	(13,7,3,50,300.00,'2020-03-30 00:09:26'),
	(14,8,2,70,260.00,'2020-03-30 01:43:28'),
	(15,6,1,20,600.00,'2020-03-30 01:47:13');

/*!40000 ALTER TABLE `course_properties` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table courses
# ------------------------------------------------------------

DROP TABLE IF EXISTS `courses`;

CREATE TABLE `courses` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

LOCK TABLES `courses` WRITE;
/*!40000 ALTER TABLE `courses` DISABLE KEYS */;

INSERT INTO `courses` (`id`, `name`, `image`, `created_at`, `updated_at`)
VALUES
	(1,'团课','https://image.holyzq.com/7CdTHJwUXImzpyWb1o8EkZUyQKUpsapsavbjwHlb.jpeg','2020-02-03 11:20:21','2020-03-08 03:10:09'),
	(2,'拉伸课','https://image.holyzq.com/umE1Ex2z5aBYFbOPZ3wP6DPUy1OPBBzTLOOStvfn.jpeg','2020-02-03 11:20:59','2020-03-08 03:10:00'),
	(3,'拳击课','https://image.holyzq.com/CrtmPEofSNkeyeR7iHtr9FnddMYYcpVXMFeCIzRx.jpeg','2020-02-03 11:21:06','2020-03-08 03:09:38'),
	(4,'常规课','https://image.holyzq.com/AlaQO5061GWA8vHUm5doaS1U5qkCpa76znKO7FEj.jpeg','2020-02-03 11:21:13','2020-03-08 03:09:17');

/*!40000 ALTER TABLE `courses` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table customer_type
# ------------------------------------------------------------

DROP TABLE IF EXISTS `customer_type`;

CREATE TABLE `customer_type` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `customer_id` int(11) DEFAULT NULL,
  `type_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

LOCK TABLES `customer_type` WRITE;
/*!40000 ALTER TABLE `customer_type` DISABLE KEYS */;

INSERT INTO `customer_type` (`id`, `customer_id`, `type_id`)
VALUES
	(10,6,2),
	(11,7,2),
	(12,8,2),
	(13,8,3);

/*!40000 ALTER TABLE `customer_type` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table customers
# ------------------------------------------------------------

DROP TABLE IF EXISTS `customers`;

CREATE TABLE `customers` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `username` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL COMMENT '前台会员登录密码',
  `mobile` varchar(255) DEFAULT NULL,
  `birthday` varchar(255) DEFAULT NULL,
  `cycle_id` tinyint(1) DEFAULT NULL COMMENT '办卡会员周期',
  `card_price` decimal(10,2) DEFAULT NULL COMMENT '办卡会员价格',
  `expired_at` varchar(255) DEFAULT NULL COMMENT '办卡会员有效期',
  `card_at` timestamp NULL DEFAULT NULL COMMENT '办卡时间',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

LOCK TABLES `customers` WRITE;
/*!40000 ALTER TABLE `customers` DISABLE KEYS */;

INSERT INTO `customers` (`id`, `user_id`, `username`, `password`, `mobile`, `birthday`, `cycle_id`, `card_price`, `expired_at`, `card_at`, `created_at`, `updated_at`)
VALUES
	(6,6,'陈像','$2y$10$RWiSYNf/64m4LBFowgYlI.vkpKVmQEPL5l9tjd7ePMHLk7IDpzcK6','13687119511','02-03',NULL,NULL,NULL,NULL,'2020-03-16 12:29:21','2020-03-16 12:29:21'),
	(7,5,'崔天宝','$2y$10$ALyrm877Lah9BSCnyDipTewbETEdCj3bUK9rcH67YafelJ.NR6zfS','13871830515','0426',NULL,NULL,NULL,NULL,'2020-03-16 18:05:10','2020-03-16 18:05:10'),
	(8,5,'孙悟空','$2y$10$G2Qa0OPVWHmuCqBL6md/3.iJDSTR1qF010XiAsL4QAnB6CjAqdyfW','13419566683','02-11',NULL,NULL,NULL,NULL,'2020-03-16 22:26:08','2020-03-19 21:47:54');

/*!40000 ALTER TABLE `customers` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table failed_jobs
# ------------------------------------------------------------

DROP TABLE IF EXISTS `failed_jobs`;

CREATE TABLE `failed_jobs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;



# Dump of table hours
# ------------------------------------------------------------

DROP TABLE IF EXISTS `hours`;

CREATE TABLE `hours` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `course_id` int(11) DEFAULT NULL,
  `c_name` varchar(255) DEFAULT NULL,
  `price` decimal(10,2) DEFAULT NULL,
  `buy_num` int(11) DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

LOCK TABLES `hours` WRITE;
/*!40000 ALTER TABLE `hours` DISABLE KEYS */;

INSERT INTO `hours` (`id`, `course_id`, `c_name`, `price`, `buy_num`, `created_at`, `updated_at`)
VALUES
	(1,1,'第一课时',1.00,2,NULL,'2020-02-09 15:01:15'),
	(2,1,'第二课时',2.00,1,NULL,NULL),
	(3,1,'第三课时',3.00,0,NULL,NULL),
	(4,1,'第四课时',4.00,0,'2020-02-03 12:56:55','2020-02-03 12:56:55'),
	(5,1,'第五课时',5.00,0,'2020-02-03 12:57:24','2020-02-03 12:57:24'),
	(7,2,'第一课时',1.00,4,'2020-02-03 13:12:12','2020-02-12 21:31:04'),
	(10,4,'第一课时',1.00,3,'2020-02-04 01:32:35','2020-02-08 22:48:10'),
	(11,3,'第一课时',1.00,2,'2020-02-04 22:53:53','2020-02-09 15:01:06'),
	(12,3,'第二课时',2.00,1,'2020-02-04 22:54:10','2020-02-04 22:54:10'),
	(13,4,'第二课时',2.00,0,'2020-02-05 20:10:50','2020-02-05 20:10:50'),
	(14,2,'第二课时',2.00,2,'2020-02-05 20:11:09','2020-02-08 21:58:18'),
	(15,4,'第三课时',4.00,0,'2020-02-26 09:39:43','2020-02-26 09:39:43'),
	(16,4,'第四课时',4.00,0,'2020-02-27 08:32:38','2020-02-27 08:32:55');

/*!40000 ALTER TABLE `hours` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table migrations
# ------------------------------------------------------------

DROP TABLE IF EXISTS `migrations`;

CREATE TABLE `migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;

INSERT INTO `migrations` (`id`, `migration`, `batch`)
VALUES
	(1,'2014_10_12_000000_create_users_table',1),
	(2,'2014_10_12_100000_create_password_resets_table',1),
	(3,'2019_08_19_000000_create_failed_jobs_table',1);

/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table password_resets
# ------------------------------------------------------------

DROP TABLE IF EXISTS `password_resets`;

CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  KEY `password_resets_email_index` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;



# Dump of table records
# ------------------------------------------------------------

DROP TABLE IF EXISTS `records`;

CREATE TABLE `records` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `customer_id` int(11) DEFAULT NULL,
  `buy_course_id` int(11) DEFAULT NULL COMMENT '购课课程',
  `relation_course_id` int(11) DEFAULT NULL COMMENT '赠送课程',
  `buy_type_id` int(11) DEFAULT NULL COMMENT '购课会员',
  `relation_type_id` int(11) DEFAULT NULL COMMENT '赠送会员',
  `surplus_hour` int(11) DEFAULT NULL COMMENT '剩余课时',
  `status` tinyint(1) DEFAULT '0' COMMENT '是否确认上课',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

LOCK TABLES `records` WRITE;
/*!40000 ALTER TABLE `records` DISABLE KEYS */;

INSERT INTO `records` (`id`, `user_id`, `customer_id`, `buy_course_id`, `relation_course_id`, `buy_type_id`, `relation_type_id`, `surplus_hour`, `status`, `created_at`, `updated_at`)
VALUES
	(1,5,8,4,NULL,2,NULL,58,1,'2020-03-17 22:24:40','2020-03-17 22:31:45'),
	(4,5,8,NULL,1,NULL,3,19,1,'2020-03-17 22:42:46','2020-03-17 22:45:12'),
	(5,5,8,NULL,1,NULL,3,18,1,'2020-03-18 01:26:12','2020-03-18 01:28:39'),
	(7,5,8,4,NULL,2,NULL,57,1,'2020-03-18 01:29:59','2020-03-18 01:30:12'),
	(8,5,8,4,NULL,2,NULL,56,1,'2020-03-19 21:48:31','2020-03-20 11:19:40'),
	(9,5,8,4,NULL,2,NULL,55,1,'2020-03-30 01:19:25','2020-03-30 01:20:14'),
	(10,6,6,1,NULL,2,NULL,19,1,'2020-03-30 11:35:15','2020-03-30 11:36:09'),
	(11,5,6,3,NULL,2,NULL,10,0,'2020-04-04 19:22:47','2020-04-04 19:22:47');

/*!40000 ALTER TABLE `records` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table relation_properties
# ------------------------------------------------------------

DROP TABLE IF EXISTS `relation_properties`;

CREATE TABLE `relation_properties` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `customer_id` int(11) DEFAULT NULL,
  `course_id` int(11) DEFAULT NULL COMMENT '赠送课程的id',
  `g_hour` int(11) DEFAULT NULL COMMENT '赠送的课时',
  `paid_at` timestamp NULL DEFAULT NULL COMMENT '赠送时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

LOCK TABLES `relation_properties` WRITE;
/*!40000 ALTER TABLE `relation_properties` DISABLE KEYS */;

INSERT INTO `relation_properties` (`id`, `customer_id`, `course_id`, `g_hour`, `paid_at`)
VALUES
	(5,8,1,20,'2020-03-16 22:26:36');

/*!40000 ALTER TABLE `relation_properties` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table tests
# ------------------------------------------------------------

DROP TABLE IF EXISTS `tests`;

CREATE TABLE `tests` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `userId` int(11) DEFAULT NULL,
  `timeResult` varchar(20) DEFAULT NULL,
  `userCheckTime` timestamp NULL DEFAULT NULL,
  `sourceType` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

LOCK TABLES `tests` WRITE;
/*!40000 ALTER TABLE `tests` DISABLE KEYS */;

INSERT INTO `tests` (`id`, `userId`, `timeResult`, `userCheckTime`, `sourceType`)
VALUES
	(1,5,'Normal','2020-03-28 08:35:01','DING_ATM'),
	(2,6,'Late','2020-03-28 09:18:01','DING_ATM'),
	(3,5,'Late','2020-03-27 09:10:01','DING_ATM'),
	(4,6,'Late','2020-03-27 09:05:01','DING_ATM'),
	(5,5,'Normal','2020-03-29 08:45:01','DING_ATM'),
	(6,6,'Late','2020-03-29 09:09:01','DING_ATM');

/*!40000 ALTER TABLE `tests` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table types
# ------------------------------------------------------------

DROP TABLE IF EXISTS `types`;

CREATE TABLE `types` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `type_name` varchar(255) DEFAULT NULL,
  `userCheckTime` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

LOCK TABLES `types` WRITE;
/*!40000 ALTER TABLE `types` DISABLE KEYS */;

INSERT INTO `types` (`id`, `type_name`, `userCheckTime`)
VALUES
	(1,'办卡',NULL),
	(2,'购课',NULL),
	(3,'赠课',NULL);

/*!40000 ALTER TABLE `types` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table users
# ------------------------------------------------------------

DROP TABLE IF EXISTS `users`;

CREATE TABLE `users` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT '' COMMENT '教练登录账号',
  `email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT '',
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT '',
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `realname` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '真实姓名',
  `master_no` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '教练工号',
  `base_salary` decimal(10,2) DEFAULT NULL COMMENT '底薪',
  `is_master` tinyint(1) DEFAULT '1' COMMENT '教练、管理员',
  `is_job` tinyint(1) DEFAULT '1' COMMENT '是否在职',
  `task` decimal(10,2) DEFAULT NULL COMMENT '业务指标',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `remember_token`, `realname`, `master_no`, `base_salary`, `is_master`, `is_job`, `task`, `created_at`, `updated_at`)
VALUES
	(1,'admin','123456@qq.com',NULL,'$2y$10$dTlz4D8Lu1ZCtqi0I0J6wOrmFgmaFRFEpz/DB3yo91AZswIx1eK.q','KXLTyTSTjfWxdLal49Ex8GYDoH60JrKJ6oiki4XojFF4FuEFH6py1mOURA8M',NULL,NULL,NULL,0,1,NULL,NULL,NULL),
	(5,'huangjie','',NULL,'$2y$10$QM0jGUqSqm.tpLT.ErqrG.vN5kTQXsorr4veA6QOOQlOBl6svRKG.',NULL,'黄杰','001',3000.00,1,1,30000.00,'2020-03-16 10:05:50','2020-03-29 19:54:56'),
	(6,'chenwei','',NULL,'$2y$10$b0DQaS5Iy8wviU/.fLGHk.BWxrV5dUH2BsjkHC0QzrnMq3FUFvlOy',NULL,'陈维','002',2000.00,1,1,30000.00,'2020-03-16 10:05:50','2020-03-29 19:54:39');

/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;



/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
