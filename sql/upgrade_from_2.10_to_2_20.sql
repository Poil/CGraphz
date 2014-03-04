ALTER TABLE `cgraphz`.`config_server` MODIFY collectd_version VARCHAR(16) NULL;

INSERT INTO `cgraphz`.`perm_module` (`id_perm_module`, `module`, `component`, `menu_name`, `menu_order`) VALUES (16, 'dashboard', 'light', NULL, 0);
INSERT INTO `cgraphz`.`perm_module_group` (`id_perm_module_group`, `id_auth_group`, `id_perm_module`) VALUES (16, 1, 16);
