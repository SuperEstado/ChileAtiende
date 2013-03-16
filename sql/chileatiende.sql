SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL,ALLOW_INVALID_DATES';


-- -----------------------------------------------------
-- Table `chileatiende`.`entidad`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `chileatiende`.`entidad` (
  `codigo` VARCHAR(8) NOT NULL ,
  `nombre` VARCHAR(50) NOT NULL ,
  `mision` TEXT NULL DEFAULT NULL ,
  `sigla` VARCHAR(45) NULL DEFAULT NULL ,
  `created_at` VARCHAR(45) NULL DEFAULT NULL ,
  `updated_at` VARCHAR(45) NULL DEFAULT NULL ,
  PRIMARY KEY (`codigo`) )
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_general_ci;


-- -----------------------------------------------------
-- Table `chileatiende`.`servicio`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `chileatiende`.`servicio` (
  `codigo` VARCHAR(8) NOT NULL ,
  `nombre` VARCHAR(255) NOT NULL ,
  `sigla` VARCHAR(32) NULL DEFAULT NULL ,
  `url` VARCHAR(512) NULL DEFAULT NULL ,
  `responsable` VARCHAR(128) NULL DEFAULT NULL ,
  `entidad_codigo` VARCHAR(8) NOT NULL ,
  `created_at` DATETIME NULL DEFAULT NULL ,
  `updated_at` DATETIME NULL DEFAULT NULL ,
  `mision` TEXT NOT NULL ,
  PRIMARY KEY (`codigo`) ,
  INDEX `fk_servicio_entidad` (`entidad_codigo` ASC) ,
  CONSTRAINT `fk_servicio_entidad`
    FOREIGN KEY (`entidad_codigo` )
    REFERENCES `chileatiende`.`entidad` (`codigo` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_general_ci;


-- -----------------------------------------------------
-- Table `chileatiende`.`ficha`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `chileatiende`.`ficha` (
  `id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT ,
  `correlativo` INT(11) NULL DEFAULT NULL ,
  `titulo` VARCHAR(255) NOT NULL ,
  `alias` VARCHAR(255) NULL DEFAULT NULL ,
  `objetivo` TEXT NOT NULL ,
  `weight` INT(10) UNSIGNED NULL DEFAULT NULL ,
  `beneficiarios` TEXT NULL DEFAULT NULL ,
  `costo` TEXT NULL DEFAULT NULL ,
  `vigencia` TEXT NULL DEFAULT NULL ,
  `plazo` TEXT NOT NULL ,
  `guia_online` TEXT NULL DEFAULT NULL ,
  `guia_online_url` VARCHAR(255) NULL DEFAULT NULL ,
  `guia_oficina` TEXT NULL DEFAULT NULL ,
  `guia_telefonico` TEXT NULL DEFAULT NULL ,
  `guia_correo` TEXT NULL DEFAULT NULL ,
  `marco_legal` TEXT NULL DEFAULT NULL ,
  `doc_requeridos` TEXT NULL DEFAULT NULL ,
  `maestro` TINYINT(1) NOT NULL ,
  `publicado` TINYINT(1) NOT NULL ,
  `publicado_at` DATETIME NULL DEFAULT NULL ,
  `locked` TINYINT(1) NOT NULL DEFAULT '0' ,
  `estado` VARCHAR(16) NULL DEFAULT NULL ,
  `estado_justificacion` TEXT NULL DEFAULT NULL ,
  `actualizable` TINYINT(1) NULL DEFAULT NULL ,
  `destacado` TINYINT(1) NOT NULL DEFAULT '0' ,
  `servicio_codigo` VARCHAR(8) NOT NULL ,
  `created_at` DATETIME NULL DEFAULT NULL ,
  `updated_at` DATETIME NULL DEFAULT NULL ,
  `maestro_id` INT(10) UNSIGNED NULL DEFAULT NULL ,
  `genero_id` INT(11) NULL DEFAULT NULL ,
  `convenio` TINYINT(1) NULL DEFAULT '0' ,
  `estado_mds` ENUM('en_chileatiende','en_mds','aprobado_mds','rechazado_mds') NULL DEFAULT 'en_chileatiende' ,
  `cc_observaciones` TEXT NULL DEFAULT NULL ,
  `cc_id` VARCHAR(20) NULL DEFAULT NULL ,
  `cc_formulario` TEXT NULL DEFAULT NULL ,
  `cc_llavevalor` INT(11) NULL DEFAULT NULL ,
  `comentarios` TEXT NOT NULL ,
  `tipo` TINYINT(4) NOT NULL ,
  `clase` ENUM('ficha','flujo','beneficio') NOT NULL DEFAULT 'ficha' ,
  `tema_principal` INT(10) UNSIGNED NOT NULL ,
  `keywords` VARCHAR(255) NULL DEFAULT NULL ,
  `sic` VARCHAR(255) NULL DEFAULT NULL ,
  PRIMARY KEY (`id`) ,
  UNIQUE INDEX `codigo` (`correlativo` ASC, `servicio_codigo` ASC) ,
  INDEX `fk_ficha_servicio1` (`servicio_codigo` ASC) ,
  INDEX `fk_ficha_ficha1` (`maestro_id` ASC) ,
  CONSTRAINT `ficha_ibfk_1`
    FOREIGN KEY (`maestro_id` )
    REFERENCES `chileatiende`.`ficha` (`id` )
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `fk_ficha_servicio1`
    FOREIGN KEY (`servicio_codigo` )
    REFERENCES `chileatiende`.`servicio` (`codigo` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
AUTO_INCREMENT = 10739
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_general_ci
COMMENT = 'no se agrega relacion con tabla genero.';


-- -----------------------------------------------------
-- Table `chileatiende`.`tag`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `chileatiende`.`tag` (
  `id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT ,
  `nombre` VARCHAR(255) NOT NULL ,
  PRIMARY KEY (`id`) )
ENGINE = InnoDB
AUTO_INCREMENT = 490
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_general_ci;


-- -----------------------------------------------------
-- Table `chileatiende`.`ficha_has_tag`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `chileatiende`.`ficha_has_tag` (
  `ficha_id` INT(10) UNSIGNED NOT NULL ,
  `tag_id` INT(10) UNSIGNED NOT NULL ,
  PRIMARY KEY (`ficha_id`, `tag_id`) ,
  INDEX `fk_ficha_has_tag_tag1` (`tag_id` ASC) ,
  INDEX `fk_ficha_has_tag_ficha1` (`ficha_id` ASC) ,
  CONSTRAINT `ficha_has_tag_ibfk_1`
    FOREIGN KEY (`ficha_id` )
    REFERENCES `chileatiende`.`ficha` (`id` )
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `ficha_has_tag_ibfk_2`
    FOREIGN KEY (`tag_id` )
    REFERENCES `chileatiende`.`tag` (`id` )
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_general_ci;


-- -----------------------------------------------------
-- Table `chileatiende`.`tema`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `chileatiende`.`tema` (
  `id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT ,
  `nombre` VARCHAR(255) NOT NULL ,
  PRIMARY KEY (`id`) )
ENGINE = InnoDB
AUTO_INCREMENT = 17
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_general_ci;


-- -----------------------------------------------------
-- Table `chileatiende`.`sistema_previsional`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `chileatiende`.`sistema_previsional` (
  `id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT ,
  `nombre` VARCHAR(128) NOT NULL ,
  PRIMARY KEY (`id`) )
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_general_ci;


-- -----------------------------------------------------
-- Table `chileatiende`.`sistema_salud`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `chileatiende`.`sistema_salud` (
  `id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT ,
  `nombre` VARCHAR(128) NOT NULL ,
  PRIMARY KEY (`id`) )
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_general_ci;


-- -----------------------------------------------------
-- Table `chileatiende`.`sector`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `chileatiende`.`sector` (
  `codigo` VARCHAR(11) NOT NULL ,
  `tipo` VARCHAR(45) NOT NULL ,
  `nombre` VARCHAR(45) NOT NULL ,
  `lat` FLOAT(11) NULL DEFAULT NULL ,
  `lng` FLOAT(11) NULL DEFAULT NULL ,
  `url` VARCHAR(512) NULL DEFAULT NULL ,
  `sector_padre_codigo` VARCHAR(11) NULL DEFAULT NULL ,
  `created_at` DATETIME NULL DEFAULT NULL ,
  `updated_at` DATETIME NULL DEFAULT NULL ,
  PRIMARY KEY (`codigo`) ,
  INDEX `fk_sector_sector1` (`sector_padre_codigo` ASC) )
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_general_ci;


-- -----------------------------------------------------
-- Table `chileatiende`.`usuario_frontend`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `chileatiende`.`usuario_frontend` (
  `id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT ,
  `email` VARCHAR(255) NOT NULL ,
  `nombres` VARCHAR(255) NOT NULL ,
  `apellidos` VARCHAR(255) NOT NULL ,
  `sexo` CHAR(1) NULL DEFAULT NULL ,
  `edad` INT(10) UNSIGNED NULL DEFAULT NULL ,
  `sector_codigo` VARCHAR(11) NULL DEFAULT NULL ,
  `created_at` DATETIME NULL DEFAULT NULL ,
  `updated_at` DATETIME NULL DEFAULT NULL ,
  `sistema_salud_id` INT(10) UNSIGNED NOT NULL ,
  `sistema_previsional_id` INT(10) UNSIGNED NOT NULL ,
  `password` VARCHAR(255) NOT NULL ,
  PRIMARY KEY (`id`) ,
  UNIQUE INDEX `email` (`email` ASC) ,
  INDEX `fk_usuario_frontend_sector1` (`sector_codigo` ASC) ,
  INDEX `fk_usuario_frontend_sistema_salud1` (`sistema_salud_id` ASC) ,
  INDEX `fk_usuario_frontend_sistema_previsional1` (`sistema_previsional_id` ASC) ,
  CONSTRAINT `fk_usuario_frontend_sistema_previsional1`
    FOREIGN KEY (`sistema_previsional_id` )
    REFERENCES `chileatiende`.`sistema_previsional` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_usuario_frontend_sistema_salud1`
    FOREIGN KEY (`sistema_salud_id` )
    REFERENCES `chileatiende`.`sistema_salud` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `usuario_frontend_ibfk_1`
    FOREIGN KEY (`sector_codigo` )
    REFERENCES `chileatiende`.`sector` (`codigo` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_general_ci;


-- -----------------------------------------------------
-- Table `chileatiende`.`comentario`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `chileatiende`.`comentario` (
  `id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT ,
  `comentario` TEXT NOT NULL ,
  `ficha_id` INT(10) UNSIGNED NOT NULL ,
  `usuario_frontend_id` INT(10) UNSIGNED NOT NULL ,
  `created_at` DATETIME NULL DEFAULT NULL ,
  `updated_at` DATETIME NULL DEFAULT NULL ,
  PRIMARY KEY (`id`) ,
  INDEX `fk_evaluacion_ficha1` (`ficha_id` ASC) ,
  INDEX `fk_evaluacion_usuario_frontend1` (`usuario_frontend_id` ASC) ,
  CONSTRAINT `fk_evaluacion_ficha1`
    FOREIGN KEY (`ficha_id` )
    REFERENCES `chileatiende`.`ficha` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_evaluacion_usuario_frontend1`
    FOREIGN KEY (`usuario_frontend_id` )
    REFERENCES `chileatiende`.`usuario_frontend` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_general_ci;


-- -----------------------------------------------------
-- Table `chileatiende`.`usuario_backend`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `chileatiende`.`usuario_backend` (
  `id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT ,
  `email` VARCHAR(255) NOT NULL ,
  `nombres` VARCHAR(255) NOT NULL ,
  `apellidos` VARCHAR(255) NOT NULL ,
  `ministerial` TINYINT(1) NOT NULL ,
  `interministerial` TINYINT(1) NOT NULL ,
  `created_at` DATETIME NULL DEFAULT NULL ,
  `updated_at` DATETIME NULL DEFAULT NULL ,
  `password` VARCHAR(255) NOT NULL ,
  `activo` TINYINT(1) NULL DEFAULT '0' ,
  PRIMARY KEY (`id`) ,
  UNIQUE INDEX `email` (`email` ASC) )
ENGINE = InnoDB
AUTO_INCREMENT = 175
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_general_ci;


-- -----------------------------------------------------
-- Table `chileatiende`.`rol`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `chileatiende`.`rol` (
  `id` VARCHAR(16) NOT NULL ,
  `nombre` VARCHAR(64) NOT NULL ,
  `descripcion` TEXT NOT NULL ,
  `created_at` DATETIME NULL DEFAULT NULL ,
  `updated_at` DATETIME NULL DEFAULT NULL ,
  PRIMARY KEY (`id`) )
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_general_ci;


-- -----------------------------------------------------
-- Table `chileatiende`.`usuario_backend_has_rol`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `chileatiende`.`usuario_backend_has_rol` (
  `usuario_backend_id` INT(10) UNSIGNED NOT NULL ,
  `rol_id` VARCHAR(16) NOT NULL ,
  PRIMARY KEY (`usuario_backend_id`, `rol_id`) ,
  INDEX `fk_usuario_backend_has_rol_rol1` (`rol_id` ASC) ,
  INDEX `fk_usuario_backend_has_rol_usuario_backend1` (`usuario_backend_id` ASC) ,
  CONSTRAINT `usuario_backend_has_rol_ibfk_1`
    FOREIGN KEY (`usuario_backend_id` )
    REFERENCES `chileatiende`.`usuario_backend` (`id` )
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `usuario_backend_has_rol_ibfk_2`
    FOREIGN KEY (`rol_id` )
    REFERENCES `chileatiende`.`rol` (`id` )
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_general_ci;


-- -----------------------------------------------------
-- Table `chileatiende`.`noticia`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `chileatiende`.`noticia` (
  `id` INT(11) NOT NULL AUTO_INCREMENT ,
  `titulo` VARCHAR(255) NOT NULL ,
  `alias` VARCHAR(255) NOT NULL ,
  `resumen` VARCHAR(512) NOT NULL ,
  `contenido` TEXT NOT NULL ,
  `foto` VARCHAR(512) NULL DEFAULT NULL ,
  `foto_descripcion` VARCHAR(128) NULL ,
  `publicado` TINYINT(1) NOT NULL ,
  `publicado_at` DATETIME NULL DEFAULT NULL ,
  `created_at` DATETIME NULL DEFAULT NULL ,
  `updated_at` DATETIME NULL DEFAULT NULL ,
  PRIMARY KEY (`id`, `alias`) ,
  UNIQUE INDEX `alias_UNIQUE` (`alias` ASC) )
ENGINE = InnoDB
AUTO_INCREMENT = 16
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_general_ci;


-- -----------------------------------------------------
-- Table `chileatiende`.`historial`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `chileatiende`.`historial` (
  `id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT ,
  `ficha_id` INT(10) UNSIGNED NULL DEFAULT NULL ,
  `ficha_version_id` INT(10) UNSIGNED NULL DEFAULT NULL ,
  `usuario_backend_id` INT(10) UNSIGNED NULL DEFAULT NULL ,
  `created_at` DATETIME NULL DEFAULT NULL ,
  `updated_at` DATETIME NULL DEFAULT NULL ,
  `descripcion` TEXT NOT NULL ,
  PRIMARY KEY (`id`) ,
  INDEX `fk_historial_ficha1` (`ficha_id` ASC) ,
  INDEX `fk_historial_usuario_backend1` (`usuario_backend_id` ASC) ,
  INDEX `ficha_version_id` (`ficha_version_id` ASC) ,
  CONSTRAINT `historial_ibfk_2`
    FOREIGN KEY (`ficha_id` )
    REFERENCES `chileatiende`.`ficha` (`id` )
    ON DELETE SET NULL
    ON UPDATE SET NULL,
  CONSTRAINT `historial_ibfk_3`
    FOREIGN KEY (`ficha_version_id` )
    REFERENCES `chileatiende`.`ficha` (`id` )
    ON DELETE SET NULL
    ON UPDATE SET NULL,
  CONSTRAINT `historial_ibfk_4`
    FOREIGN KEY (`usuario_backend_id` )
    REFERENCES `chileatiende`.`usuario_backend` (`id` )
    ON DELETE SET NULL
    ON UPDATE SET NULL)
ENGINE = InnoDB
AUTO_INCREMENT = 9867
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_general_ci;


-- -----------------------------------------------------
-- Table `chileatiende`.`hit`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `chileatiende`.`hit` (
  `id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT ,
  `count` INT(10) UNSIGNED NOT NULL ,
  `fecha` DATE NOT NULL ,
  `ficha_id` INT(10) UNSIGNED NOT NULL ,
  PRIMARY KEY (`id`) ,
  INDEX `fk_hit_ficha1` (`ficha_id` ASC) ,
  CONSTRAINT `hit_ibfk_1`
    FOREIGN KEY (`ficha_id` )
    REFERENCES `chileatiende`.`ficha` (`id` )
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB
AUTO_INCREMENT = 81676
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_general_ci;


-- -----------------------------------------------------
-- Table `chileatiende`.`flujo`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `chileatiende`.`flujo` (
  `id` INT(11) NOT NULL AUTO_INCREMENT ,
  `titulo` VARCHAR(255) NOT NULL ,
  `alias` VARCHAR(255) NULL DEFAULT NULL ,
  `descripcion` TEXT NOT NULL ,
  `created_at` DATETIME NULL DEFAULT NULL ,
  `updated_at` DATETIME NULL DEFAULT NULL ,
  PRIMARY KEY (`id`) )
ENGINE = InnoDB
AUTO_INCREMENT = 5
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_general_ci;


-- -----------------------------------------------------
-- Table `chileatiende`.`oficina`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `chileatiende`.`oficina` (
  `id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT ,
  `nombre` VARCHAR(128) NULL DEFAULT NULL ,
  `direccion` VARCHAR(512) NOT NULL ,
  `horario` VARCHAR(128) NOT NULL ,
  `telefonos` VARCHAR(128) NOT NULL ,
  `fax` VARCHAR(128) NULL DEFAULT NULL ,
  `sector_codigo` VARCHAR(11) NOT NULL ,
  `servicio_codigo` VARCHAR(8) NOT NULL ,
  `lat` DOUBLE NULL DEFAULT NULL ,
  `lng` DOUBLE NULL DEFAULT NULL ,
  `director` VARCHAR(128) NULL DEFAULT NULL ,
  `created_at` DATETIME NULL DEFAULT NULL ,
  `updated_at` DATETIME NULL DEFAULT NULL ,
  PRIMARY KEY (`id`) ,
  INDEX `fk_oficina_sector1` (`sector_codigo` ASC) ,
  INDEX `fk_oficina_servicio1` (`servicio_codigo` ASC) ,
  CONSTRAINT `fk_oficina_servicio1`
    FOREIGN KEY (`servicio_codigo` )
    REFERENCES `chileatiende`.`servicio` (`codigo` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `oficina_ibfk_1`
    FOREIGN KEY (`sector_codigo` )
    REFERENCES `chileatiende`.`sector` (`codigo` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
AUTO_INCREMENT = 145
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_general_ci;


-- -----------------------------------------------------
-- Table `chileatiende`.`evaluacion`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `chileatiende`.`evaluacion` (
  `id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT ,
  `rating` INT(11) NOT NULL ,
  `created_at` DATETIME NULL DEFAULT NULL ,
  `updated_at` DATETIME NULL DEFAULT NULL ,
  `ficha_id` INT(10) UNSIGNED NOT NULL ,
  PRIMARY KEY (`id`) ,
  INDEX `fk_evaluacion_ficha2` (`ficha_id` ASC) ,
  CONSTRAINT `evaluacion_ibfk_1`
    FOREIGN KEY (`ficha_id` )
    REFERENCES `chileatiende`.`ficha` (`id` )
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB
AUTO_INCREMENT = 5366
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_general_ci;


-- -----------------------------------------------------
-- Table `chileatiende`.`etapa_vida`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `chileatiende`.`etapa_vida` (
  `id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT ,
  `orden` INT(10) UNSIGNED NOT NULL ,
  `nombre` VARCHAR(128) NOT NULL ,
  `descripcion` TEXT NOT NULL ,
  `created_at` DATETIME NULL DEFAULT NULL ,
  `updated_at` DATETIME NULL DEFAULT NULL ,
  PRIMARY KEY (`id`) ,
  UNIQUE INDEX `orden` (`orden` ASC) )
ENGINE = InnoDB
AUTO_INCREMENT = 7
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_general_ci;


-- -----------------------------------------------------
-- Table `chileatiende`.`hecho_vida`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `chileatiende`.`hecho_vida` (
  `id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT ,
  `nombre` VARCHAR(128) NOT NULL ,
  `descripcion` TEXT NOT NULL ,
  `created_at` DATETIME NULL DEFAULT NULL ,
  `updated_at` DATETIME NULL DEFAULT NULL ,
  PRIMARY KEY (`id`) )
ENGINE = InnoDB
AUTO_INCREMENT = 69
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_general_ci;


-- -----------------------------------------------------
-- Table `chileatiende`.`etapa_vida_has_hecho_vida`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `chileatiende`.`etapa_vida_has_hecho_vida` (
  `etapa_vida_id` INT(10) UNSIGNED NOT NULL ,
  `hecho_vida_id` INT(10) UNSIGNED NOT NULL ,
  PRIMARY KEY (`etapa_vida_id`, `hecho_vida_id`) ,
  INDEX `fk_etapa_vida_has_hecho_vida_hecho_vida1` (`hecho_vida_id` ASC) ,
  INDEX `fk_etapa_vida_has_hecho_vida_etapa_vida1` (`etapa_vida_id` ASC) ,
  CONSTRAINT `etapa_vida_has_hecho_vida_ibfk_1`
    FOREIGN KEY (`etapa_vida_id` )
    REFERENCES `chileatiende`.`etapa_vida` (`id` )
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `etapa_vida_has_hecho_vida_ibfk_2`
    FOREIGN KEY (`hecho_vida_id` )
    REFERENCES `chileatiende`.`hecho_vida` (`id` )
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_general_ci;


-- -----------------------------------------------------
-- Table `chileatiende`.`ficha_has_hecho_vida`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `chileatiende`.`ficha_has_hecho_vida` (
  `ficha_id` INT(10) UNSIGNED NOT NULL ,
  `hecho_vida_id` INT(10) UNSIGNED NOT NULL ,
  PRIMARY KEY (`ficha_id`, `hecho_vida_id`) ,
  INDEX `fk_ficha_has_hecho_vida_hecho_vida1` (`hecho_vida_id` ASC) ,
  INDEX `fk_ficha_has_hecho_vida_ficha1` (`ficha_id` ASC) ,
  CONSTRAINT `ficha_has_hecho_vida_ibfk_1`
    FOREIGN KEY (`ficha_id` )
    REFERENCES `chileatiende`.`ficha` (`id` )
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `ficha_has_hecho_vida_ibfk_2`
    FOREIGN KEY (`hecho_vida_id` )
    REFERENCES `chileatiende`.`hecho_vida` (`id` )
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_general_ci;


-- -----------------------------------------------------
-- Table `chileatiende`.`flujo_has_hecho_vida`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `chileatiende`.`flujo_has_hecho_vida` (
  `flujo_id` INT(11) NOT NULL ,
  `hecho_vida_id` INT(10) UNSIGNED NOT NULL ,
  PRIMARY KEY (`flujo_id`, `hecho_vida_id`) ,
  INDEX `fk_flujo_has_hecho_vida_hecho_vida1` (`hecho_vida_id` ASC) ,
  INDEX `fk_flujo_has_hecho_vida_flujo1` (`flujo_id` ASC) ,
  CONSTRAINT `flujo_has_hecho_vida_ibfk_1`
    FOREIGN KEY (`flujo_id` )
    REFERENCES `chileatiende`.`flujo` (`id` )
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `flujo_has_hecho_vida_ibfk_2`
    FOREIGN KEY (`hecho_vida_id` )
    REFERENCES `chileatiende`.`hecho_vida` (`id` )
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_general_ci;


-- -----------------------------------------------------
-- Table `chileatiende`.`ficha_has_tema`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `chileatiende`.`ficha_has_tema` (
  `ficha_id` INT(10) UNSIGNED NOT NULL ,
  `tema_id` INT(10) UNSIGNED NOT NULL ,
  PRIMARY KEY (`ficha_id`, `tema_id`) ,
  INDEX `fk_ficha_has_tema_tema1` (`tema_id` ASC) ,
  INDEX `fk_ficha_has_tema_ficha1` (`ficha_id` ASC) ,
  CONSTRAINT `ficha_has_tema_ibfk_1`
    FOREIGN KEY (`ficha_id` )
    REFERENCES `chileatiende`.`ficha` (`id` )
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `ficha_has_tema_ibfk_2`
    FOREIGN KEY (`tema_id` )
    REFERENCES `chileatiende`.`tema` (`id` )
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_general_ci;


-- -----------------------------------------------------
-- Table `chileatiende`.`rango_edad`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `chileatiende`.`rango_edad` (
  `id` INT(11) NOT NULL AUTO_INCREMENT ,
  `edad_minima` SMALLINT(6) NULL DEFAULT NULL ,
  `edad_maxima` SMALLINT(6) NULL DEFAULT NULL ,
  PRIMARY KEY (`id`) )
ENGINE = InnoDB
AUTO_INCREMENT = 83
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_general_ci;


-- -----------------------------------------------------
-- Table `chileatiende`.`ficha_has_rango_edad`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `chileatiende`.`ficha_has_rango_edad` (
  `ficha_id` INT(10) UNSIGNED NOT NULL ,
  `rango_edad_id` INT(11) NOT NULL ,
  PRIMARY KEY (`ficha_id`, `rango_edad_id`) ,
  INDEX `fk_ficha_has_rango_edad_rango_edad1` (`rango_edad_id` ASC) ,
  INDEX `fk_ficha_has_rango_edad_ficha1` (`ficha_id` ASC) ,
  CONSTRAINT `ficha_has_rango_edad_ibfk_1`
    FOREIGN KEY (`ficha_id` )
    REFERENCES `chileatiende`.`ficha` (`id` )
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `ficha_has_rango_edad_ibfk_2`
    FOREIGN KEY (`rango_edad_id` )
    REFERENCES `chileatiende`.`rango_edad` (`id` )
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_general_ci;


-- -----------------------------------------------------
-- Table `chileatiende`.`genero`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `chileatiende`.`genero` (
  `id` INT(11) NOT NULL AUTO_INCREMENT ,
  `nombre` VARCHAR(45) NOT NULL ,
  PRIMARY KEY (`id`) )
ENGINE = InnoDB
AUTO_INCREMENT = 4
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_general_ci;


-- -----------------------------------------------------
-- Table `chileatiende`.`configuracion`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `chileatiende`.`configuracion` (
  `parametro` VARCHAR(255) NOT NULL ,
  `valor` TEXT NOT NULL ,
  PRIMARY KEY (`parametro`) )
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_general_ci;


-- -----------------------------------------------------
-- Table `chileatiende`.`archivo`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `chileatiende`.`archivo` (
  `id` INT(11) NOT NULL AUTO_INCREMENT ,
  `ficha_id` INT(10) UNSIGNED NOT NULL ,
  `nombre` VARCHAR(255) NULL DEFAULT NULL ,
  `url` TEXT NULL DEFAULT NULL ,
  `tipo` VARCHAR(45) NULL DEFAULT NULL ,
  PRIMARY KEY (`id`) ,
  INDEX `fk_archivos_ficha1` (`ficha_id` ASC) ,
  CONSTRAINT `fk_archivos_ficha1`
    FOREIGN KEY (`ficha_id` )
    REFERENCES `chileatiende`.`ficha` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_general_ci;


-- -----------------------------------------------------
-- Table `chileatiende`.`search_log`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `chileatiende`.`search_log` (
  `id` INT(11) NOT NULL AUTO_INCREMENT ,
  `search_query` TEXT NULL DEFAULT NULL ,
  `search_query_parsed` TEXT NULL DEFAULT NULL ,
  `created_at` DATETIME NULL DEFAULT NULL ,
  `updated_at` DATETIME NULL DEFAULT NULL ,
  PRIMARY KEY (`id`) )
ENGINE = InnoDB
AUTO_INCREMENT = 145400
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_general_ci;


-- -----------------------------------------------------
-- Table `chileatiende`.`api_acceso`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `chileatiende`.`api_acceso` (
  `id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT ,
  `token` VARCHAR(128) NOT NULL ,
  `email` VARCHAR(255) NOT NULL ,
  `nombre` VARCHAR(64) NOT NULL ,
  `apellido` VARCHAR(128) NOT NULL ,
  `empresa` VARCHAR(128) NULL DEFAULT NULL ,
  `created_at` DATETIME NULL DEFAULT NULL ,
  `updated_at` DATETIME NULL DEFAULT NULL ,
  PRIMARY KEY (`id`) ,
  UNIQUE INDEX `token` (`token` ASC) ,
  UNIQUE INDEX `email` (`email` ASC) )
ENGINE = InnoDB
AUTO_INCREMENT = 27
DEFAULT CHARACTER SET = latin1
COLLATE = utf8_general_ci;


-- -----------------------------------------------------
-- Table `chileatiende`.`chileclic_tipo`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `chileatiende`.`chileclic_tipo` (
  `id` INT(11) NOT NULL ,
  `nombre` VARCHAR(128) NOT NULL ,
  PRIMARY KEY (`id`) )
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_general_ci;


-- -----------------------------------------------------
-- Table `chileatiende`.`chileclic_tema`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `chileatiende`.`chileclic_tema` (
  `id` INT(11) NOT NULL ,
  `nombre` VARCHAR(128) NOT NULL ,
  `chileclic_tipo_id` INT(11) NOT NULL ,
  PRIMARY KEY (`id`) ,
  INDEX `chileclic_tipo_id` (`chileclic_tipo_id` ASC) ,
  CONSTRAINT `chileclic_tema_ibfk_1`
    FOREIGN KEY (`chileclic_tipo_id` )
    REFERENCES `chileatiende`.`chileclic_tipo` (`id` )
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_general_ci;


-- -----------------------------------------------------
-- Table `chileatiende`.`chileclic_subtema`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `chileatiende`.`chileclic_subtema` (
  `id` INT(11) NOT NULL ,
  `nombre` VARCHAR(128) NOT NULL ,
  `chileclic_tema_id` INT(11) NOT NULL ,
  PRIMARY KEY (`id`) ,
  INDEX `chileclic_tema_id` (`chileclic_tema_id` ASC) ,
  CONSTRAINT `chileclic_subtema_ibfk_1`
    FOREIGN KEY (`chileclic_tema_id` )
    REFERENCES `chileatiende`.`chileclic_tema` (`id` )
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_general_ci;


-- -----------------------------------------------------
-- Table `chileatiende`.`ficha_has_chileclic_subtema`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `chileatiende`.`ficha_has_chileclic_subtema` (
  `ficha_id` INT(10) UNSIGNED NOT NULL ,
  `chileclic_subtema_id` INT(11) NOT NULL ,
  PRIMARY KEY (`ficha_id`, `chileclic_subtema_id`) ,
  INDEX `chileclic_subtema_id` (`chileclic_subtema_id` ASC) ,
  CONSTRAINT `ficha_has_chileclic_subtema_ibfk_1`
    FOREIGN KEY (`chileclic_subtema_id` )
    REFERENCES `chileatiende`.`chileclic_subtema` (`id` )
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `ficha_has_chileclic_subtema_ibfk_2`
    FOREIGN KEY (`ficha_id` )
    REFERENCES `chileatiende`.`ficha` (`id` )
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_general_ci;


-- -----------------------------------------------------
-- Table `chileatiende`.`ci_sessions`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `chileatiende`.`ci_sessions` (
  `session_id` VARCHAR(40) NOT NULL DEFAULT '0' ,
  `ip_address` VARCHAR(16) NOT NULL DEFAULT '0' ,
  `user_agent` VARCHAR(120) NOT NULL ,
  `last_activity` INT(10) UNSIGNED NOT NULL DEFAULT '0' ,
  `user_data` TEXT NOT NULL ,
  PRIMARY KEY (`session_id`) ,
  INDEX `last_activity_idx` (`last_activity` ASC) )
ENGINE = MyISAM
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_general_ci;


-- -----------------------------------------------------
-- Table `chileatiende`.`feedback`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `chileatiende`.`feedback` (
  `id` INT(11) NOT NULL AUTO_INCREMENT ,
  `nombre` VARCHAR(45) NOT NULL ,
  `a_paterno` VARCHAR(45) NOT NULL ,
  `a_materno` VARCHAR(45) NOT NULL ,
  `email` VARCHAR(100) NOT NULL ,
  `asunto` VARCHAR(45) NOT NULL ,
  `comentario` TEXT NOT NULL ,
  `enviado` TINYINT(1) NOT NULL ,
  `created_at` DATETIME NOT NULL ,
  `origen` TEXT NOT NULL ,
  PRIMARY KEY (`id`) )
ENGINE = MyISAM
AUTO_INCREMENT = 410
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_general_ci;


-- -----------------------------------------------------
-- Table `chileatiende`.`modulo_atencion`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `chileatiende`.`modulo_atencion` (
  `id` INT(11) NOT NULL AUTO_INCREMENT ,
  `nro_maquina` INT(2) NOT NULL ,
  `descripcion` TEXT NOT NULL ,
  `created_at` DATETIME NOT NULL ,
  `updated_at` DATETIME NOT NULL ,
  `servicio_codigo` VARCHAR(8) NOT NULL ,
  `sector_codigo` VARCHAR(11) NOT NULL ,
  `oficina_id` INT(10) UNSIGNED NOT NULL ,
  PRIMARY KEY (`id`) ,
  INDEX `fk_modulo_atencion_servicio1` (`servicio_codigo` ASC) ,
  INDEX `fk_modulo_atencion_sector1` (`sector_codigo` ASC) ,
  INDEX `fk_modulo_atencion_oficina1` (`oficina_id` ASC) ,
  CONSTRAINT `fk_modulo_atencion_oficina1`
    FOREIGN KEY (`oficina_id` )
    REFERENCES `chileatiende`.`oficina` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_modulo_atencion_sector1`
    FOREIGN KEY (`sector_codigo` )
    REFERENCES `chileatiende`.`sector` (`codigo` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_modulo_atencion_servicio1`
    FOREIGN KEY (`servicio_codigo` )
    REFERENCES `chileatiende`.`servicio` (`codigo` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
AUTO_INCREMENT = 105
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_general_ci;


-- -----------------------------------------------------
-- Table `chileatiende`.`usuario_backend_has_servicio`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `chileatiende`.`usuario_backend_has_servicio` (
  `usuario_backend_id` INT(10) UNSIGNED NOT NULL ,
  `servicio_codigo` VARCHAR(8) CHARACTER SET 'utf8' NOT NULL ,
  PRIMARY KEY (`usuario_backend_id`, `servicio_codigo`) ,
  INDEX `servicio_codigo` (`servicio_codigo` ASC) ,
  CONSTRAINT `usuario_backend_has_servicio_ibfk_2`
    FOREIGN KEY (`servicio_codigo` )
    REFERENCES `chileatiende`.`servicio` (`codigo` )
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `usuario_backend_has_servicio_ibfk_1`
    FOREIGN KEY (`usuario_backend_id` )
    REFERENCES `chileatiende`.`usuario_backend` (`id` )
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB
DEFAULT CHARACTER SET = latin1
COLLATE = utf8_general_ci;


-- -----------------------------------------------------
-- Table `chileatiende`.`beneficio`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `chileatiende`.`beneficio` (
  `id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT ,
  `correlativo` INT(11) NULL DEFAULT NULL ,
  `titulo` VARCHAR(255) NOT NULL ,
  `objetivo` TEXT NOT NULL ,
  `weight` INT(10) UNSIGNED NULL DEFAULT NULL ,
  `beneficiarios` TEXT NULL DEFAULT NULL ,
  `costo` TEXT NULL DEFAULT NULL ,
  `vigencia` TEXT NULL DEFAULT NULL ,
  `plazo` TEXT NOT NULL ,
  `guia_online` TEXT NULL DEFAULT NULL ,
  `guia_online_url` VARCHAR(255) NULL DEFAULT NULL ,
  `guia_oficina` TEXT NULL DEFAULT NULL ,
  `guia_telefonico` TEXT NULL DEFAULT NULL ,
  `guia_correo` TEXT NULL DEFAULT NULL ,
  `marco_legal` TEXT NULL DEFAULT NULL ,
  `doc_requeridos` TEXT NULL DEFAULT NULL ,
  `maestro` TINYINT(1) NOT NULL ,
  `publicado` TINYINT(1) NOT NULL ,
  `publicado_at` DATETIME NULL DEFAULT NULL ,
  `locked` TINYINT(1) NOT NULL DEFAULT '0' ,
  `estado` VARCHAR(16) NULL DEFAULT NULL ,
  `estado_justificacion` TEXT NULL DEFAULT NULL ,
  `actualizable` TINYINT(1) NULL DEFAULT NULL ,
  `destacado` TINYINT(1) NOT NULL DEFAULT '0' ,
  `created_at` DATETIME NULL DEFAULT NULL ,
  `updated_at` DATETIME NULL DEFAULT NULL ,
  `genero_id` INT(11) NULL DEFAULT NULL ,
  `convenio` TINYINT(1) NULL DEFAULT '0' ,
  `estado_mds` ENUM('en_chileatiende','en_mds','aprobado_mds','rechazado_mds') NULL DEFAULT 'en_chileatiende' ,
  `comentarios` TEXT NOT NULL ,
  `tipo` TINYINT(4) NOT NULL ,
  `keywords` VARCHAR(255) NULL DEFAULT NULL ,
  `sic` VARCHAR(255) NULL DEFAULT NULL ,
  `servicio_codigo` VARCHAR(8) NOT NULL ,
  `maestro_id` INT(10) UNSIGNED NULL ,
  PRIMARY KEY (`id`) ,
  UNIQUE INDEX `codigo` (`correlativo` ASC) ,
  INDEX `fk_beneficio_servicio1` (`servicio_codigo` ASC) ,
  INDEX `fk_beneficio_beneficio1` (`maestro_id` ASC) ,
  CONSTRAINT `fk_beneficio_servicio1`
    FOREIGN KEY (`servicio_codigo` )
    REFERENCES `chileatiende`.`servicio` (`codigo` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_beneficio_beneficio1`
    FOREIGN KEY (`maestro_id` )
    REFERENCES `chileatiende`.`beneficio` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_general_ci;


-- -----------------------------------------------------
-- Table `chileatiende`.`beneficio_has_tema`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `chileatiende`.`beneficio_has_tema` (
  `beneficio_id` INT(10) UNSIGNED NOT NULL ,
  `tema_id` INT(10) UNSIGNED NOT NULL ,
  PRIMARY KEY (`beneficio_id`, `tema_id`) ,
  INDEX `fk_beneficio_has_tema_tema1` (`tema_id` ASC) ,
  CONSTRAINT `fk_beneficio_has_tema_beneficio1`
    FOREIGN KEY (`beneficio_id` )
    REFERENCES `chileatiende`.`beneficio` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_beneficio_has_tema_tema1`
    FOREIGN KEY (`tema_id` )
    REFERENCES `chileatiende`.`tema` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_general_ci;


-- -----------------------------------------------------
-- Table `chileatiende`.`beneficio_has_tag`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `chileatiende`.`beneficio_has_tag` (
  `beneficio_id` INT(10) UNSIGNED NOT NULL ,
  `tag_id` INT(10) UNSIGNED NOT NULL ,
  PRIMARY KEY (`beneficio_id`, `tag_id`) ,
  INDEX `fk_beneficio_has_tag_tag1` (`tag_id` ASC) ,
  CONSTRAINT `fk_beneficio_has_tag_beneficio1`
    FOREIGN KEY (`beneficio_id` )
    REFERENCES `chileatiende`.`beneficio` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_beneficio_has_tag_tag1`
    FOREIGN KEY (`tag_id` )
    REFERENCES `chileatiende`.`tag` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `chileatiende`.`beneficio_has_hecho_vida`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `chileatiende`.`beneficio_has_hecho_vida` (
  `beneficio_id` INT(10) UNSIGNED NOT NULL ,
  `hecho_vida_id` INT(10) UNSIGNED NOT NULL ,
  PRIMARY KEY (`beneficio_id`, `hecho_vida_id`) ,
  INDEX `fk_beneficio_has_hecho_vida_hecho_vida1` (`hecho_vida_id` ASC) ,
  CONSTRAINT `fk_beneficio_has_hecho_vida_beneficio1`
    FOREIGN KEY (`beneficio_id` )
    REFERENCES `chileatiende`.`beneficio` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_beneficio_has_hecho_vida_hecho_vida1`
    FOREIGN KEY (`hecho_vida_id` )
    REFERENCES `chileatiende`.`hecho_vida` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `chileatiende`.`beneficio_has_rango_edad`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `chileatiende`.`beneficio_has_rango_edad` (
  `beneficio_id` INT(10) UNSIGNED NOT NULL ,
  `rango_edad_id` INT(11) NOT NULL ,
  PRIMARY KEY (`beneficio_id`, `rango_edad_id`) ,
  INDEX `fk_beneficio_has_rango_edad_rango_edad1` (`rango_edad_id` ASC) ,
  CONSTRAINT `fk_beneficio_has_rango_edad_beneficio1`
    FOREIGN KEY (`beneficio_id` )
    REFERENCES `chileatiende`.`beneficio` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_beneficio_has_rango_edad_rango_edad1`
    FOREIGN KEY (`rango_edad_id` )
    REFERENCES `chileatiende`.`rango_edad` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `chileatiende`.`beneficio_historial`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `chileatiende`.`beneficio_historial` (
  `id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT ,
  `beneficio_id` INT(10) UNSIGNED NOT NULL ,
  `beneficio_version_id` INT(10) UNSIGNED NOT NULL ,
  `usuario_backend_id` INT(10) UNSIGNED NOT NULL ,
  `descripcion` TEXT NOT NULL ,
  `created_at` DATETIME NULL ,
  `updated_at` VARCHAR(45) NULL ,
  PRIMARY KEY (`id`) ,
  INDEX `fk_beneficio_historial_beneficio1` (`beneficio_id` ASC) ,
  INDEX `fk_beneficio_historial_beneficio2` (`beneficio_version_id` ASC) ,
  INDEX `fk_beneficio_historial_usuario_backend1` (`usuario_backend_id` ASC) ,
  CONSTRAINT `fk_beneficio_historial_beneficio1`
    FOREIGN KEY (`beneficio_id` )
    REFERENCES `chileatiende`.`beneficio` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_beneficio_historial_beneficio2`
    FOREIGN KEY (`beneficio_version_id` )
    REFERENCES `chileatiende`.`beneficio` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_beneficio_historial_usuario_backend1`
    FOREIGN KEY (`usuario_backend_id` )
    REFERENCES `chileatiende`.`usuario_backend` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_general_ci;



SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
