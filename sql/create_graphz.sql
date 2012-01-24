SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL';

DROP SCHEMA IF EXISTS `cgraphz` ;
CREATE SCHEMA IF NOT EXISTS `cgraphz` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci ;
USE `cgraphz` ;

-- -----------------------------------------------------
-- Table `cgraphz`.`auth_group`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `cgraphz`.`auth_group` (
  `id_auth_group` INT UNSIGNED NOT NULL AUTO_INCREMENT ,
  `group` VARCHAR(45) NOT NULL ,
  `group_description` VARCHAR(45) NULL ,
  PRIMARY KEY (`id_auth_group`) )
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
  UNIQUE INDEX `ix_au_user_passwd` (`user` ASC, `passwd` ASC) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `cgraphz`.`config_server`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `cgraphz`.`config_server` (
  `id_config_server` INT UNSIGNED NOT NULL AUTO_INCREMENT ,
  `server_name` VARCHAR(45) NOT NULL ,
  `server_description` TEXT NULL ,
  PRIMARY KEY (`id_config_server`) ,
  UNIQUE INDEX `ix_cs_server_name` (`server_name` ASC) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `cgraphz`.`auth_user_group`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `cgraphz`.`auth_user_group` (
  `id_auth_group` INT UNSIGNED NOT NULL ,
  `id_auth_user` INT UNSIGNED NOT NULL ,
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
-- Table `cgraphz`.`content_dashboard`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `cgraphz`.`content_dashboard` (
  `id_content_dashboard` INT UNSIGNED NOT NULL AUTO_INCREMENT ,
  `dashboard` VARCHAR(45) NOT NULL ,
  `dashboard_description` TEXT NULL ,
  `dashboard_content` TEXT NULL ,
  `id_config_project` INT UNSIGNED NOT NULL ,
  PRIMARY KEY (`id_content_dashboard`) ,
  UNIQUE INDEX `ix_cd_dashboard` (`dashboard` ASC) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `cgraphz`.`content_project_dashboard`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `cgraphz`.`content_project_dashboard` (
  `id_content_dashboard` INT UNSIGNED NOT NULL ,
  `id_config_project` INT UNSIGNED NOT NULL ,
  PRIMARY KEY (`id_content_dashboard`, `id_config_project`) ,
  INDEX `fk_cpd_id_config_project` (`id_config_project` ASC) ,
  INDEX `fk_cpd_id_content_dashboard` (`id_content_dashboard` ASC) ,
  CONSTRAINT `fk_cpd_id_config_project`
    FOREIGN KEY (`id_config_project` )
    REFERENCES `cgraphz`.`config_project` (`id_config_project` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_cpd_id_content_dashboard`
    FOREIGN KEY (`id_content_dashboard` )
    REFERENCES `cgraphz`.`content_dashboard` (`id_content_dashboard` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `cgraphz`.`perm_module`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `cgraphz`.`perm_module` (
  `id_perm_module` INT UNSIGNED NOT NULL ,
  `module` VARCHAR(45) NULL ,
  `component` VARCHAR(45) NULL ,
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



SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;

-- -----------------------------------------------------
-- Data for table `cgraphz`.`auth_group`
-- -----------------------------------------------------
SET AUTOCOMMIT=0;
USE `cgraphz`;
INSERT INTO `cgraphz`.`auth_group` (`id_auth_group`, `group`, `group_description`) VALUES ('1', 'admin', NULL);

COMMIT;

-- -----------------------------------------------------
-- Data for table `cgraphz`.`auth_user`
-- -----------------------------------------------------
SET AUTOCOMMIT=0;
USE `cgraphz`;
INSERT INTO `cgraphz`.`auth_user` (`id_auth_user`, `nom`, `prenom`, `user`, `mail`, `passwd`, `type`) VALUES ('1', 'admin', 'root', 'admin', 'noreply@neant.com', 'pass', 'mysql');

COMMIT;

-- -----------------------------------------------------
-- Data for table `cgraphz`.`auth_user_group`
-- -----------------------------------------------------
SET AUTOCOMMIT=0;
USE `cgraphz`;
INSERT INTO `cgraphz`.`auth_user_group` (`id_auth_group`, `id_auth_user`) VALUES ('1', '1');

COMMIT;
