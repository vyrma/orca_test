<?php
require_once 'dbini.php';

if(isset($_POST['row_id']) && isset($_POST['text']))
{

	$ids = explode('_',$_POST['row_id']);

	if(count($ids) == 2)
	{ 
	$row_id = $ids[0];
	$column_id = $ids[1];

	switch($column_id)
	{
		case 0:
			$column = 'pirmas';
		break;
		case 1:
		$column = 'antras';

		break;
		case 2:
		$column = 'trecias';

		break;
		case 3:
		$column = 'ketvirtas';

		break;
	}
	$dataString =$_POST['text'];



	$query = $pdo->prepare("update file_contents SET $column = :string where id = :id");
	$query->execute(array('string'=>$dataString,'id'=>$row_id));

	}
}