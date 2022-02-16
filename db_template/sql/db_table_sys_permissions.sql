
-- --------------------------------------------------------

--
-- Table structure for table `sys_permissions`
--

DROP TABLE IF EXISTS `sys_permissions`;
CREATE TABLE `sys_permissions` (
  `id` int NOT NULL,
  `role_id` int DEFAULT NULL,
  `id_menu` int DEFAULT NULL,
  `v` int DEFAULT NULL COMMENT 'view',
  `c` int DEFAULT NULL COMMENT 'create',
  `r` int DEFAULT NULL COMMENT 'read',
  `u` int DEFAULT NULL COMMENT 'update',
  `d` int DEFAULT NULL COMMENT 'delete',
  `syscreateuser` int DEFAULT NULL,
  `syscreatedate` datetime DEFAULT NULL,
  `sysupdateuser` int DEFAULT NULL,
  `sysupdatedate` datetime DEFAULT NULL,
  `sysdeleteuser` int DEFAULT NULL,
  `sysdeletedate` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

--
-- Dumping data for table `sys_permissions`
--

INSERT INTO `sys_permissions` (`id`, `role_id`, `id_menu`, `v`, `c`, `r`, `u`, `d`, `syscreateuser`, `syscreatedate`, `sysupdateuser`, `sysupdatedate`, `sysdeleteuser`, `sysdeletedate`) VALUES
(1, 1, 1, 1, 1, 1, 1, 1, 1, '2021-01-01 00:00:00', 1, '2021-01-01 00:00:00', 1, '2021-01-01 00:00:00'),
(2, 1, 2, 1, 1, 1, 1, 1, 1, '2021-01-01 00:00:00', 1, '2021-01-01 00:00:00', 1, '2021-01-01 00:00:00'),
(3, 1, 3, 1, 1, 1, 1, 1, 1, '2021-01-01 00:00:00', 1, '2021-01-01 00:00:00', 1, '2021-01-01 00:00:00'),
(4, 1, 4, 1, 1, 1, 1, 1, 1, '2021-01-01 00:00:00', 1, '2021-01-01 00:00:00', 1, '2021-01-01 00:00:00'),
(5, 1, 5, 1, 1, 1, 1, 1, 1, '2021-01-01 00:00:00', 1, '2021-01-01 00:00:00', 1, '2021-01-01 00:00:00'),
(6, 1, 6, 1, 1, 1, 1, 1, 1, '2021-01-01 00:00:00', 1, '2021-01-01 00:00:00', 1, '2021-01-01 00:00:00'),
(7, 1, 7, 1, 1, 1, 1, 1, 1, '2021-01-01 00:00:00', 1, '2021-01-01 00:00:00', 1, '2021-01-01 00:00:00'),
(8, 1, 8, 1, 1, 1, 1, 1, 1, '2021-01-01 00:00:00', 1, '2021-01-01 00:00:00', 1, '2021-01-01 00:00:00'),
(9, 1, 9, 1, 1, 1, 1, 1, 1, '2021-01-01 00:00:00', 1, '2021-01-01 00:00:00', 1, '2021-01-01 00:00:00'),
(10, 1, 10, 1, 1, 1, 1, 1, 1, '2021-01-01 00:00:00', 1, '2021-01-01 00:00:00', 1, '2021-01-01 00:00:00'),
(11, 1, 11, 1, 1, 1, 1, 1, 1, '2021-01-01 00:00:00', 1, '2021-01-01 00:00:00', 1, '2021-01-01 00:00:00'),
(12, 1, 12, 1, 1, 1, 1, 1, 1, '2021-01-01 00:00:00', 1, '2021-01-01 00:00:00', 1, '2021-01-01 00:00:00'),
(13, 1, 13, 1, 1, 1, 1, 1, 1, '2021-01-01 00:00:00', 1, '2021-01-01 00:00:00', 1, '2021-01-01 00:00:00'),
(14, 1, 14, 1, 1, 1, 1, 1, 1, '2021-09-15 14:46:08', NULL, NULL, NULL, NULL),
(15, 1, 15, 1, 1, 1, 1, 1, 1, '2021-11-29 20:11:57', NULL, NULL, NULL, NULL),
(16, 1, 16, 1, 1, 1, 1, 1, 1, '2022-02-16 20:25:16', NULL, NULL, NULL, NULL),
(17, 1, 17, 1, 1, 1, 1, 1, 1, '2022-02-16 20:26:59', NULL, NULL, NULL, NULL),
(18, 1, 18, 1, 1, 1, 1, 1, 1, '2022-02-16 20:27:53', NULL, NULL, NULL, NULL),
(19, 1, 19, 1, 1, 1, 1, 1, 1, '2022-02-16 20:29:07', NULL, NULL, NULL, NULL),
(20, 1, 20, 1, 1, 1, 1, 1, 1, '2022-02-16 20:33:15', NULL, NULL, NULL, NULL),
(21, 1, 21, 1, 1, 1, 1, 1, 1, '2022-02-16 20:33:58', NULL, NULL, NULL, NULL),
(22, 1, 22, 1, 1, 1, 1, 1, 1, '2022-02-16 20:35:26', NULL, NULL, NULL, NULL),
(23, 1, 23, 1, 1, 1, 1, 1, 1, '2022-02-16 20:36:37', NULL, NULL, NULL, NULL);
