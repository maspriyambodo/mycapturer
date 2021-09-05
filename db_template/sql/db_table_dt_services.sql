
-- --------------------------------------------------------

--
-- Table structure for table `dt_services`
--

DROP TABLE IF EXISTS `dt_services`;
CREATE TABLE `dt_services` (
  `id` int NOT NULL,
  `nama` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `desc` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci,
  `stat` int DEFAULT '1' COMMENT '1.aktif, 0. delete',
  `syscreateuser` int DEFAULT NULL,
  `syscreatedate` datetime DEFAULT NULL,
  `sysupdateuser` int DEFAULT NULL,
  `sysupdatedate` datetime DEFAULT NULL,
  `sysdeleteuser` int DEFAULT NULL,
  `sysdeletedate` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='table untuk company profile halaman services';

--
-- Dumping data for table `dt_services`
--

INSERT INTO `dt_services` (`id`, `nama`, `desc`, `stat`, `syscreateuser`, `syscreatedate`, `sysupdateuser`, `sysupdatedate`, `sysdeleteuser`, `sysdeletedate`) VALUES
(1, 'PHOTO PRODUCT', 'Hasil Foto dapat digunakan untuk memperindah Produk, Meningkatkan Penjualan / Omset, dan Memajukan Perusahaan tanpa menambah atau mengurangi keaslian Produk.', 1, 1, '2021-07-19 18:48:23', NULL, NULL, NULL, NULL),
(2, 'PHOTO & VIDEO PRODUCT', 'Hasil Foto dapat digunakan untuk memperindah Produk, Meningkatkan Penjualan / Omset, dan Memajukan Perusahaan tanpa menambah atau mengurangi keaslian Produk.', 1, 1, '2021-07-19 18:48:23', NULL, NULL, NULL, NULL),
(3, 'PHOTO & VIDEO DOKUMENTASI', 'Kami membantu Dokumentasi dalam sebuah Acara berbentuk digital berupa Foto & Video. yang dikemas dengan menarik dan Modern.', 1, 1, '2021-07-19 18:48:23', NULL, NULL, NULL, NULL),
(4, 'PHOTOBOOTH', 'Photobooth bisa juga dijadikan souvenir untuk semua kebutuhan acara anda.', 1, 1, '2021-07-19 18:48:23', NULL, NULL, NULL, NULL),
(5, 'PHOTOBOOTH MATRIX', 'Dengan menggunakan banyak kamera yang mengambil gambar secara bersamaan dari berbagai arah.', 1, 1, '2021-07-19 18:48:23', NULL, NULL, NULL, NULL),
(6, 'PHOTO & VIDEO ENGAGEMENT', 'Dengan menggunakan banyak kamera yang mengambil gambar secara bersamaan dari berbagai arah.', 1, 1, '2021-07-19 18:48:23', 1, '2021-08-20 19:52:34', 1, '2021-08-20 19:52:15'),
(7, 'PHOTO & VIDEO PREWEDDING', NULL, 1, 1, '2021-07-19 18:48:23', NULL, NULL, NULL, NULL),
(8, 'PHOTO & VIDEO WEDDING', NULL, 1, 1, '2021-07-19 18:48:23', NULL, NULL, NULL, NULL),
(9, 'PHOTO & VIDEO BIRTHDAY', NULL, 1, 1, '2021-07-19 18:48:23', NULL, NULL, NULL, NULL),
(10, 'Lorem Ipsum(edit)', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s', 0, 1, '2021-07-19 19:54:49', 1, '2021-07-21 18:26:16', 1, '2021-07-21 18:26:34');
