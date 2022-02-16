
-- --------------------------------------------------------

--
-- Table structure for table `sys_menu`
--

DROP TABLE IF EXISTS `sys_menu`;
CREATE TABLE `sys_menu` (
  `id` int NOT NULL,
  `menu_parent` int DEFAULT NULL,
  `nama` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `link` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `order_no` int DEFAULT NULL,
  `group_menu` int DEFAULT NULL COMMENT '1. applications\r\n2. report\r\n3. systems',
  `icon` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `description` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  `stat` int DEFAULT NULL,
  `syscreateuser` int DEFAULT NULL,
  `syscreatedate` datetime DEFAULT NULL,
  `sysupdateuser` int DEFAULT NULL,
  `sysupdatedate` datetime DEFAULT NULL,
  `sysdeleteuser` int DEFAULT NULL,
  `sysdeletedate` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

--
-- Dumping data for table `sys_menu`
--

INSERT INTO `sys_menu` (`id`, `menu_parent`, `nama`, `link`, `order_no`, `group_menu`, `icon`, `description`, `stat`, `syscreateuser`, `syscreatedate`, `sysupdateuser`, `sysupdatedate`, `sysdeleteuser`, `sysdeletedate`) VALUES
(1, NULL, 'Dashboard', 'Applications/Dashboard/index/', 100, 1, 'fas fa-tachometer-alt', 'menu default systems', 1, 1, '2021-03-11 04:07:27', 1, '2021-09-12 05:22:21', 0, '2021-07-07 23:54:26'),
(2, NULL, 'Master Wilayah', 'javascrip:;', 102, 1, 'fas fa-globe-asia', NULL, 1, 1, '2021-03-13 12:29:43', 1, '2021-03-13 12:31:06', 0, '0000-00-00 00:00:00'),
(3, NULL, 'Master Country', 'Master/Country/index/', 101, 1, 'fas fa-globe', NULL, 1, 1, '2021-03-13 19:35:02', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(4, 2, 'Provinsi', 'Master/Wilayah/Provinsi/index/', 103, 1, '', NULL, 1, 1, '2021-03-13 12:31:34', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(5, 2, 'Kabupaten', 'Master/Wilayah/Kabupaten/index/', 104, 1, '', NULL, 1, 1, '2021-03-13 19:21:17', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(6, 2, 'Kecamatan', 'Master/Wilayah/Kecamatan/index/', 105, 1, '', NULL, 1, 1, '2021-03-13 19:22:00', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(7, 2, 'Kelurahan', 'Master/Wilayah/Kelurahan/index/', 106, 1, '', NULL, 1, 1, '2021-03-13 19:22:30', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(8, NULL, 'Menu Management', 'Systems/Menu/index/', 300, 2, 'fas fa-bars', NULL, 1, 1, '2021-03-11 04:10:12', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(9, NULL, 'Menu Group', 'Systems/Menu_group/index/', 301, 2, 'fas fa-th-list', NULL, 1, 1, '2021-03-13 20:23:14', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(10, NULL, 'Systems', 'Systems/index/', 303, 2, 'fas fa-cogs', NULL, 1, 1, '2021-03-11 16:05:08', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(11, NULL, 'User Management', 'Systems/Users/index/', 304, 2, 'fas fa-user-cog', NULL, 1, 1, '2021-03-11 15:59:24', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(12, NULL, 'Permissions', 'Systems/Permissions/index/', 305, 2, 'fas fa-key', NULL, 1, 1, '2021-03-11 16:00:24', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(13, NULL, 'Blocked Account', 'Systems/Locked/index/', 306, 2, 'fas fa-lock', NULL, 1, 1, '2021-06-07 11:33:39', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(14, NULL, 'Password Management', 'Applications/Password_management/index/', 107, 1, 'fas fa-key', 'menu untuk aplikasi penyimpanan password', 1, 1, '2021-09-15 14:46:08', NULL, NULL, NULL, NULL),
(15, NULL, 'Parameter', 'Systems/Parameter/index/', 302, 2, 'fas fa-code-branch', 'menu untuk paramete sistem', 1, 1, '2021-11-29 20:11:57', NULL, NULL, NULL, NULL),
(16, NULL, 'Blog', 'Blog/Post/index/', 300, 3, 'fas fa-edit', 'Blog management system', 1, 1, '2022-02-16 20:25:16', NULL, NULL, NULL, NULL),
(17, NULL, 'Categories', 'Blog/Categories/index/', 301, 3, 'fas fa-align-left', 'Blog Category Management', 1, 1, '2022-02-16 20:26:59', NULL, NULL, NULL, NULL),
(18, NULL, 'List Services', 'Compro/Services/List/', 400, 4, 'fas fa-stream', 'service list untuk company profile', 1, 1, '2022-02-16 20:27:53', NULL, NULL, NULL, NULL),
(19, NULL, 'Portfolio Gallery', 'Compro/Gallery/index/', 402, 4, 'fas fa-images', 'gallery management system', 1, 1, '2022-02-16 20:29:07', NULL, NULL, NULL, NULL),
(20, NULL, 'Settings', '#', 403, 4, 'fas fa-tools', 'pengaturan company profile', 1, 1, '2022-02-16 20:33:15', NULL, NULL, NULL, NULL),
(21, 20, 'General', 'Compro/General/index/', 404, 4, '', 'pengaturan general company profile', 1, 1, '2022-02-16 20:33:58', 1, '2022-02-16 20:34:37', NULL, NULL),
(22, NULL, 'Services Page', 'Compro/Services/Pages/', 405, 4, 'far fa-file', 'membuat halaman untuk servis list', 1, 1, '2022-02-16 20:35:26', 1, '2022-02-16 20:36:00', NULL, NULL),
(23, NULL, 'Slider', 'Compro/Slider/index/', 401, 4, 'far fa-images', 'slider homepage compro', 1, 1, '2022-02-16 20:36:37', 1, '2022-02-16 20:37:11', NULL, NULL);
