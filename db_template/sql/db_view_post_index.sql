
-- --------------------------------------------------------

--
-- Structure for view `post_index`
--
DROP TABLE IF EXISTS `post_index`;

DROP VIEW IF EXISTS `post_index`;
CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `post_index`  AS SELECT `dt_post`.`id` AS `id`, substr(`dt_post`.`post_content`,1,50) AS `post_content`, `dt_post`.`post_title` AS `post_title`, `dt_post`.`post_status` AS `post_status`, `dt_post`.`viewers` AS `viewers`, `dt_post`.`comment_status` AS `comment_status`, `dt_post`.`syscreateuser` AS `syscreateuser`, `dt_post`.`syscreatedate` AS `syscreatedate`, `sys_users`.`uname` AS `uname`, `sys_users`.`id` AS `id_user`, `dt_post_category`.`id` AS `id_category`, `dt_post_category`.`category` AS `category` FROM ((`dt_post` left join `sys_users` on((`dt_post`.`syscreateuser` = `sys_users`.`id`))) left join `dt_post_category` on((`dt_post`.`post_category` = `dt_post_category`.`id`))) ORDER BY `dt_post`.`syscreatedate` DESC ;
