<?php

class Admin_Model_DbTable_Materias extends Zend_Db_Table_Abstract
{

    protected $_name = 'materias';
    protected $_primary = 'idMateria';
    
    /*
    CREATE TABLE IF NOT EXISTS `app_nutricao`.`materias` (
    `idMateria` INT ZEROFILL NOT NULL AUTO_INCREMENT,
    `titulo` VARCHAR(100) NOT NULL,
    `descricao` TEXT NOT NULL,
    `texto` LONGTEXT NOT NULL,
    `autor` INT NULL,
    `dtInclusao` DATE NULL,
    `dtAlteracao` DATE NULL,
    `patrocinador` INT NULL,
    `usrAlterou` INT NULL,
    `tag` VARCHAR(45) NULL,
    `thumb` INT ZEROFILL NULL,
    PRIMARY KEY (`idMateria`),
    UNIQUE INDEX `idMateria_UNIQUE` (`idMateria` ASC),
    INDEX `fk_materias_img_idx` (`thumb` ASC),
    CONSTRAINT `fk_materias_img`
    FOREIGN KEY (`thumb`)
    REFERENCES `app_nutricao`.`imagens` (`idImagens`)
    */


}

