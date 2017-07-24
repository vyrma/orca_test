<?php

$dbHost="localhost";
$dbName="orcadb";
$dbUsername="root";
$dbPassword="";

try
{
	$pdo = new PDO("mysql:host=$dbHost;",$dbUsername,$dbPassword,
		array(PDO::MYSQL_ATTR_LOCAL_INFILE => true,
			PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
			PDO::MYSQL_ATTR_INIT_COMMAND=>"SET NAMES utf8")
		);

	$pdo->query("CREATE DATABASE IF NOT EXISTS $dbName CHARACTER SET UTF8");
	$pdo->query("use $dbName");
	$pdo->query("create table IF NOT EXISTS files(
		id INT(6) AUTO_INCREMENT PRIMARY KEY,
		filename TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP)");

	$pdo->query("create table IF NOT EXISTS file_contents(
		id INT(6) AUTO_INCREMENT PRIMARY KEY,
		pirmas varchar(1000) NULL,
		antras varchar(1000) NULL,
		trecias varchar(1000) NULL,
		ketvirtas varchar(1000) NULL,
		file_id INT(6),
		FOREIGN KEY (file_id) REFERENCES files(id))");

} catch(PDOException $e)
{
	die("Klaida: <br>".$e->getMessage());
}


?>