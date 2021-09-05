
-- --------------------------------------------------------

--
-- Table structure for table `dt_subscriber`
--

DROP TABLE IF EXISTS `dt_subscriber`;
CREATE TABLE `dt_subscriber` (
  `id` int NOT NULL,
  `mail` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `nama` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `platform` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `stat` int DEFAULT '1' COMMENT '1.aktif, 0. nonaktif'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `dt_subscriber`
--

INSERT INTO `dt_subscriber` (`id`, `mail`, `nama`, `platform`, `stat`) VALUES
(1, NULL, NULL, 'Linux', 1),
(2, NULL, NULL, 'Linux', 1),
(3, 'maspriyambodo@gmail.com', 'bod', 'Linux', 1);
