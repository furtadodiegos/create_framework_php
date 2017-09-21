<?php

//use Config;

$databaseName = 'desafio_grgi';
$databaseUser = 'root';
$databasePassword = 'foo';

/*
 * Criando o banco de dados
 */
$pdoDatabase = new \PDO('mysql:host=localhost', $databaseUser, $databasePassword);
$pdoDatabase->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$pdoDatabase->exec('CREATE DATABASE IF NOT EXISTS desafio_grgi');

/*
 * Criando as tabelas
 */
$pdo = new PDO('mysql:host=localhost;dbname='.$databaseName, $databaseUser, $databasePassword);
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// initialize the table
$pdo->exec('SET FOREIGN_KEY_CHECKS = 0');

$pdo->exec('DROP TABLE IF EXISTS contato;');

$pdo->exec('
    CREATE TABLE `desafio_grgi`.`contato` (
      `id` INT NOT NULL AUTO_INCREMENT,
      `str_nome` VARCHAR(255) NOT NULL,
      PRIMARY KEY (`id`),
      UNIQUE INDEX `str_nome_UNIQUE` (`str_nome` ASC))
');

/*
 * Populando a tabela contato
 */
$pdo->exec('
    INSERT INTO contato
      (str_nome) VALUES ("Mario")
      ');

$pdo->exec('
    INSERT INTO contato
      (str_nome) VALUES ("peach")
      ');

$pdo->exec('
    INSERT INTO contato
      (str_nome) VALUES ("Luigi")
');

$pdo->exec('DROP TABLE IF EXISTS telefone;');

$pdo->exec('
    CREATE TABLE `desafio_grgi`.`telefone` (
      `id` INT NOT NULL AUTO_INCREMENT,
      `cod_contato` INT NOT NULL,
      `num_celular` VARCHAR(45) NOT NULL,
      `num_residencial` VARCHAR(45) NOT NULL,
      PRIMARY KEY (`id`),
      INDEX `fk_telefone_contato_idx` (`cod_contato` ASC),
        CONSTRAINT `fk_telefone_contato`
            FOREIGN KEY (`cod_contato`)
            REFERENCES `desafio_grgi`.`contato` (`id`)
            ON DELETE NO ACTION
            ON UPDATE NO ACTION)
');

$pdo->exec('
    INSERT INTO telefone
      (cod_contato, num_telefone) VALUES (1, "9298-2577")
');

$pdo->exec('
    INSERT INTO telefone
      (cod_contato, num_telefone) VALUES (1, "9298-9982")
');

$pdo->exec('
    INSERT INTO telefone
      (cod_contato, num_telefone) VALUES (2, "9298-2019")
');

$pdo->exec('
    INSERT INTO telefone
      (cod_contato, num_telefone) VALUES (3, "9298-1920")
');

$pdo->exec('SET FOREIGN_KEY_CHECKS = 1');

echo "Ding!\n";
