
-- --------------------------------------------------------

--
-- Structure for view `sys_menu_group_select`
--
DROP TABLE IF EXISTS `sys_menu_group_select`;

DROP VIEW IF EXISTS `sys_menu_group_select`;
CREATE OR REPLACE ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `sys_menu_group_select`  AS SELECT `sys_menu_group`.`id` AS `id`, `sys_menu_group`.`nama` AS `nama`, `sys_menu_group`.`stat` AS `stat`, `sys_menu_group`.`description` AS `description`, `sys_menu_group`.`order_no` AS `order_no` FROM `sys_menu_group` WHERE (`sys_menu_group`.`stat` = 1) ;
