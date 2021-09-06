
-- --------------------------------------------------------

--
-- Structure for view `sys_auth`
--
DROP TABLE IF EXISTS `sys_auth`;

DROP VIEW IF EXISTS `sys_auth`;
CREATE OR REPLACE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `sys_auth`  AS SELECT `sys_users`.`id` AS `id_user`, `sys_users`.`uname` AS `uname`, `dt_users`.`mail` AS `mail`, `sys_users`.`pwd` AS `pwd`, `sys_users`.`pict` AS `pict`, `sys_users`.`stat` AS `stat_aktif`, `sys_users`.`role_id` AS `role_id`, `sys_roles`.`stat` AS `role_stat`, `sys_roles`.`name` AS `role_name`, `dt_users`.`nama` AS `fullname`, `sys_users`.`last_login` AS `last_login`, `sys_users`.`ip_address` AS `ip_address`, `sys_users`.`login_attempt` AS `limit_login` FROM ((`sys_users` join `sys_roles` on((`sys_users`.`role_id` = `sys_roles`.`id`))) join `dt_users` on((`sys_users`.`id` = `dt_users`.`sys_user_id`))) ;
