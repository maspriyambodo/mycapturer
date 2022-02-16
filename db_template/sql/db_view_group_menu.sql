
-- --------------------------------------------------------

--
-- Structure for view `group_menu`
--
DROP TABLE IF EXISTS `group_menu`;

DROP VIEW IF EXISTS `group_menu`;
CREATE OR REPLACE ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `group_menu`  AS SELECT `sys_menu`.`link` AS `link`, `sys_menu`.`stat` AS `stat` FROM `sys_menu` WHERE ((`sys_menu`.`stat` = 1) AND (`sys_menu`.`order_no` like '%00%')) GROUP BY `sys_menu`.`group_menu` ORDER BY `sys_menu`.`order_no` ASC ;
