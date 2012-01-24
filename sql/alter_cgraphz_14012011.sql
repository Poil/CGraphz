SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL';

CREATE  TABLE IF NOT EXISTS `cgraphz`.`config_plugin_filter` (
  `id_config_plugin_filter` INT(10) UNSIGNED NULL DEFAULT NULL AUTO_INCREMENT ,
  `plugin` VARCHAR(45) NOT NULL ,
  `plugin_instance` VARCHAR(45) NULL DEFAULT NULL ,
  `type` VARCHAR(45) NOT NULL ,
  `type_instance` VARCHAR(45) NULL DEFAULT NULL ,
  `id_auth_group` INT(10) UNSIGNED NULL DEFAULT NULL ,
  PRIMARY KEY (`id_config_plugin_filter`) ,
  INDEX `fk_cpf_id_auth_group` (`id_auth_group` ASC) ,
  UNIQUE INDEX `ix_cpf_filter_unique` (`id_auth_group` ASC, `type_instance` ASC, `type` ASC, `plugin_instance` ASC, `plugin` ASC) ,
  CONSTRAINT `fk_cpf_id_auth_group`
    FOREIGN KEY (`id_auth_group` )
    REFERENCES `cgraphz`.`auth_group` (`id_auth_group` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_general_ci;

CREATE  TABLE IF NOT EXISTS `cgraphz`.`config_role` (
  `id_config_role` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT ,
  `role` VARCHAR(45) NULL DEFAULT NULL ,
  PRIMARY KEY (`id_config_role`) ,
  UNIQUE INDEX `role_UNIQUE` (`role` ASC) )
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_general_ci;

CREATE  TABLE IF NOT EXISTS `cgraphz`.`config_role_server` (
  `id_config_role` INT(10) UNSIGNED NOT NULL ,
  `id_config_server` INT(10) UNSIGNED NOT NULL ,
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
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_general_ci;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
