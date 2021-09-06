
-- --------------------------------------------------------

--
-- Structure for view `group_menu`
--
DROP TABLE IF EXISTS `group_menu`;

DROP VIEW IF EXISTS `group_menu`;
CREATE OR REPLACE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `group_menu`  AS SELECT `sys_menu`.`link` AS `link`, `sys_menu`.`stat` AS `stat` FROM `sys_menu` WHERE (`sys_menu`.`stat` = 1) GROUP BY `sys_menu`.`group_menu` ;
