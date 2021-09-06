
-- --------------------------------------------------------

--
-- Structure for view `password_management`
--
DROP TABLE IF EXISTS `password_management`;

DROP VIEW IF EXISTS `password_management`;
CREATE OR REPLACE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `password_management`  AS SELECT `dt_pwd`.`id` AS `id`, `sys_users`.`uname` AS `owner`, `dt_pwd`.`link` AS `link`, `dt_pwd`.`uname` AS `username`, `dt_pwd`.`lastcheck` AS `lastcheck`, `dt_pwd`.`note` AS `note`, `dt_pwd`.`status` AS `status_aktif`, `dt_pwd`.`syscreateuser` AS `syscreateuser` FROM (`dt_pwd` left join `sys_users` on((`dt_pwd`.`syscreateuser` = `sys_users`.`id`))) ;
