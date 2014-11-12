-- MySQL Workbench Synchronization
-- Generated: 2014-11-12 16:00
-- Model: New Model
-- Version: 1.0
-- Project: Name of the project
-- Author: Benjamin

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL,ALLOW_INVALID_DATES';

CREATE TABLE IF NOT EXISTS `cgraphz`.`config_quickview` (
  `id_config_quickview` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `title` VARCHAR(45) NULL DEFAULT NULL,
  PRIMARY KEY (`id_config_quickview`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_general_ci;

CREATE TABLE IF NOT EXISTS `cgraphz`.`config_quickview_content` (
  `id_config_quickview_content` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `id_config_quickview` INT(10) UNSIGNED NOT NULL,
  PRIMARY KEY (`id_config_quickview_content`),
  INDEX `fk_cqc_id_config_quickview_idx` (`id_config_quickview` ASC),
  CONSTRAINT `fk_cqc_id_config_quickview`
    FOREIGN KEY (`id_config_quickview`)
    REFERENCES `cgraphz`.`config_quickview` (`id_config_quickview`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_general_ci;

CREATE TABLE IF NOT EXISTS `cgraphz`.`config_quickview_content_filter` (
  `id_config_quickview_content_filter` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `id_config_quickview_content` INT(10) UNSIGNED NOT NULL,
  `title` VARCHAR(45) NULL DEFAULT NULL,
  `display_title` TINYINT(1) NULL DEFAULT 0,
  `dash_ordering` INT(11) NULL DEFAULT NULL,
  `regex_srv` VARCHAR(255) NULL DEFAULT NULL,
  `id_config_project` INT(10) UNSIGNED NULL DEFAULT NULL,
  `regex_p_filter` VARCHAR(80) NULL DEFAULT NULL,
  `regex_pc_filter` VARCHAR(80) NULL DEFAULT NULL,
  `regex_pi_filter` VARCHAR(80) NULL DEFAULT NULL,
  `regex_t_filter` VARCHAR(80) NULL DEFAULT NULL,
  `regex_tc_filter` VARCHAR(80) NULL DEFAULT NULL,
  `regex_ti_filter` VARCHAR(80) NULL DEFAULT NULL,
  `display_p_title` TINYINT(1) NULL DEFAULT 0,
  `display_pc_title` TINYINT(1) NULL DEFAULT 0,
  `display_pi_title` TINYINT(1) NULL DEFAULT 0,
  `display_t_title` TINYINT(1) NULL DEFAULT 0,
  `display_tc_title` TINYINT(1) NULL DEFAULT 0,
  `display_ti_title` TINYINT(1) NULL DEFAULT 0,
  PRIMARY KEY (`id_config_quickview_content_filter`),
  INDEX `fk_cqcf_id_config_quickview_content_idx` (`id_config_quickview_content` ASC),
  CONSTRAINT `fk_cqcf_id_config_quickview_content`
    FOREIGN KEY (`id_config_quickview_content`)
    REFERENCES `cgraphz`.`config_quickview_content` (`id_config_quickview_content`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_general_ci;

CREATE TABLE IF NOT EXISTS `cgraphz`.`config_quickview_content_html` (
  `id_config_quickview_content_html` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `id_config_quickview_content` INT(10) UNSIGNED NOT NULL,
  `tag` VARCHAR(255) NOT NULL,
  `tag_content` VARCHAR(255) NULL DEFAULT NULL,
  PRIMARY KEY (`id_config_quickview_content_html`),
  INDEX `fk_cqch_id_config_quickview_content_idx` (`id_config_quickview_content` ASC),
  CONSTRAINT `fk_cqch_id_config_quickview_content`
    FOREIGN KEY (`id_config_quickview_content`)
    REFERENCES `cgraphz`.`config_quickview_content` (`id_config_quickview_content`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_general_ci;

CREATE TABLE IF NOT EXISTS `cgraphz`.`config_quickview_group` (
  `id_config_quickview` INT(10) UNSIGNED NOT NULL,
  `id_auth_group` INT(10) UNSIGNED NOT NULL,
  `group_manager` TINYINT(1) NULL DEFAULT 0,
  PRIMARY KEY (`id_config_quickview`, `id_auth_group`),
  INDEX `fk_cqg_id_auth_group_idx` (`id_auth_group` ASC),
  CONSTRAINT `fk_cqg_id_auth_group`
    FOREIGN KEY (`id_auth_group`)
    REFERENCES `cgraphz`.`auth_group` (`id_auth_group`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_cqg_id_config_quickview`
    FOREIGN KEY (`id_config_quickview`)
    REFERENCES `cgraphz`.`config_quickview` (`id_config_quickview`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_general_ci;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
