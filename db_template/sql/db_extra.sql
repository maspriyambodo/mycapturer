
--
-- Indexes for dumped tables
--

--
-- Indexes for table `compro_option`
--
ALTER TABLE `compro_option`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`) USING BTREE;

--
-- Indexes for table `dt_notif`
--
ALTER TABLE `dt_notif`
  ADD PRIMARY KEY (`id`) USING BTREE,
  ADD UNIQUE KEY `id` (`id`) USING BTREE,
  ADD KEY `role_id` (`role_id`) USING BTREE,
  ADD KEY `syscreateuser` (`syscreateuser`) USING BTREE;

--
-- Indexes for table `dt_portfolio`
--
ALTER TABLE `dt_portfolio`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `dt_post`
--
ALTER TABLE `dt_post`
  ADD PRIMARY KEY (`id`) USING BTREE,
  ADD UNIQUE KEY `id` (`id`) USING BTREE,
  ADD UNIQUE KEY `post_title` (`post_title`) USING BTREE,
  ADD KEY `syscreateuser` (`syscreateuser`),
  ADD KEY `post_category` (`post_category`);

--
-- Indexes for table `dt_post_category`
--
ALTER TABLE `dt_post_category`
  ADD PRIMARY KEY (`id`) USING BTREE;

--
-- Indexes for table `dt_post_comment`
--
ALTER TABLE `dt_post_comment`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`) USING BTREE,
  ADD KEY `post_id` (`post_id`);

--
-- Indexes for table `dt_post_report`
--
ALTER TABLE `dt_post_report`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`) USING BTREE,
  ADD KEY `id_category` (`id_category`);

--
-- Indexes for table `dt_pwd`
--
ALTER TABLE `dt_pwd`
  ADD PRIMARY KEY (`id`) USING BTREE,
  ADD KEY `id_user` (`id_user`) USING BTREE,
  ADD KEY `syscreateuser` (`syscreateuser`) USING BTREE;

--
-- Indexes for table `dt_services`
--
ALTER TABLE `dt_services`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `dt_subscriber`
--
ALTER TABLE `dt_subscriber`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `dt_users`
--
ALTER TABLE `dt_users`
  ADD PRIMARY KEY (`id`) USING BTREE,
  ADD UNIQUE KEY `id` (`id`) USING BTREE,
  ADD KEY `id_user` (`sys_user_id`) USING BTREE,
  ADD KEY `address_provinsi` (`address_provinsi`) USING BTREE,
  ADD KEY `address_kelurahan` (`address_kelurahan`) USING BTREE,
  ADD KEY `address_kecamatan` (`address_kecamatan`) USING BTREE,
  ADD KEY `address_kabupaten` (`address_kabupaten`) USING BTREE,
  ADD KEY `negara` (`negara`) USING BTREE;

--
-- Indexes for table `mt_country`
--
ALTER TABLE `mt_country`
  ADD PRIMARY KEY (`id`) USING BTREE,
  ADD KEY `code` (`code`) USING BTREE,
  ADD KEY `id` (`id`) USING BTREE;

--
-- Indexes for table `mt_wil_kabupaten`
--
ALTER TABLE `mt_wil_kabupaten`
  ADD PRIMARY KEY (`id_kabupaten`) USING BTREE,
  ADD UNIQUE KEY `id_kabupaten` (`id_kabupaten`) USING BTREE,
  ADD KEY `id_provinsi` (`id_provinsi`) USING BTREE;

--
-- Indexes for table `mt_wil_kecamatan`
--
ALTER TABLE `mt_wil_kecamatan`
  ADD PRIMARY KEY (`id_kecamatan`) USING BTREE,
  ADD UNIQUE KEY `id_kecamatan` (`id_kecamatan`) USING BTREE,
  ADD KEY `id_kabupaten` (`id_kabupaten`) USING BTREE;

--
-- Indexes for table `mt_wil_kelurahan`
--
ALTER TABLE `mt_wil_kelurahan`
  ADD PRIMARY KEY (`id_kelurahan`) USING BTREE,
  ADD UNIQUE KEY `id_kelurahan` (`id_kelurahan`) USING BTREE,
  ADD KEY `id_kecamatan` (`id_kecamatan`) USING BTREE;

--
-- Indexes for table `mt_wil_provinsi`
--
ALTER TABLE `mt_wil_provinsi`
  ADD PRIMARY KEY (`id_provinsi`) USING BTREE,
  ADD UNIQUE KEY `id_provinsi` (`id_provinsi`) USING BTREE;

--
-- Indexes for table `sys_app`
--
ALTER TABLE `sys_app`
  ADD PRIMARY KEY (`favico`) USING BTREE,
  ADD KEY `favico` (`favico`) USING BTREE;

--
-- Indexes for table `sys_menu`
--
ALTER TABLE `sys_menu`
  ADD PRIMARY KEY (`id`) USING BTREE,
  ADD UNIQUE KEY `id` (`id`) USING BTREE,
  ADD KEY `group_menu` (`group_menu`) USING BTREE;

--
-- Indexes for table `sys_menu_group`
--
ALTER TABLE `sys_menu_group`
  ADD PRIMARY KEY (`id`) USING BTREE,
  ADD UNIQUE KEY `id` (`id`) USING BTREE;

--
-- Indexes for table `sys_param`
--
ALTER TABLE `sys_param`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`) USING BTREE;

--
-- Indexes for table `sys_permissions`
--
ALTER TABLE `sys_permissions`
  ADD PRIMARY KEY (`id`) USING BTREE,
  ADD UNIQUE KEY `id` (`id`) USING BTREE,
  ADD KEY `sys_permissions_ibfk_1` (`role_id`) USING BTREE,
  ADD KEY `id_menu` (`id_menu`) USING BTREE;

--
-- Indexes for table `sys_roles`
--
ALTER TABLE `sys_roles`
  ADD PRIMARY KEY (`id`) USING BTREE,
  ADD KEY `id` (`id`) USING BTREE;

--
-- Indexes for table `sys_users`
--
ALTER TABLE `sys_users`
  ADD UNIQUE KEY `id` (`id`) USING BTREE,
  ADD UNIQUE KEY `uname` (`uname`) USING BTREE,
  ADD KEY `role_id` (`role_id`) USING BTREE;

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `compro_option`
--
ALTER TABLE `compro_option`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `dt_notif`
--
ALTER TABLE `dt_notif`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `dt_portfolio`
--
ALTER TABLE `dt_portfolio`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `dt_post`
--
ALTER TABLE `dt_post`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- AUTO_INCREMENT for table `dt_post_category`
--
ALTER TABLE `dt_post_category`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=50;

--
-- AUTO_INCREMENT for table `dt_post_comment`
--
ALTER TABLE `dt_post_comment`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `dt_post_report`
--
ALTER TABLE `dt_post_report`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `dt_pwd`
--
ALTER TABLE `dt_pwd`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=242;

--
-- AUTO_INCREMENT for table `dt_services`
--
ALTER TABLE `dt_services`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `dt_subscriber`
--
ALTER TABLE `dt_subscriber`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `dt_users`
--
ALTER TABLE `dt_users`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `mt_country`
--
ALTER TABLE `mt_country`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=250;

--
-- AUTO_INCREMENT for table `sys_menu`
--
ALTER TABLE `sys_menu`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `sys_menu_group`
--
ALTER TABLE `sys_menu_group`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `sys_permissions`
--
ALTER TABLE `sys_permissions`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `sys_roles`
--
ALTER TABLE `sys_roles`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `sys_users`
--
ALTER TABLE `sys_users`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `dt_notif`
--
ALTER TABLE `dt_notif`
  ADD CONSTRAINT `dt_notif_ibfk_1` FOREIGN KEY (`role_id`) REFERENCES `sys_roles` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `dt_notif_ibfk_2` FOREIGN KEY (`syscreateuser`) REFERENCES `dt_users` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Constraints for table `dt_post`
--
ALTER TABLE `dt_post`
  ADD CONSTRAINT `dt_post_ibfk_1` FOREIGN KEY (`syscreateuser`) REFERENCES `sys_users` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `dt_post_ibfk_2` FOREIGN KEY (`post_category`) REFERENCES `dt_post_category` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `dt_post_ibfk_3` FOREIGN KEY (`syscreateuser`) REFERENCES `dt_users` (`sys_user_id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Constraints for table `dt_post_comment`
--
ALTER TABLE `dt_post_comment`
  ADD CONSTRAINT `dt_post_comment_ibfk_1` FOREIGN KEY (`post_id`) REFERENCES `dt_post` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Constraints for table `dt_post_report`
--
ALTER TABLE `dt_post_report`
  ADD CONSTRAINT `dt_post_report_ibfk_1` FOREIGN KEY (`id_category`) REFERENCES `dt_post` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `dt_post_report_ibfk_2` FOREIGN KEY (`id_category`) REFERENCES `dt_post_comment` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Constraints for table `dt_pwd`
--
ALTER TABLE `dt_pwd`
  ADD CONSTRAINT `dt_pwd_ibfk_1` FOREIGN KEY (`syscreateuser`) REFERENCES `sys_users` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Constraints for table `dt_users`
--
ALTER TABLE `dt_users`
  ADD CONSTRAINT `dt_users_ibfk_1` FOREIGN KEY (`sys_user_id`) REFERENCES `sys_users` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `dt_users_ibfk_2` FOREIGN KEY (`address_provinsi`) REFERENCES `mt_wil_provinsi` (`id_provinsi`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `dt_users_ibfk_3` FOREIGN KEY (`address_kelurahan`) REFERENCES `mt_wil_kelurahan` (`id_kelurahan`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `dt_users_ibfk_4` FOREIGN KEY (`address_kecamatan`) REFERENCES `mt_wil_kecamatan` (`id_kecamatan`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `dt_users_ibfk_5` FOREIGN KEY (`address_kabupaten`) REFERENCES `mt_wil_kabupaten` (`id_kabupaten`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `dt_users_ibfk_6` FOREIGN KEY (`negara`) REFERENCES `mt_country` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Constraints for table `mt_wil_kabupaten`
--
ALTER TABLE `mt_wil_kabupaten`
  ADD CONSTRAINT `mt_wil_kabupaten_ibfk_1` FOREIGN KEY (`id_provinsi`) REFERENCES `mt_wil_provinsi` (`id_provinsi`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Constraints for table `mt_wil_kecamatan`
--
ALTER TABLE `mt_wil_kecamatan`
  ADD CONSTRAINT `mt_wil_kecamatan_ibfk_1` FOREIGN KEY (`id_kabupaten`) REFERENCES `mt_wil_kabupaten` (`id_kabupaten`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Constraints for table `mt_wil_kelurahan`
--
ALTER TABLE `mt_wil_kelurahan`
  ADD CONSTRAINT `mt_wil_kelurahan_ibfk_1` FOREIGN KEY (`id_kecamatan`) REFERENCES `mt_wil_kecamatan` (`id_kecamatan`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Constraints for table `sys_menu`
--
ALTER TABLE `sys_menu`
  ADD CONSTRAINT `sys_menu_ibfk_1` FOREIGN KEY (`group_menu`) REFERENCES `sys_menu_group` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Constraints for table `sys_permissions`
--
ALTER TABLE `sys_permissions`
  ADD CONSTRAINT `sys_permissions_ibfk_1` FOREIGN KEY (`role_id`) REFERENCES `sys_roles` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `sys_permissions_ibfk_2` FOREIGN KEY (`id_menu`) REFERENCES `sys_menu` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Constraints for table `sys_users`
--
ALTER TABLE `sys_users`
  ADD CONSTRAINT `sys_users_ibfk_1` FOREIGN KEY (`role_id`) REFERENCES `sys_roles` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;
