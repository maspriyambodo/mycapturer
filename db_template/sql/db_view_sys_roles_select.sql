
-- --------------------------------------------------------

--
-- Structure for view `sys_roles_select`
--
DROP TABLE IF EXISTS `sys_roles_select`;

DROP VIEW IF EXISTS `sys_roles_select`;
CREATE OR REPLACE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `sys_roles_select`  AS SELECT `sys_roles`.`id` AS `id_grup`, `sys_roles`.`name` AS `nama_grup`, `sys_roles`.`description` AS `des_grup`, `sys_roles`.`stat` AS `status_grup`, `sys_roles`.`parent_id` AS `parent_id`, (select `child`.`name` from `sys_roles` `child` where (`sys_roles`.`parent_id` = `child`.`id`)) AS `parent_name` FROM (`sys_roles` left join `sys_roles` `t2` on((`t2`.`parent_id` = `sys_roles`.`id`))) GROUP BY `sys_roles`.`id` ;
