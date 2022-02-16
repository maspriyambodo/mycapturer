
-- --------------------------------------------------------

--
-- Table structure for table `sys_param`
--

DROP TABLE IF EXISTS `sys_param`;
CREATE TABLE `sys_param` (
  `id` varchar(32) COLLATE utf8mb4_general_ci NOT NULL,
  `param_group` varchar(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `param_value` varchar(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `param_desc` varchar(128) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `stat` int DEFAULT NULL,
  `syscreateuser` int DEFAULT NULL,
  `syscreatedate` datetime DEFAULT NULL,
  `sysupdateuser` int DEFAULT NULL,
  `sysupdatedate` datetime DEFAULT NULL,
  `sysdeleteuser` int DEFAULT NULL,
  `sysdeletedate` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `sys_param`
--

INSERT INTO `sys_param` (`id`, `param_group`, `param_value`, `param_desc`, `stat`, `syscreateuser`, `syscreatedate`, `sysupdateuser`, `sysupdatedate`, `sysdeleteuser`, `sysdeletedate`) VALUES
('DEFAULT_PASSWORD', 'SYSTEM_PARAM', 'password', 'default password system', 1, 1, '2021-12-08 14:39:44', 1, '2021-12-08 22:18:03', 1, '2021-12-08 22:37:16'),
('SUPER_USER', 'GROUP_LEVEL', '1', 'super user', 1, 1, '2021-12-08 12:20:36', 1, '2021-12-08 23:14:24', NULL, NULL);
