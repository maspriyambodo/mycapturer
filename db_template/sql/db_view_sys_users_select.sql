
-- --------------------------------------------------------

--
-- Structure for view `sys_users_select`
--
DROP TABLE IF EXISTS `sys_users_select`;

DROP VIEW IF EXISTS `sys_users_select`;
CREATE OR REPLACE ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `sys_users_select`  AS SELECT `sys_users`.`id` AS `id_user`, `sys_users`.`uname` AS `uname`, `sys_users`.`role_id` AS `role_id`, `sys_users`.`pict` AS `pict`, `sys_users`.`stat` AS `stat`, `sys_roles`.`name` AS `role_name`, `sys_roles`.`parent_id` AS `parent_id` FROM (`sys_users` join `sys_roles` on((`sys_users`.`role_id` = `sys_roles`.`id`))) ;
