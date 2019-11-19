<?php

//database_connection.php $connect = new PDO("mysql:host=srv-pleskdb41.ps.kz:3306;dbname=digita30_socol", "digit_sokoluser", "In017em?");

// $connect = new PDO("mysql:host=localhost:3306;dbname=fastfriday", "root", "");
$connect = new PDO("mysql:host=91.201.214.132:3306;dbname=friday;charset=utf8", "alysu", "123");

$connect->exec('SET NAMES utf8');


?>