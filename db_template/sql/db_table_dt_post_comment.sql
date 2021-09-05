
-- --------------------------------------------------------

--
-- Table structure for table `dt_post_comment`
--

DROP TABLE IF EXISTS `dt_post_comment`;
CREATE TABLE `dt_post_comment` (
  `id` int NOT NULL,
  `post_id` int DEFAULT NULL COMMENT 'relasi dengan table post',
  `comment_user` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  `comment_email` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  `comment_content` text CHARACTER SET utf8mb4 COLLATE utf8mb4_bin,
  `comment_date` datetime DEFAULT NULL,
  `comment_parent` int DEFAULT '0',
  `ip_address` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  `stat` int DEFAULT NULL COMMENT '0. delete\r\n1. aktif\r\n2. edit',
  `syscreateuser` int DEFAULT NULL,
  `syscreatedate` datetime DEFAULT NULL,
  `sysupdateuser` int DEFAULT NULL COMMENT 'user approved comment',
  `sysupdatedate` datetime DEFAULT NULL COMMENT 'date approved comment',
  `sysdeleteuser` int DEFAULT NULL,
  `sysdeletedate` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `dt_post_comment`
--

INSERT INTO `dt_post_comment` (`id`, `post_id`, `comment_user`, `comment_email`, `comment_content`, `comment_date`, `comment_parent`, `ip_address`, `stat`, `syscreateuser`, `syscreatedate`, `sysupdateuser`, `sysupdatedate`, `sysdeleteuser`, `sysdeletedate`) VALUES
(1, 29, 'bodo', 'maspriyambodo@gmail.com', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled', '2021-08-23 14:27:39', 0, '127.0.0.1', 1, 1, '2021-08-23 14:27:39', NULL, NULL, NULL, NULL),
(2, 29, 'pribodo', 'kalong@gmail.com', 'Example #2 Get the column of last names from a recordset, indexed by the \"id\" column ', '2021-08-23 14:27:39', 1, '127.0.0.1', 1, 1, '2021-08-23 14:27:39', NULL, NULL, NULL, NULL),
(3, 29, 'bodo', 'kodok@gmail.com', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled', '2021-08-23 14:27:39', 0, '127.0.0.1', 1, 1, '2021-08-23 14:27:39', NULL, NULL, NULL, NULL),
(4, 29, 'pribodo', 'kalong@gmail.com', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled', '2021-08-23 14:27:39', 1, '127.0.0.1', 1, 1, '2021-08-23 14:27:39', NULL, NULL, NULL, NULL),
(5, 29, 'kadir', 'kadir@gmail.com', '@bodo test bales komen nih', '2021-08-23 21:41:24', 1, '127.0.0.1', 1, 99, '2021-08-23 21:41:24', NULL, NULL, NULL, NULL),
(6, 29, 'joni', 'joni@gmail.com', '@bodo test childern komen di level 2', '2021-08-23 21:42:10', 3, '127.0.0.1', 1, 99, '2021-08-23 21:42:10', NULL, NULL, NULL, NULL),
(7, 26, 'petot', 'petot@gmail.com', 'waaooowww ginjal mahal uga yak', '2021-08-23 21:42:52', 0, '127.0.0.1', 1, 99, '2021-08-23 21:42:52', NULL, NULL, NULL, NULL),
(8, 38, 'kodok', 'kodok@gmail.com', 'Donec sed odio dui. Nulla vitae elit libero, a pharetra augue. Nullam id dolor id nibh ultricies vehicula ut id elit. Integer posuere erat a ante venenatis dapibus posuere velit aliquet.', '2021-08-24 00:34:57', 0, '127.0.0.1', 1, 99, '2021-08-24 00:34:57', NULL, NULL, NULL, NULL);
