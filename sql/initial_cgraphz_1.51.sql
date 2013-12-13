SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL';

CREATE SCHEMA IF NOT EXISTS `cgraphz` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci ;
USE `cgraphz` ;

-- -----------------------------------------------------
-- Table `cgraphz`.`auth_group`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `cgraphz`.`auth_group` (
  `id_auth_group` INT UNSIGNED NOT NULL AUTO_INCREMENT ,
  `group` VARCHAR(45) NOT NULL ,
  `group_description` VARCHAR(45) NULL ,
  PRIMARY KEY (`id_auth_group`) ,
  UNIQUE INDEX `group_UNIQUE` (`group` ASC) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `cgraphz`.`auth_user`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `cgraphz`.`auth_user` (
  `id_auth_user` INT UNSIGNED NOT NULL AUTO_INCREMENT ,
  `nom` VARCHAR(45) NULL ,
  `prenom` VARCHAR(45) NULL ,
  `user` VARCHAR(45) NOT NULL ,
  `mail` VARCHAR(45) NULL ,
  `passwd` VARCHAR(45) NOT NULL ,
  `type` VARCHAR(10) NULL ,
  PRIMARY KEY (`id_auth_user`) ,
  UNIQUE INDEX `ix_au_user_passwd` (`user` ASC, `passwd` ASC) ,
  UNIQUE INDEX `user_UNIQUE` (`user` ASC) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `cgraphz`.`config_server`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `cgraphz`.`config_server` (
  `id_config_server` INT UNSIGNED NOT NULL AUTO_INCREMENT ,
  `server_name` VARCHAR(45) NOT NULL ,
  `server_description` TEXT NULL ,
  `collectd_version` smallint(5) unsigned DEFAULT '5',
  PRIMARY KEY (`id_config_server`) ,
  UNIQUE INDEX `ix_cs_server_name` (`server_name` ASC) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `cgraphz`.`auth_user_group`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `cgraphz`.`auth_user_group` (
  `id_auth_group` INT UNSIGNED NOT NULL ,
  `id_auth_user` INT UNSIGNED NOT NULL ,
  `manager` TINYINT(1) NULL ,
  PRIMARY KEY (`id_auth_group`, `id_auth_user`) ,
  INDEX `fk_aug_id_auth_group` (`id_auth_group` ASC) ,
  INDEX `fk_aug_id_auth_user` (`id_auth_user` ASC) ,
  CONSTRAINT `fk_aug_id_auth_group`
    FOREIGN KEY (`id_auth_group` )
    REFERENCES `cgraphz`.`auth_group` (`id_auth_group` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_aug_id_auth_user`
    FOREIGN KEY (`id_auth_user` )
    REFERENCES `cgraphz`.`auth_user` (`id_auth_user` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `cgraphz`.`config_project`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `cgraphz`.`config_project` (
  `id_config_project` INT UNSIGNED NOT NULL AUTO_INCREMENT ,
  `project` VARCHAR(45) NOT NULL ,
  `project_description` TEXT NULL ,
  PRIMARY KEY (`id_config_project`) ,
  UNIQUE INDEX `ix_cp_project` (`project` ASC) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `cgraphz`.`config_server_project`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `cgraphz`.`config_server_project` (
  `id_config_server` INT UNSIGNED NOT NULL ,
  `id_config_project` INT UNSIGNED NOT NULL ,
  PRIMARY KEY (`id_config_server`, `id_config_project`) ,
  INDEX `fk_csp_id_config_project` (`id_config_project` ASC) ,
  INDEX `fk_csp_id_config_server` (`id_config_server` ASC) ,
  CONSTRAINT `fk_csp_id_config_project`
    FOREIGN KEY (`id_config_project` )
    REFERENCES `cgraphz`.`config_project` (`id_config_project` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_csp_id_config_server`
    FOREIGN KEY (`id_config_server` )
    REFERENCES `cgraphz`.`config_server` (`id_config_server` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `cgraphz`.`perm_project_group`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `cgraphz`.`perm_project_group` (
  `id_auth_group` INT UNSIGNED NOT NULL ,
  `id_config_project` INT UNSIGNED NOT NULL ,
  PRIMARY KEY (`id_auth_group`, `id_config_project`) ,
  INDEX `fk_ppg_id_config_project` (`id_config_project` ASC) ,
  INDEX `fk_ppg_id_auth_group` (`id_auth_group` ASC) ,
  CONSTRAINT `fk_ppg_id_config_project`
    FOREIGN KEY (`id_config_project` )
    REFERENCES `cgraphz`.`config_project` (`id_config_project` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_ppg_id_auth_group`
    FOREIGN KEY (`id_auth_group` )
    REFERENCES `cgraphz`.`auth_group` (`id_auth_group` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `cgraphz`.`perm_module`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `cgraphz`.`perm_module` (
  `id_perm_module` INT UNSIGNED NOT NULL AUTO_INCREMENT ,
  `module` VARCHAR(45) NULL ,
  `component` VARCHAR(45) NULL ,
  `menu_name` VARCHAR(45) NULL ,
  `menu_order` INT NULL ,
  PRIMARY KEY (`id_perm_module`) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `cgraphz`.`perm_module_group`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `cgraphz`.`perm_module_group` (
  `id_perm_module_group` INT UNSIGNED NOT NULL AUTO_INCREMENT ,
  `id_auth_group` INT UNSIGNED NULL ,
  `id_perm_module` INT UNSIGNED NULL ,
  PRIMARY KEY (`id_perm_module_group`) ,
  INDEX `fk_pmg_id_auth_group` (`id_auth_group` ASC) ,
  INDEX `fk_pmg_id_perm_module` (`id_perm_module` ASC) ,
  CONSTRAINT `fk_pmg_id_auth_group`
    FOREIGN KEY (`id_auth_group` )
    REFERENCES `cgraphz`.`auth_group` (`id_auth_group` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_pmg_id_perm_module`
    FOREIGN KEY (`id_perm_module` )
    REFERENCES `cgraphz`.`perm_module` (`id_perm_module` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `cgraphz`.`config_plugin_filter`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `cgraphz`.`config_plugin_filter` (
  `id_config_plugin_filter` INT UNSIGNED NULL AUTO_INCREMENT ,
  `plugin` VARCHAR(45) NOT NULL ,
  `plugin_instance` VARCHAR(45) NULL ,
  `type` VARCHAR(45) NOT NULL ,
  `type_instance` VARCHAR(45) NULL ,
  `plugin_filter_desc` VARCHAR(45) NULL ,
  `plugin_order` INT NULL ,
  PRIMARY KEY (`id_config_plugin_filter`) ,
  UNIQUE INDEX `ix_plugin_filter_desc` (`plugin_filter_desc` ASC) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `cgraphz`.`config_role`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `cgraphz`.`config_role` (
  `id_config_role` INT UNSIGNED NOT NULL AUTO_INCREMENT ,
  `role` VARCHAR(45) NULL ,
  `role_description` VARCHAR(45) NULL ,
  PRIMARY KEY (`id_config_role`) ,
  UNIQUE INDEX `role_UNIQUE` (`role` ASC) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `cgraphz`.`config_role_server`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `cgraphz`.`config_role_server` (
  `id_config_role` INT UNSIGNED NOT NULL ,
  `id_config_server` INT UNSIGNED NOT NULL ,
  INDEX `fk_crs_id_config_role` (`id_config_role` ASC) ,
  PRIMARY KEY (`id_config_role`, `id_config_server`) ,
  INDEX `fk_crs_id_config_server` (`id_config_server` ASC) ,
  CONSTRAINT `fk_crs_id_config_role`
    FOREIGN KEY (`id_config_role` )
    REFERENCES `cgraphz`.`config_role` (`id_config_role` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_crs_id_config_server`
    FOREIGN KEY (`id_config_server` )
    REFERENCES `cgraphz`.`config_server` (`id_config_server` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `cgraphz`.`config_plugin_filter_group`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `cgraphz`.`config_plugin_filter_group` (
  `id_config_plugin_filter` INT UNSIGNED NOT NULL ,
  `id_auth_group` INT UNSIGNED NOT NULL ,
  PRIMARY KEY (`id_config_plugin_filter`, `id_auth_group`) ,
  INDEX `fk_cpfg_id_auth_group` (`id_auth_group` ASC) ,
  CONSTRAINT `fk_cpfg_id_config_plugin_filter`
    FOREIGN KEY (`id_config_plugin_filter` )
    REFERENCES `cgraphz`.`config_plugin_filter` (`id_config_plugin_filter` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_cpfg_id_auth_group`
    FOREIGN KEY (`id_auth_group` )
    REFERENCES `cgraphz`.`auth_group` (`id_auth_group` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `cgraphz`.`config_environment`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `cgraphz`.`config_environment` (
  `id_config_environment` INT UNSIGNED NOT NULL AUTO_INCREMENT ,
  `environment` VARCHAR(45) NULL ,
  `environment_description` VARCHAR(45) NULL ,
  PRIMARY KEY (`id_config_environment`) ,
  UNIQUE INDEX `environment_UNIQUE` (`environment` ASC) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `cgraphz`.`config_environment_server`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `cgraphz`.`config_environment_server` (
  `id_config_environment` INT UNSIGNED NOT NULL ,
  `id_config_server` INT UNSIGNED NOT NULL ,
  PRIMARY KEY (`id_config_environment`, `id_config_server`) ,
  INDEX `fk_ces_id_config_environnement` (`id_config_environment` ASC) ,
  INDEX `fk_ces_id_config_server` (`id_config_server` ASC) ,
  CONSTRAINT `fk_ces_id_config_environnement`
    FOREIGN KEY (`id_config_environment` )
    REFERENCES `cgraphz`.`config_environment` (`id_config_environment` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_ces_id_config_server`
    FOREIGN KEY (`id_config_server` )
    REFERENCES `cgraphz`.`config_server` (`id_config_server` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `cgraphz`.`config_dynamic_dashboard`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `cgraphz`.`config_dynamic_dashboard` (
  `id_config_dynamic_dashboard` INT UNSIGNED NOT NULL AUTO_INCREMENT ,
  `title` VARCHAR(45) NOT NULL ,
  PRIMARY KEY (`id_config_dynamic_dashboard`) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `cgraphz`.`config_dynamic_dashboard_content`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `cgraphz`.`config_dynamic_dashboard_content` (
  `id_config_dynamic_dashboard_content` INT UNSIGNED NOT NULL AUTO_INCREMENT ,
  `id_config_dynamic_dashboard` INT UNSIGNED NOT NULL ,
  `title` VARCHAR(45) NOT NULL ,
  `dash_ordering` INT NOT NULL ,
  `regex_srv` VARCHAR(255) NOT NULL ,
  `regex_p_filter` VARCHAR(80) NOT NULL ,
  `regex_pi_filter` VARCHAR(80) NOT NULL ,
  `regex_t_filter` VARCHAR(80) NOT NULL ,
  `regex_ti_filter` VARCHAR(80) NOT NULL ,
  `rrd_ordering` VARCHAR(255) NOT NULL ,
  PRIMARY KEY (`id_config_dynamic_dashboard_content`) ,
  INDEX `fk_cddc_id_config_dynamic_content` (`id_config_dynamic_dashboard` ASC) ,
  CONSTRAINT `fk_cddc_id_config_dynamic_content`
    FOREIGN KEY (`id_config_dynamic_dashboard` )
    REFERENCES `cgraphz`.`config_dynamic_dashboard` (`id_config_dynamic_dashboard` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `cgraphz`.`config_dynamic_dashboard_group`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `cgraphz`.`config_dynamic_dashboard_group` (
  `id_config_dynamic_dashboard` INT UNSIGNED NOT NULL ,
  `id_auth_group` INT UNSIGNED NOT NULL ,
  `group_manager` TINYINT(1) NULL DEFAULT 0 ,
  PRIMARY KEY (`id_config_dynamic_dashboard`, `id_auth_group`) ,
  INDEX `fk_cddg_id_auth_group` (`id_auth_group` ASC) ,
  INDEX `fk_cddg_id_config_dynamic_dashboard` (`id_config_dynamic_dashboard` ASC) ,
  CONSTRAINT `fk_cddg_id_auth_group`
    FOREIGN KEY (`id_auth_group` )
    REFERENCES `cgraphz`.`auth_group` (`id_auth_group` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_cddg_id_config_dynamic_dashboard`
    FOREIGN KEY (`id_config_dynamic_dashboard` )
    REFERENCES `cgraphz`.`config_dynamic_dashboard` (`id_config_dynamic_dashboard` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;



SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;

-- -----------------------------------------------------
-- Data for table `cgraphz`.`auth_group`
-- -----------------------------------------------------
START TRANSACTION;
USE `cgraphz`;
INSERT INTO `cgraphz`.`auth_group` (`id_auth_group`, `group`, `group_description`) VALUES (1, 'admin', 'Administrateur');

COMMIT;

-- -----------------------------------------------------
-- Data for table `cgraphz`.`auth_user`
-- -----------------------------------------------------
START TRANSACTION;
USE `cgraphz`;
INSERT INTO `cgraphz`.`auth_user` (`id_auth_user`, `nom`, `prenom`, `user`, `mail`, `passwd`, `type`) VALUES (1, 'admin', 'root', 'admin', 'noreply@neant.com', '*196BDEDE2AE4F84CA44C47D54D78478C7E2BD7B7', 'mysql');

COMMIT;

-- -----------------------------------------------------
-- Data for table `cgraphz`.`auth_user_group`
-- -----------------------------------------------------
START TRANSACTION;
USE `cgraphz`;
INSERT INTO `cgraphz`.`auth_user_group` (`id_auth_group`, `id_auth_user`, `manager`) VALUES (1, 1, 1);

COMMIT;

-- -----------------------------------------------------
-- Data for table `cgraphz`.`perm_module`
-- -----------------------------------------------------
START TRANSACTION;
USE `cgraphz`;
INSERT INTO `cgraphz`.`perm_module` (`id_perm_module`, `module`, `component`, `menu_name`, `menu_order`) VALUES (1, 'perm', 'module', 'Modules', 1);
INSERT INTO `cgraphz`.`perm_module` (`id_perm_module`, `module`, `component`, `menu_name`, `menu_order`) VALUES (2, 'config', 'project', 'Projets', 2);
INSERT INTO `cgraphz`.`perm_module` (`id_perm_module`, `module`, `component`, `menu_name`, `menu_order`) VALUES (3, 'config', 'server', 'Serveurs', 1);
INSERT INTO `cgraphz`.`perm_module` (`id_perm_module`, `module`, `component`, `menu_name`, `menu_order`) VALUES (4, 'dashboard', 'view', 'Dashboard', 1);
INSERT INTO `cgraphz`.`perm_module` (`id_perm_module`, `module`, `component`, `menu_name`, `menu_order`) VALUES (5, 'auth', 'user', 'Utilisateurs', 1);
INSERT INTO `cgraphz`.`perm_module` (`id_perm_module`, `module`, `component`, `menu_name`, `menu_order`) VALUES (6, 'auth', 'group', 'Groupes', 2);
INSERT INTO `cgraphz`.`perm_module` (`id_perm_module`, `module`, `component`, `menu_name`, `menu_order`) VALUES (7, 'config', 'plugin', 'Filtres', 3);
INSERT INTO `cgraphz`.`perm_module` (`id_perm_module`, `module`, `component`, `menu_name`, `menu_order`) VALUES (8, 'dashboard', 'dynamic', 'Dynamique', 2);
INSERT INTO `cgraphz`.`perm_module` (`id_perm_module`, `module`, `component`, `menu_name`, `menu_order`) VALUES (9, 'small_admin', 'myaccount', 'Mon Compte', 1);
INSERT INTO `cgraphz`.`perm_module` (`id_perm_module`, `module`, `component`, `menu_name`, `menu_order`) VALUES (10, 'small_admin', 'mygroup', 'Mes Groupes', 2);
INSERT INTO `cgraphz`.`perm_module` (`id_perm_module`, `module`, `component`, `menu_name`, `menu_order`) VALUES (11, 'small_admin', 'newuser', 'Nouvel Utilisateur', 3);
INSERT INTO `cgraphz`.`perm_module` (`id_perm_module`, `module`, `component`, `menu_name`, `menu_order`) VALUES (12, 'small_admin', 'mydashboard', 'Mes TdBs', 4);
INSERT INTO `cgraphz`.`perm_module` (`id_perm_module`, `module`, `component`, `menu_name`, `menu_order`) VALUES (13, 'config', 'dynamic_dashboard', 'TdBs Dynamiques', 4);
INSERT INTO `cgraphz`.`perm_module` (`id_perm_module`, `module`, `component`, `menu_name`, `menu_order`) VALUES (14, 'config', 'role', 'Rôles', 5);
INSERT INTO `cgraphz`.`perm_module` (`id_perm_module`, `module`, `component`, `menu_name`, `menu_order`) VALUES (15, 'config', 'environment', 'Environnements', 6);

COMMIT;

-- -----------------------------------------------------
-- Data for table `cgraphz`.`perm_module_group`
-- -----------------------------------------------------
START TRANSACTION;
USE `cgraphz`;
INSERT INTO `cgraphz`.`perm_module_group` (`id_perm_module_group`, `id_auth_group`, `id_perm_module`) VALUES (1, 1, 1);
INSERT INTO `cgraphz`.`perm_module_group` (`id_perm_module_group`, `id_auth_group`, `id_perm_module`) VALUES (2, 1, 2);
INSERT INTO `cgraphz`.`perm_module_group` (`id_perm_module_group`, `id_auth_group`, `id_perm_module`) VALUES (3, 1, 3);
INSERT INTO `cgraphz`.`perm_module_group` (`id_perm_module_group`, `id_auth_group`, `id_perm_module`) VALUES (4, 1, 4);
INSERT INTO `cgraphz`.`perm_module_group` (`id_perm_module_group`, `id_auth_group`, `id_perm_module`) VALUES (5, 1, 5);
INSERT INTO `cgraphz`.`perm_module_group` (`id_perm_module_group`, `id_auth_group`, `id_perm_module`) VALUES (6, 1, 6);
INSERT INTO `cgraphz`.`perm_module_group` (`id_perm_module_group`, `id_auth_group`, `id_perm_module`) VALUES (7, 1, 7);
INSERT INTO `cgraphz`.`perm_module_group` (`id_perm_module_group`, `id_auth_group`, `id_perm_module`) VALUES (8, 1, 8);
INSERT INTO `cgraphz`.`perm_module_group` (`id_perm_module_group`, `id_auth_group`, `id_perm_module`) VALUES (9, 1, 9);
INSERT INTO `cgraphz`.`perm_module_group` (`id_perm_module_group`, `id_auth_group`, `id_perm_module`) VALUES (10, 1, 10);
INSERT INTO `cgraphz`.`perm_module_group` (`id_perm_module_group`, `id_auth_group`, `id_perm_module`) VALUES (11, 1, 11);
INSERT INTO `cgraphz`.`perm_module_group` (`id_perm_module_group`, `id_auth_group`, `id_perm_module`) VALUES (12, 1, 12);
INSERT INTO `cgraphz`.`perm_module_group` (`id_perm_module_group`, `id_auth_group`, `id_perm_module`) VALUES (13, 1, 13);
INSERT INTO `cgraphz`.`perm_module_group` (`id_perm_module_group`, `id_auth_group`, `id_perm_module`) VALUES (14, 1, 14);
INSERT INTO `cgraphz`.`perm_module_group` (`id_perm_module_group`, `id_auth_group`, `id_perm_module`) VALUES (15, 1, 15);

COMMIT;

-- -----------------------------------------------------
-- Data for table `cgraphz`.`config_plugin_filter`
-- -----------------------------------------------------
START TRANSACTION;
USE `cgraphz`;
INSERT INTO `cgraphz`.`config_plugin_filter` (`id_config_plugin_filter`, `plugin`, `plugin_instance`, `type`, `type_instance`, `plugin_filter_desc`, `plugin_order`) VALUES (1, '\\w+', '.*', '\\w+', '.*', 'all', 99);
INSERT INTO `cgraphz`.`config_plugin_filter` (`id_config_plugin_filter`, `plugin`, `plugin_instance`, `type`, `type_instance`, `plugin_filter_desc`, `plugin_order`) VALUES (2, 'load', NULL, 'load', NULL, 'load_average', 1);
INSERT INTO `cgraphz`.`config_plugin_filter` (`id_config_plugin_filter`, `plugin`, `plugin_instance`, `type`, `type_instance`, `plugin_filter_desc`, `plugin_order`) VALUES (3, 'memory', '', 'memory', '\\w+', 'memory', 2);
INSERT INTO `cgraphz`.`config_plugin_filter` (`id_config_plugin_filter`, `plugin`, `plugin_instance`, `type`, `type_instance`, `plugin_filter_desc`, `plugin_order`) VALUES (4, 'interface', '', 'if_octets', 'eth0', 'eth0_traffic', 3);
INSERT INTO `cgraphz`.`config_plugin_filter` (`id_config_plugin_filter`, `plugin`, `plugin_instance`, `type`, `type_instance`, `plugin_filter_desc`, `plugin_order`) VALUES (5, 'mysql', '.*', '\\w+', '.*', 'mysql', 4);
INSERT INTO `cgraphz`.`config_plugin_filter` (`id_config_plugin_filter`, `plugin`, `plugin_instance`, `type`, `type_instance`, `plugin_filter_desc`, `plugin_order`) VALUES (6, 'nginx', '', 'nginx_\\w+', '.*', 'nginx', 4);
INSERT INTO `cgraphz`.`config_plugin_filter` (`id_config_plugin_filter`, `plugin`, `plugin_instance`, `type`, `type_instance`, `plugin_filter_desc`, `plugin_order`) VALUES (7, 'processes', '\\w+', 'ps_count', NULL, 'processes', 5);
INSERT INTO `cgraphz`.`config_plugin_filter` (`id_config_plugin_filter`, `plugin`, `plugin_instance`, `type`, `type_instance`, `plugin_filter_desc`, `plugin_order`) VALUES (8, 'processes', '', '\\w+', '\\w+', 'ps', 5);
INSERT INTO `cgraphz`.`config_plugin_filter` (`id_config_plugin_filter`, `plugin`, `plugin_instance`, `type`, `type_instance`, `plugin_filter_desc`, `plugin_order`) VALUES (9, 'tcpconns', '\\d+-\\w+', 'tcp_connections', '\\w+', 'tcpconns', 5);
INSERT INTO `cgraphz`.`config_plugin_filter` (`id_config_plugin_filter`, `plugin`, `plugin_instance`, `type`, `type_instance`, `plugin_filter_desc`, `plugin_order`) VALUES (10, 'df', '', 'df', '.+', 'df', 7);
INSERT INTO `cgraphz`.`config_plugin_filter` (`id_config_plugin_filter`, `plugin`, `plugin_instance`, `type`, `type_instance`, `plugin_filter_desc`, `plugin_order`) VALUES (11, 'cpu', '\\d+', 'cpu', '\\w+', 'cpu', 8);
INSERT INTO `cgraphz`.`config_plugin_filter` (`id_config_plugin_filter`, `plugin`, `plugin_instance`, `type`, `type_instance`, `plugin_filter_desc`, `plugin_order`) VALUES (12, 'df', '\\w+', 'df_complex', '.+', 'df_complex', 6);

COMMIT;

-- -----------------------------------------------------
-- Data for table `cgraphz`.`config_plugin_filter_group`
-- -----------------------------------------------------
START TRANSACTION;
USE `cgraphz`;
INSERT INTO `cgraphz`.`config_plugin_filter_group` (`id_config_plugin_filter`, `id_auth_group`) VALUES (1, 1);
INSERT INTO `cgraphz`.`config_plugin_filter_group` (`id_config_plugin_filter`, `id_auth_group`) VALUES (2, 1);
INSERT INTO `cgraphz`.`config_plugin_filter_group` (`id_config_plugin_filter`, `id_auth_group`) VALUES (3, 1);
INSERT INTO `cgraphz`.`config_plugin_filter_group` (`id_config_plugin_filter`, `id_auth_group`) VALUES (4, 1);
INSERT INTO `cgraphz`.`config_plugin_filter_group` (`id_config_plugin_filter`, `id_auth_group`) VALUES (5, 1);
INSERT INTO `cgraphz`.`config_plugin_filter_group` (`id_config_plugin_filter`, `id_auth_group`) VALUES (6, 1);
INSERT INTO `cgraphz`.`config_plugin_filter_group` (`id_config_plugin_filter`, `id_auth_group`) VALUES (7, 1);
INSERT INTO `cgraphz`.`config_plugin_filter_group` (`id_config_plugin_filter`, `id_auth_group`) VALUES (8, 1);
INSERT INTO `cgraphz`.`config_plugin_filter_group` (`id_config_plugin_filter`, `id_auth_group`) VALUES (9, 1);
INSERT INTO `cgraphz`.`config_plugin_filter_group` (`id_config_plugin_filter`, `id_auth_group`) VALUES (10, 1);
INSERT INTO `cgraphz`.`config_plugin_filter_group` (`id_config_plugin_filter`, `id_auth_group`) VALUES (11, 1);
INSERT INTO `cgraphz`.`config_plugin_filter_group` (`id_config_plugin_filter`, `id_auth_group`) VALUES (12, 1);


COMMIT;
