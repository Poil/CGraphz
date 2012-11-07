SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL';

CREATE  TABLE IF NOT EXISTS `cgraphz`.`config_dynamic_dashboard` (
  `id_config_dynamic_dashboard` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT ,
  `title` VARCHAR(45) NOT NULL ,
  PRIMARY KEY (`id_config_dynamic_dashboard`) )
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_general_ci;

CREATE  TABLE IF NOT EXISTS `cgraphz`.`config_dynamic_dashboard_content` (
  `id_config_dynamic_dashboard_content` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT ,
  `id_config_dynamic_dashboard` INT(10) UNSIGNED NOT NULL ,
  `title` VARCHAR(45) NOT NULL ,
  `dash_ordering` INT(11) NOT NULL ,
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
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_general_ci;

CREATE  TABLE IF NOT EXISTS `cgraphz`.`config_dynamic_dashboard_group` (
  `id_config_dynamic_dashboard` INT(10) UNSIGNED NOT NULL ,
  `id_auth_group` INT(10) UNSIGNED NOT NULL ,
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
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_general_ci;

DROP TABLE IF EXISTS `cgraphz`.`content_project_dashboard` ;

DROP TABLE IF EXISTS `cgraphz`.`content_dashboard` ;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
