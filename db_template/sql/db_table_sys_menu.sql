
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
  `description` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `stat` int DEFAULT NULL,
  `syscreateuser` int DEFAULT NULL,
  `syscreatedate` datetime DEFAULT NULL,
  `sysupdateuser` int DEFAULT NULL,
  `sysupdatedate` datetime DEFAULT NULL,
  `sysdeleteuser` int DEFAULT NULL,
  `sysdeletedate` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `sys_menu`
--

INSERT INTO `sys_menu` (`id`, `menu_parent`, `nama`, `link`, `order_no`, `group_menu`, `icon`, `description`, `stat`, `syscreateuser`, `syscreatedate`, `sysupdateuser`, `sysupdatedate`, `sysdeleteuser`, `sysdeletedate`) VALUES
(1, NULL, 'Dashboard', 'Applications/Dashboard/index/', 100, 1, 'fas fa-tachometer-alt', NULL, 1, 1, '2021-03-11 04:07:27', 1, '2021-06-22 15:56:16', 0, '2021-07-07 23:54:26'),
(2, NULL, 'Master Wilayah', 'javascrip:;', 103, 1, 'fas fa-globe-asia', NULL, 1, 1, '2021-03-13 12:29:43', 1, '2021-03-13 12:31:06', 0, '0000-00-00 00:00:00'),
(3, NULL, 'Master Country', 'Master/Country/index/', 102, 1, 'fas fa-globe', NULL, 1, 1, '2021-03-13 19:35:02', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(4, 2, 'Provinsi', 'Master/Wilayah/Provinsi/index/', 104, 1, '', NULL, 1, 1, '2021-03-13 12:31:34', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(5, 2, 'Kabupaten', 'Master/Wilayah/Kabupaten/index/', 105, 1, '', NULL, 1, 1, '2021-03-13 19:21:17', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(6, 2, 'Kecamatan', 'Master/Wilayah/Kecamatan/index/', 106, 1, '', NULL, 1, 1, '2021-03-13 19:22:00', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(7, 2, 'Kelurahan', 'Master/Wilayah/Kelurahan/index/', 107, 1, '', NULL, 1, 1, '2021-03-13 19:22:30', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(8, NULL, 'Menu Management', 'Systems/Menu/index/', 300, 2, 'fas fa-bars', NULL, 1, 1, '2021-03-11 04:10:12', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(9, NULL, 'Menu Group', 'Systems/Menu_group/index/', 301, 2, 'fas fa-th-list', NULL, 1, 1, '2021-03-13 20:23:14', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(10, NULL, 'Systems', 'Systems/index/', 302, 2, 'fas fa-cogs', NULL, 1, 1, '2021-03-11 16:05:08', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(11, NULL, 'User Management', 'Systems/Users/index/', 303, 2, 'fas fa-user-cog', NULL, 1, 1, '2021-03-11 15:59:24', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(12, NULL, 'Permissions', 'Systems/Permissions/index/', 304, 2, 'fas fa-key', NULL, 1, 1, '2021-03-11 16:00:24', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(13, NULL, 'Blocked Account', 'Systems/Locked/index/', 305, 2, 'fas fa-lock', NULL, 1, 1, '2021-06-07 11:33:39', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(14, NULL, 'Blog', 'Blog/Post/index/', 300, 3, 'fas fa-edit', NULL, 1, 1, '2021-07-19 18:27:10', NULL, NULL, NULL, NULL),
(15, NULL, 'Categories', 'Blog/Categories/index/', 301, 3, 'fas fa-align-left', NULL, 1, 1, '2021-07-19 18:27:43', NULL, NULL, NULL, NULL),
(16, NULL, 'List Services', 'Compro/Services/List/', 403, 4, 'fas fa-stream', 'service list untuk company profile', 1, 1, '2021-07-19 19:04:08', 1, '2021-08-25 10:16:12', 1, '2021-08-25 09:26:25'),
(17, NULL, 'Portfolio Gallery', 'Compro/Gallery/index/', 400, 4, 'fas fa-images', NULL, 1, 1, '2021-07-19 21:21:32', NULL, NULL, NULL, NULL),
(18, NULL, 'Settings', '#', 401, 4, 'fas fa-tools', NULL, 1, 1, '2021-07-23 13:41:44', 1, '2021-07-23 13:44:07', NULL, NULL),
(19, 18, 'General', 'Compro/General/index/', 405, 4, '', NULL, 1, 1, '2021-07-23 13:45:11', NULL, NULL, NULL, NULL),
(20, NULL, 'Services Page', 'Compro/Services/Pages/', 402, 4, 'far fa-file', 'membuat halaman untuk servis list', 1, 1, '2021-08-25 09:17:25', 1, '2021-08-25 14:03:13', 1, '2021-08-25 11:03:20'),
(21, NULL, 'Slider', 'Compro/Slider/index/', 404, 4, 'far fa-images', 'slider homepage compro', 1, 1, '2021-08-29 17:46:38', NULL, NULL, NULL, NULL),
(22, NULL, 'Password Management', 'Applications/Password_management/index/', 101, 1, 'fas fa-key', 'aplikasi untuk menyimpan kata sandi / password akun', 1, 1, '2021-09-06 10:28:14', NULL, NULL, NULL, NULL);
