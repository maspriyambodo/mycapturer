
-- --------------------------------------------------------

--
-- Table structure for table `dt_post_report`
--

DROP TABLE IF EXISTS `dt_post_report`;
CREATE TABLE `dt_post_report` (
  `id` int NOT NULL,
  `category` int DEFAULT NULL COMMENT '1. post\r\n2. comment',
  `id_category` int DEFAULT NULL COMMENT 'diambil dari ID post, atau ID comment',
  `username` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  `email` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_bin,
  `ip_address` varchar(45) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  `syscreatedate` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='table untuk report / laporkan post atau komentar di aplikasi blog';
