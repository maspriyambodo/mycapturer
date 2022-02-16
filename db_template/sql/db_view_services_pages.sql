
-- --------------------------------------------------------

--
-- Structure for view `services_pages`
--
DROP TABLE IF EXISTS `services_pages`;

DROP VIEW IF EXISTS `services_pages`;
CREATE OR REPLACE ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `services_pages`  AS SELECT `dt_post`.`id` AS `id_post`, `dt_services`.`nama` AS `post_title`, `sys_users`.`uname` AS `uname`, `dt_post`.`syscreatedate` AS `syscreatedate`, `dt_post`.`viewers` AS `viewers`, `sys_users`.`id` AS `id_user`, `dt_post`.`post_status` AS `post_status` FROM ((`dt_post` left join `dt_services` on((`dt_post`.`post_title` = `dt_services`.`id`))) join `sys_users` on((`dt_post`.`syscreateuser` = `sys_users`.`id`))) WHERE (`dt_post`.`post_status` = 4) ;
