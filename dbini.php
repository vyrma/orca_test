<?php
$dbHost="localhost";
$dbName="orcadb";
$dbUsername="root";
$dbPassword="";

try
{
	$pdo = new PDO("mysql:host=$dbHost;dbname=$dbName",$dbUsername,$dbPassword,
		array(PDO::MYSQL_ATTR_LOCAL_INFILE => true,
			PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
			PDO::MYSQL_ATTR_INIT_COMMAND=>"SET NAMES utf8")
		);

} catch(PDOException $e)
{
	die("Nepavyko prisijungti prie DB: <br>".$e->getMessage());
}