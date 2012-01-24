SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL';

CREATE  TABLE IF NOT EXISTS `cgraphz`.`config_environment_server` (
  `id_config_environment` INT(10) UNSIGNED NOT NULL ,
  `id_config_server` INT(10) UNSIGNED NOT NULL ,
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
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_general_ci;

CREATE  TABLE IF NOT EXISTS `cgraphz`.`config_environment` (
  `id_config_environment` INT(10) UNSIGNED NOT NULL ,
  `environment` VARCHAR(45) NULL DEFAULT NULL ,
  `environment_description` VARCHAR(45) NULL DEFAULT NULL ,
  PRIMARY KEY (`id_config_environment`) ,
  UNIQUE INDEX `environment_UNIQUE` (`environment` ASC) )
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_general_ci;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
