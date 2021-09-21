
DELIMITER $$
--
-- Procedures
--
DROP PROCEDURE IF EXISTS `group_menu`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `group_menu` ()  BEGIN
SELECT link FROM group_menu;
END$$

DROP PROCEDURE IF EXISTS `mt_country`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `mt_country` (IN `param` VARCHAR(50), IN `country_id` INT, IN `kode_negara` VARCHAR(2), IN `nama_negara` VARCHAR(45), IN `bendera` VARCHAR(50), IN `user_login` INT)  BEGIN
IF param = 'select' THEN
	
	SELECT  mt_country.id AS id_country, mt_country.`code` AS code_country, mt_country.country AS nama_country, mt_country.stat, mt_country.flags
	FROM mt_country
	WHERE mt_country.stat = 1;

ELSEIF param = 'insert' THEN

	INSERT INTO mt_country
	(
		mt_country.`code`,
		mt_country.country,
		mt_country.flags,
		mt_country.stat,
		mt_country.syscreateuser,
		mt_country.syscreatedate
	)
	VALUES
	(
		kode_negara,
		nama_negara,
		bendera,
		1,
		user_login,
		NOW()
	);

ELSEIF param = 'get_code' THEN

SELECT COUNT(mt_country.id) AS total FROM mt_country WHERE mt_country.`code` = kode_negara;

ELSEIF param = 'get_detail' THEN

SELECT  mt_country.`code` AS code_country, mt_country.country AS nama_country, mt_country.flags
FROM mt_country
WHERE mt_country.id = country_id;

ELSEIF param = 'update' THEN

UPDATE mt_country
SET mt_country.`code`= kode_negara, 
mt_country.country = nama_negara, 
mt_country.flags = bendera,
mt_country.sysupdateuser = user_login, 
mt_country.sysupdatedate = NOW()
WHERE mt_country.id = country_id;

ELSE

	UPDATE mt_country
	SET mt_country.stat = 0,
	mt_country.sysdeleteuser = user_login,
	mt_country.sysdeletedate = NOW()
	WHERE mt_country.id = country_id;
	
END IF;

END$$

DROP PROCEDURE IF EXISTS `mt_will_kab`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `mt_will_kab` (IN `param` VARCHAR(10), IN `kab_id` CHAR(2), IN `nama_kab` TINYTEXT, IN `lat` DOUBLE, IN `longtitut` DOUBLE, IN `user_login` INT)  BEGIN
	IF param = 'select' THEN
		
		SELECT mt_wil_kabupaten.id_kabupaten
		FROM mt_wil_kabupaten
		ORDER BY mt_wil_kabupaten.id_kabupaten ASC;
		
	END IF;

END$$

DROP PROCEDURE IF EXISTS `mt_will_prov`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `mt_will_prov` (IN `param` VARCHAR(10), IN `prov_id` CHAR(2), IN `nama_prov` TINYTEXT, IN `lat` DOUBLE, IN `longtitut` DOUBLE, IN `user_login` INT)  BEGIN

	IF param = 'select' THEN
	
	SELECT mt_wil_provinsi.id_provinsi, 
	mt_wil_provinsi.nama AS nama_prov, 
	mt_wil_provinsi.is_actived AS stat_aktif, 
	mt_wil_provinsi.latitude AS lat, 
	mt_wil_provinsi.longitude AS ltd
	FROM mt_wil_provinsi
	ORDER BY mt_wil_provinsi.id_provinsi;
	
	ELSEIF param = 'detail' THEN
	
	SELECT mt_wil_provinsi.id_provinsi, 
	mt_wil_provinsi.nama AS nama_prov, 
	mt_wil_provinsi.is_actived AS stat_aktif, 
	mt_wil_provinsi.latitude AS lat, 
	mt_wil_provinsi.longitude AS ltd
	FROM mt_wil_provinsi
	WHERE mt_wil_provinsi.id_provinsi = prov_id;
	
	ELSEIF param = 'update' THEN
	
	UPDATE mt_wil_provinsi
	SET mt_wil_provinsi.nama =  nama_prov,
	mt_wil_provinsi.latitude = lat,
	mt_wil_provinsi.longitude = longtitut,
	mt_wil_provinsi.sysupdateuser = user_login,
	mt_wil_provinsi.sysupdatedate = NOW()
	WHERE mt_wil_provinsi.id_provinsi = prov_id;
	
	ELSEIF param = 'Get_id' THEN
	
	SELECT COUNT(mt_wil_provinsi.id_provinsi) AS total
	FROM mt_wil_provinsi
	WHERE mt_wil_provinsi.id_provinsi = prov_id;
	
	ELSEIF param = 'insert' THEN
	
	INSERT INTO mt_wil_provinsi
	(
		mt_wil_provinsi.id_provinsi,
		mt_wil_provinsi.nama,
		mt_wil_provinsi.latitude,
		mt_wil_provinsi.longitude,
		mt_wil_provinsi.is_actived,
		mt_wil_provinsi.syscreateuser,
		mt_wil_provinsi.syscreatedate
	)
	VALUES
	(
		prov_id,
		nama_prov,
		lat,
		longtitut,
		1,
		user_login,
		NOW()
	);
	
	ELSEIF param = 'Set_active' THEN
	
	UPDATE mt_wil_provinsi
	SET mt_wil_provinsi.is_actived = 1,
	mt_wil_provinsi.syscreateuser = user_login,
	mt_wil_provinsi.sysupdatedate = NOW()
	WHERE mt_wil_provinsi.id_provinsi = prov_id;
	
ELSE
	
	UPDATE mt_wil_provinsi
	SET mt_wil_provinsi.is_actived = 0,
					mt_wil_provinsi.sysdeleteuser = user_login,
					mt_wil_provinsi.sysdeletedate = NOW()
	WHERE mt_wil_provinsi.id_provinsi = prov_id;
	
END IF;

END$$

DROP PROCEDURE IF EXISTS `sys_app_select`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `sys_app_select` ()  BEGIN
	
	SELECT
		`sys_app_select`.`favico`,
		`sys_app_select`.`logo`,
		`sys_app_select`.`company_name`,
		`sys_app_select`.`app_name`,
		`sys_app_select`.`app_year`
	FROM sys_app_select;
	
END$$

DROP PROCEDURE IF EXISTS `sys_auth`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `sys_auth` (IN `usernama` VARCHAR(100))  BEGIN

	SELECT
	`sys_auth`.`id_user`,
	`sys_auth`.`uname`,
	`sys_auth`.`pwd`,
	`sys_auth`.`pict`,
	`sys_auth`.`stat_aktif`,
	`sys_auth`.`role_id`,
	`sys_auth`.`role_stat`,
	`sys_auth`.`role_name`,
	`sys_auth`.`fullname`,
	`sys_auth`.`last_login`,
	`sys_auth`.`ip_address`,
	`sys_auth`.`limit_login` 
	FROM sys_auth
	WHERE sys_auth.uname = usernama 
	AND sys_auth.stat_aktif = 1
	AND sys_auth.role_stat = 1
	OR sys_auth.mail = usernama
	AND sys_auth.stat_aktif = 1
	AND sys_auth.role_stat = 1;
	
END$$

DROP PROCEDURE IF EXISTS `sys_menu_active`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `sys_menu_active` (IN `id_menu` INT, IN `user_login` INT)  BEGIN

DECLARE menu_nama VARCHAR(50);
SELECT sys_menu.nama INTO menu_nama FROM sys_menu WHERE sys_menu.id = id_menu;
UPDATE sys_menu 
SET sys_menu.stat = 1, 
	sys_menu.sysdeleteuser = user_login, 
	sys_menu.sysdeletedate = NOW()
WHERE sys_menu.id = id_menu OR sys_menu.menu_parent = id_menu;
SELECT menu_nama;
END$$

DROP PROCEDURE IF EXISTS `sys_menu_delete`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `sys_menu_delete` (IN `id_menu` INT, IN `user_login` INT)  BEGIN

DECLARE menu_nama VARCHAR(50);
SELECT sys_menu.nama INTO menu_nama FROM sys_menu WHERE sys_menu.id = id_menu;
UPDATE sys_menu 
SET sys_menu.stat = 0, 
	sys_menu.sysdeleteuser = user_login, 
	sys_menu.sysdeletedate = NOW()
WHERE sys_menu.id = id_menu OR sys_menu.menu_parent = id_menu;
SELECT menu_nama;
END$$

DROP PROCEDURE IF EXISTS `sys_menu_dir`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `sys_menu_dir` ()  BEGIN
SELECT * FROM sys_menu_select
GROUP BY sys_menu_select.id_menu
ORDER BY sys_menu_select.order_no ASC;
END$$

DROP PROCEDURE IF EXISTS `sys_menu_getorder`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `sys_menu_getorder` (IN `user_role` INT, IN `menu_grup` INT)  BEGIN

SELECT sys_menu_select.order_no, sys_menu_select.nama_menu
FROM sys_menu_select
WHERE sys_menu_select.stat_menu = 1
AND sys_menu_select.role_id = user_role
AND sys_menu_select.id_group_menu = menu_grup
GROUP BY sys_menu_select.order_no
ORDER BY sys_menu_select.order_no, sys_menu_select.id_group_menu ASC;

END$$

DROP PROCEDURE IF EXISTS `sys_menu_group`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `sys_menu_group` (IN `param` VARCHAR(50), IN `id_grup` INT, IN `nama_group` VARCHAR(255), IN `deskripsi` VARCHAR(255), IN `no_order` INT, IN `user_login` INT)  BEGIN

IF param = 'check_nama' THEN

	SELECT COUNT(sys_menu_group.id) AS total
	FROM sys_menu_group
	WHERE sys_menu_group.nama = nama_group;
	
ELSEIF param = 'insert_baru' THEN

	UPDATE `sys_menu_group` 
	SET `sys_menu_group`.`order_no` = `order_no` + 1 
	WHERE `sys_menu_group`.`order_no` >= no_order
	AND `sys_menu_group`.`order_no` != 999;

	INSERT INTO sys_menu_group (
		`sys_menu_group`.`nama`, 
		`sys_menu_group`.`description`,
		`sys_menu_group`.`order_no`,
		`sys_menu_group`.`stat`, 
		`sys_menu_group`.`syscreateuser`, 
		`sys_menu_group`.`syscreatedate`
	)
	VALUES (
		nama_group,
		deskripsi,
		no_order,
		1,
		user_login,
		NOW()
	);
	
ELSEIF param = 'edit' THEN

	UPDATE sys_menu_group
	SET sys_menu_group.nama = nama_group, 
	sys_menu_group.description = deskripsi, 
	sys_menu_group.sysupdateuser = user_login, 
	sys_menu_group.sysupdatedate = NOW()
	WHERE sys_menu_group.id = id_grup;
	
ELSEIF param = 'set_active' THEN

	UPDATE sys_menu_group
	SET sys_menu_group.stat = 1,
	sys_menu_group.sysdeleteuser = user_login, 
	sys_menu_group.sysdeletedate = NOW()
	WHERE sys_menu_group.id = id_grup;
	
	ELSEIF param = 'get_detail' THEN
	
	SELECT sys_menu_group.id, sys_menu_group.nama AS nama_grup, sys_menu_group.description
	FROM sys_menu_group
	WHERE sys_menu_group.id = id_grup;
	
ELSE
	
	UPDATE sys_menu_group
	SET sys_menu_group.stat = 0,
	sys_menu_group.sysdeleteuser = user_login, 
	sys_menu_group.sysdeletedate = NOW()
	WHERE sys_menu_group.id = id_grup;
	
END IF;

END$$

DROP PROCEDURE IF EXISTS `sys_menu_group_reorder`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `sys_menu_group_reorder` (IN `old_id` INT, IN `old_order` INT, IN `new_id` INT, IN `new_order` INT)  BEGIN

	UPDATE sys_menu_group
	SET order_no = new_order
	WHERE sys_menu_group.id = old_id;
	
	UPDATE sys_menu_group
	SET order_no = old_order
	WHERE sys_menu_group.id = new_id;

END$$

DROP PROCEDURE IF EXISTS `sys_menu_group_select`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `sys_menu_group_select` ()  BEGIN
	SELECT * 
	FROM sys_menu_group_select
	ORDER BY sys_menu_group_select.order_no ASC;
END$$

DROP PROCEDURE IF EXISTS `sys_menu_insert`$$
CREATE DEFINER=`admin`@`%` PROCEDURE `sys_menu_insert` (IN `parent` INT, IN `nama_menu` VARCHAR(50), IN `link_menu` VARCHAR(255), IN `no_order` INT, IN `gr_menu` INT, IN `ico_menu` VARCHAR(50), IN `desc_txt` VARCHAR(255), IN `user_login` INT)  BEGIN
	DECLARE
		new_id_menu INT DEFAULT 0;
	DECLARE
		sys_roles_id INT DEFAULT 0;
	DECLARE
		i INT DEFAULT 0;
	DECLARE
		pref_order INT DEFAULT 0;
	SELECT
		COUNT( sys_menu.id ) AS total INTO pref_order 
	FROM
		sys_menu 
	WHERE
		sys_menu.order_no = no_order;
	IF
		pref_order <> 0 THEN
			UPDATE sys_menu 
			SET sys_menu.order_no = sys_menu.order_no + 1 
		WHERE
			sys_menu.order_no > no_order - 1 
			AND sys_menu.group_menu = gr_menu;
		
	END IF;
	INSERT INTO `sys_menu` (
		sys_menu.menu_parent,
		sys_menu.nama,
		sys_menu.link,
		sys_menu.order_no,
		sys_menu.group_menu,
		sys_menu.icon,
		sys_menu.description,
		sys_menu.stat,
		sys_menu.syscreateuser,
		sys_menu.syscreatedate 
	)
	VALUES
		( parent, nama_menu, link_menu, no_order, gr_menu, ico_menu, desc_txt, 1, user_login, NOW() );
	
	SET new_id_menu = LAST_INSERT_ID();
	SELECT
		MAX( id ) INTO sys_roles_id 
	FROM
		sys_roles;
	WHILE
			i < sys_roles_id DO
			INSERT INTO sys_permissions ( role_id, id_menu, v, c, r, u, d, syscreateuser, syscreatedate )
		VALUES
			( i + 1, new_id_menu, 0, 0, 0, 0, 0, user_login, NOW() );
		
		SET i = i + 1;
		
	END WHILE;
	
	UPDATE sys_permissions 
	SET sys_permissions.v = 1,
	sys_permissions.c = 1,
	sys_permissions.r = 1,
	sys_permissions.u = 1,
	sys_permissions.d = 1 
	WHERE
		sys_permissions.id_menu = new_id_menu 
		AND sys_permissions.role_id = 1;
	
END$$

DROP PROCEDURE IF EXISTS `sys_menu_order`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `sys_menu_order` (IN `old_id` INT, IN `old_order` INT, IN `new_id` INT, IN `new_order` INT)  BEGIN
	
	UPDATE sys_menu
	SET order_no = new_order
	WHERE sys_menu.id = old_id;
	
	UPDATE sys_menu
	SET order_no = old_order
	WHERE sys_menu.id = new_id;
	
END$$

DROP PROCEDURE IF EXISTS `sys_menu_select`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `sys_menu_select` (IN `user_role` INT)  BEGIN

SELECT * FROM sys_menu_select
WHERE sys_menu_select.stat_menu = 1 
AND sys_menu_select.`view` = 1 
AND sys_menu_select.role_id = user_role
ORDER BY sys_menu_select.group_order ASC,
sys_menu_select.order_no ASC;

END$$

DROP PROCEDURE IF EXISTS `sys_menu_update`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `sys_menu_update` (IN `parent` INT, IN `menu` VARCHAR(50), IN `location` VARCHAR(255), IN `nomor_order` INT, IN `grup` INT, IN `icon_menu` VARCHAR(50), IN `user_login` INT, IN `id_menu` INT, IN `desc_txt` VARCHAR(255), OUT `menu_nama` VARCHAR(50))  BEGIN
SELECT sys_menu.nama INTO menu_nama FROM sys_menu WHERE sys_menu.id = id_menu;
UPDATE sys_menu
SET sys_menu.menu_parent = parent, 
	sys_menu.nama = menu, 
	sys_menu.link = location, 
	sys_menu.order_no = nomor_order, 
	sys_menu.group_menu = grup, 
	sys_menu.icon = icon_menu, 
	sys_menu.sysupdateuser = user_login, 
	sys_menu.sysupdatedate = NOW(),
	sys_menu.description = desc_txt
WHERE sys_menu.id = id_menu;
SELECT menu_nama;
END$$

DROP PROCEDURE IF EXISTS `sys_mt_country`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `sys_mt_country` (IN `param` VARCHAR(50), IN `country_id` INT, IN `kode_negara` VARCHAR(2), IN `nama_negara` VARCHAR(45), IN `bendera` VARCHAR(50), IN `user_login` INT)  BEGIN
IF param = 'select' THEN
	
	SELECT  mt_country.id AS id_country, mt_country.`code` AS code_country, mt_country.country AS nama_country
	FROM mt_country;
	
ELSE

	UPDATE mt_country
	SET mt_country.stat = 0,
	mt_country.sysdeleteuser = user_login,
	mt_country.sysdeletedate = NOW()
	WHERE mt_country.id = country_id;
	
END IF;

END$$

DROP PROCEDURE IF EXISTS `sys_permision_update`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `sys_permision_update` (IN `id_role` INT, IN `menu_id` INT, IN `lihat` INT, IN `buat` INT, IN `baca` INT, IN `ubah` INT, IN `hapus` INT, IN `user_login` INT)  BEGIN

UPDATE `sys_permissions`
SET 
	sys_permissions.v = lihat, 
	sys_permissions.c = buat, 
	sys_permissions.r = baca, 
	sys_permissions.u = ubah, 
	sys_permissions.d = hapus, 
	sys_permissions.sysupdateuser = user_login,
	sys_permissions.sysupdatedate = NOW()
WHERE
sys_permissions.role_id = id_role AND sys_permissions.id_menu = menu_id;

END$$

DROP PROCEDURE IF EXISTS `sys_permission_select`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `sys_permission_select` (IN `permisi_id` INT)  BEGIN
SELECT `sys_menu_select`.`id_menu`,
`sys_menu_select`.`nama_menu`,
`sys_menu_select`.`grup_nama`,
`sys_menu_select`.`view`, `sys_menu_select`.`create`,
`sys_menu_select`.`read`, `sys_menu_select`.`update`, `sys_menu_select`.`delete`
FROM sys_menu_select 
WHERE `sys_menu_select`.`role_id` = permisi_id
GROUP BY sys_menu_select.id_menu;
END$$

DROP PROCEDURE IF EXISTS `sys_roles_insert`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `sys_roles_insert` (IN `nama` VARCHAR(30), IN `deskripsi` VARCHAR(255), IN `group_parent` INT, IN `user_id` INT)  BEGIN
	DECLARE role_id_new int DEFAULT 0;
	DECLARE id_menu int DEFAULT 0;
	DECLARE i int DEFAULT 0;
INSERT INTO `sys_roles`(
	sys_roles.`name`, 
	sys_roles.description, 
	sys_roles.stat, 
	sys_roles.parent_id,
	sys_roles.syscreateuser, 
	sys_roles.syscreatedate
)
VALUES(
	nama,
	deskripsi,
	1,
	group_parent,
	user_id,
	NOW()
);
SET role_id_new = LAST_INSERT_ID();

SELECT MAX(id) INTO id_menu FROM sys_menu;
WHILE i < id_menu  DO

	INSERT INTO sys_permissions (
		role_id,id_menu,v,c,r,u,d,syscreateuser,syscreatedate
	)
	VALUES(
		role_id_new,
		i+1,
		0,0,0,0,0,
		user_id,
		NOW()
	);
	SET i = i + 1;
END WHILE;

END$$

DROP PROCEDURE IF EXISTS `sys_roles_select`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `sys_roles_select` (IN `grup_id` INT)  BEGIN
IF grup_id = 0 THEN
	SELECT * FROM sys_roles_select WHERE status_grup = 1;
ELSE
	SELECT * FROM sys_roles_select WHERE id_grup = grup_id AND status_grup = 1;
END IF;
END$$

DROP PROCEDURE IF EXISTS `sys_roles_update`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `sys_roles_update` (IN `id_grup` INT, IN `nama_grup` VARCHAR(30), IN `des_grup` VARCHAR(255), IN `user_login` INT, IN `id_parent` INT)  BEGIN
UPDATE sys_roles 
SET
	sys_roles.`name` = nama_grup, 
	sys_roles.description = des_grup, 
    sys_roles.parent_id = id_parent, 
	sys_roles.sysupdateuser = user_login, 
	sys_roles.sysupdatedate = NOW()
WHERE sys_roles.id = id_grup;
END$$

DROP PROCEDURE IF EXISTS `sys_users_insert`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `sys_users_insert` (IN `user_name` VARCHAR(100), IN `pass_word` VARCHAR(100), IN `id_role` INT, IN `avatar` VARCHAR(100), IN `status_active` INT, IN `user_login` INT)  BEGIN

IF pass_word = 'update' THEN

	UPDATE sys_users
	SET sys_users.uname = user_name,
	sys_users.role_id = id_role,
	sys_users.pict = avatar,
	sys_users.sysupdateuser = user_login,
	sys_users.sysupdatedate = NOW()
	WHERE sys_users.id = status_active;
	
ELSE
	
	INSERT INTO `sys_users`(
	sys_users.uname, 
	sys_users.pwd, 
	sys_users.role_id, 
	sys_users.pict, 
	sys_users.stat, 
	sys_users.syscreateuser,
	sys_users.syscreatedate
)
	VALUES(
	user_name,
	pass_word,
	id_role,
	avatar,
	status_active,
	user_login,
	NOW()
);

INSERT INTO `dt_users`(
dt_users.sys_user_id,
dt_users.stat,
dt_users.syscreatedate,
dt_users.syscreateuser
)
VALUES(
LAST_INSERT_ID(),
1,
NOW(),
user_login
);

END IF;
END$$

DROP PROCEDURE IF EXISTS `sys_users_select`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `sys_users_select` (IN `param` VARCHAR(50), IN `user_id` INT, IN `panjang` INT, IN `mulai` INT)  BEGIN

IF param = 'get_detail' THEN

	SELECT sys_users_select.id_user, 
								sys_users_select.uname, 
								sys_users_select.role_id, 
								sys_users_select.pict
	FROM sys_users_select
	WHERE sys_users_select.id_user = user_id;
	
	ELSEIF param = 'count_all' THEN
	
	SELECT COUNT(sys_users.id) AS tot FROM sys_users;
	
ELSE

	SELECT * 
	FROM sys_users_select
	WHERE sys_users_select.id_user = user_id
	OR sys_users_select.parent_id = user_id;
	
END IF;

END$$

DROP PROCEDURE IF EXISTS `sys_users_stat`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `sys_users_stat` (IN `id_user` INT, IN `user_login` INT, IN `stat_active` INT)  BEGIN
UPDATE sys_users
SET sys_users.stat = stat_active, 
	sys_users.sysdeleteuser = user_login, 
	sys_users.sysdeletedate = NOW()
WHERE sys_users.id = id_user;
END$$

DELIMITER ;
