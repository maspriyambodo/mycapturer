
-- --------------------------------------------------------

--
-- Structure for view `sys_menu_select`
--
DROP TABLE IF EXISTS `sys_menu_select`;

DROP VIEW IF EXISTS `sys_menu_select`;
CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `sys_menu_select`  AS SELECT `sys_menu`.`id` AS `id_menu`, `sys_menu`.`menu_parent` AS `id_parent`, (select `child`.`nama` from `sys_menu` `child` where (`sys_menu`.`menu_parent` = `child`.`id`)) AS `parent_name`, `sys_menu`.`nama` AS `nama_menu`, `sys_menu`.`link` AS `link`, `sys_menu`.`order_no` AS `order_no`, `sys_menu`.`icon` AS `icon`, `sys_menu`.`stat` AS `stat_menu`, `sys_menu`.`group_menu` AS `id_group_menu`, `sys_menu`.`description` AS `description`, `sys_menu_group`.`nama` AS `group_menu`, `sys_menu_group`.`order_no` AS `group_order`, `sys_permissions`.`role_id` AS `role_id`, `sys_permissions`.`id` AS `id_permision`, `sys_permissions`.`v` AS `view`, `sys_permissions`.`c` AS `create`, `sys_permissions`.`r` AS `read`, `sys_permissions`.`u` AS `update`, `sys_permissions`.`d` AS `delete`, `sys_roles`.`name` AS `grup_nama` FROM ((((`sys_menu` join `sys_menu_group` on((`sys_menu`.`group_menu` = `sys_menu_group`.`id`))) join `sys_permissions` on((`sys_menu`.`id` = `sys_permissions`.`id_menu`))) join `sys_roles` on((`sys_permissions`.`role_id` = `sys_roles`.`id`))) left join `sys_menu` `t2` on((`t2`.`menu_parent` = `sys_menu`.`id`))) ;
