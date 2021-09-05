
-- --------------------------------------------------------

--
-- Table structure for table `compro_option`
--

DROP TABLE IF EXISTS `compro_option`;
CREATE TABLE `compro_option` (
  `id` int NOT NULL,
  `option_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  `option_value` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci,
  `description` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci,
  `stat` int DEFAULT '1',
  `syscreateuser` int DEFAULT NULL,
  `syscreatedate` datetime DEFAULT NULL,
  `sysupdateuser` int DEFAULT NULL,
  `sysupdatedate` datetime DEFAULT NULL,
  `sysdeleteuser` int DEFAULT NULL,
  `sysdeletedate` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `compro_option`
--

INSERT INTO `compro_option` (`id`, `option_name`, `option_value`, `description`, `stat`, `syscreateuser`, `syscreatedate`, `sysupdateuser`, `sysupdatedate`, `sysdeleteuser`, `sysdeletedate`) VALUES
(1, 'slider_text', 'KONTOL', 'asiodj', 0, 1, '2021-07-23 16:02:59', 1, '2021-08-20 19:50:35', 1, '2021-08-24 12:26:09'),
(2, 'phone_company', '+62 813-8237-6140', 'telepon perusahaan', 1, 1, '2021-07-23 18:34:05', NULL, NULL, NULL, NULL),
(3, 'sub_slider', 'aoscjoasjc[scjp[scjp[scscj', 'text dibawah slider text ', 1, 1, '2021-07-23 20:16:09', 1, '2021-08-20 19:51:04', NULL, NULL),
(4, 'mail_company', 'info@auplus.com', 'email untuk company profile', 1, 1, '2021-07-23 21:31:00', NULL, NULL, NULL, NULL),
(5, 'alamat_company', 'Jalan Kavling PGRI XIII No. 133', 'alamat company profile', 1, 1, '2021-07-23 22:25:18', NULL, NULL, NULL, NULL),
(6, 'tagline_company', 'Authentic and innovative.<br>\r\nBuilt to the smallest detail<br>\r\n with a focus on usability<br>\r\nand performance.', '-', 1, 1, '2021-07-23 22:30:19', 1, '2021-07-23 22:31:27', NULL, NULL),
(7, 'link_facebook', 'https://facebook.com', 'sosial media company', 1, 1, '2021-08-03 15:56:40', 1, '2021-08-24 21:01:54', NULL, NULL),
(8, 'link_twitter', 'https://twitter.com', 'link twitter company', 1, 1, '2021-08-03 15:57:07', NULL, NULL, NULL, NULL),
(9, 'copyright_company', '© 2021 mycapturer', 'teks untuk copyright company', 1, 1, '2021-08-03 16:20:46', 1, '2021-08-17 18:13:34', NULL, NULL),
(10, 'company_introduction', 'aspojd', 'muncul di halaman company profile ', 1, 1, '2021-08-17 17:48:14', 1, '2021-08-20 19:51:44', NULL, NULL),
(11, 'company_introduction2', 'It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged.', 'company intro 2', 1, 1, '2021-08-17 17:52:02', NULL, NULL, NULL, NULL),
(12, 'map_location', 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3966.5825654928303!2d106.99102731476897!3d-6.186577495521219!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e698baef215dd71:0xcd91b4e769dd0b25!2sAU+ Production!5e0!3m2!1sid!2sid!4v1626954808119!5m2!1sid!2sid', 'location untuk ifram google maps', 1, 1, '2021-08-17 18:46:43', NULL, NULL, NULL, NULL),
(13, 'phone_description', 'We answer by phone from Monday to Saturday from 10 am until 6 pm.', 'deskripsi pada halaman contact', 1, 1, '2021-08-17 18:59:00', NULL, NULL, NULL, NULL),
(14, 'mail_description', 'We will respond to your email within 8 hours on business days.', 'deskripsi pada halaman contact', 1, 1, '2021-08-17 18:59:00', NULL, NULL, NULL, NULL),
(15, 'alamat_description', 'Come visit us from Monday to Friday from 11 am to 4 pm.', 'deskripsi pada halaman contact', 1, 1, '2021-08-17 18:59:00', NULL, NULL, NULL, NULL),
(16, 'yandex_verification', '529a67773c3dff06', 'meta tag html', 1, 1, '2021-08-24 18:59:58', NULL, NULL, NULL, NULL),
(17, 'meta_description', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book', 'meta tag html', 1, 1, '2021-08-24 19:54:22', NULL, NULL, NULL, NULL),
(18, 'link_instagram', 'https://instagram.com/', 'sosial media company', 1, 1, '2021-08-24 21:02:32', NULL, NULL, NULL, NULL),
(19, 'link_twitter', 'https://twitter.com/', 'sosial media company', 1, 1, '2021-08-24 21:03:09', NULL, NULL, NULL, NULL),
(20, 'link_youtube', 'https://youtube.com/', 'sosial media company', 1, 1, '2021-08-24 21:07:22', NULL, NULL, NULL, NULL),
(21, 'google_site_verification', 'awfic_DBa2Yeg1YLvBo2CLD6oe1TmFEMUNzCRrcnTnU', 'meta tag html', 1, 1, '2021-08-24 23:49:05', NULL, NULL, NULL, NULL);
