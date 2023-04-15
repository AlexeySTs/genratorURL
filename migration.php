<?php

// Файл настроек
$setting = require_once 'setting.php';
$db_name = $setting['DB']['database'];
    
// Подключение к БД
$link = mysqli_connect($setting['DB']['host'], $setting['DB']['login'], $setting['DB']['password'], $setting['DB']['database']);

// Создание нужных таблиц
mysqli_query($link, "CREATE TABLE `$db_name`.`url_list` 
    ( `id` INT NOT NULL AUTO_INCREMENT , 
    `url` VARCHAR(2083) NOT NULL , 
    `user_id` INT NULL DEFAULT NULL , 
    `count` INT NOT NULL DEFAULT '0' , 
    PRIMARY KEY (`id`)) ENGINE = InnoDB");

mysqli_query($link, "CREATE TABLE `$db_name`.`users` 
    ( `id` INT NOT NULL AUTO_INCREMENT ,
    `email` VARCHAR(320) NOT NULL ,
    `password` VARCHAR(255) NOT NULL ,
    PRIMARY KEY (`id`),
    UNIQUE (`email`)) ENGINE = InnoDB");

echo 'Таблицы успешно созданы';
?>