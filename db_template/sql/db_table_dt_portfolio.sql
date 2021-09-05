
-- --------------------------------------------------------

--
-- Table structure for table `dt_portfolio`
--

DROP TABLE IF EXISTS `dt_portfolio`;
CREATE TABLE `dt_portfolio` (
  `id` int NOT NULL,
  `lowres` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `highres` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `title` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `desc` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `tipe` int DEFAULT NULL COMMENT '1.pict, 2.video from upload, 3. youtube',
  `stat` int DEFAULT '1' COMMENT '1.aktif, 0. delete',
  `syscreateuser` int DEFAULT NULL,
  `syscreatedate` datetime DEFAULT NULL,
  `sysupdateuser` int DEFAULT NULL,
  `sysupdatedate` datetime DEFAULT NULL,
  `sysdeleteuser` int DEFAULT NULL,
  `sysdeletedate` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `dt_portfolio`
--

INSERT INTO `dt_portfolio` (`id`, `lowres`, `highres`, `title`, `desc`, `tipe`, `stat`, `syscreateuser`, `syscreatedate`, `sysupdateuser`, `sysupdatedate`, `sysdeleteuser`, `sysdeletedate`) VALUES
(1, 'portfolio_1.jpg', 'portfolio_1.jpg', 'portfolio 1', 'portfolio 1', 2, 1, 1, '2021-07-19 13:54:30', NULL, NULL, 1, '2021-07-22 16:36:34'),
(2, 'portfolio_2.jpg', 'https://www.youtube.com/watch?v=Noe7ianAuN8', 'portfolio 2', 'portfolio 2', 3, 1, 1, '2021-07-19 13:54:30', NULL, NULL, 1, '2021-07-22 16:36:34'),
(3, 'portfolio_3.jpg', 'portfolio_3.jpg', 'portfolio 3', 'portfolio 3', 1, 1, 1, '2021-07-19 13:54:30', NULL, NULL, 1, '2021-07-22 16:36:34'),
(4, 'portfolio_4.jpg', 'portfolio_4.jpg', 'portfolio 4', 'portfolio 4', 1, 1, 1, '2021-07-19 13:54:30', NULL, NULL, 1, '2021-07-22 16:36:34'),
(5, 'portfolio_5.jpg', 'portfolio_5.jpg', 'portfolio 5', 'portfolio 5', 1, 1, 1, '2021-07-19 13:54:30', NULL, NULL, 1, '2021-07-22 16:36:34'),
(6, 'portfolio_6.jpg', 'portfolio_6.jpg', 'portfolio 6', 'portfolio 6', 1, 1, 1, '2021-07-19 13:54:30', NULL, NULL, 1, '2021-07-22 16:36:34'),
(7, 'portfolio_6.jpg', 'portfolio_6.jpg', 'portfolio_6.jpg', 'portfolio_6.jpg', 1, 1, 1, NULL, NULL, NULL, 1, '2021-07-22 16:36:34'),
(8, '2021_07_21_17_08_58.jpg', '2021_07_21_17_09_15.jpeg', 'Lipsum', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry', 1, 1, 1, '2021-07-21 17:10:16', NULL, NULL, 1, '2021-07-22 16:36:34'),
(9, '2021_07_21_17_18_25.png', '2021_07_21_17_18_35.mp4', 'Gallery video', 'test upload galeri video', 2, 1, 1, '2021-07-21 17:19:00', NULL, NULL, 1, '2021-07-22 16:36:34'),
(10, '2021_07_21_19_12_43.png', 'https://www.youtube.com/watch?v=q7Fu7d1ppbI', 'Video from youtube', 'Produser : Loo Idea Collective Studio\r\nSutradara : Dwi Ario Abadi ', 3, 1, 1, '2021-07-21 19:13:10', NULL, NULL, 1, '2021-07-22 16:36:34');
