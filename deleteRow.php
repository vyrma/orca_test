<?php
require_once 'dbini.php';

if(isset($_POST['row_id']))
{
	$query = $pdo->prepare("delete from file_contents where id = :id");
	$query->execute(array('id'=>$_POST['row_id']));

}