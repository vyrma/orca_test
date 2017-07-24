<?php
require_once 'dbini.php';

try{
$archiveData = $pdo->prepare('select * from files');
$archiveData->execute();
$archiveData = $archiveData->fetchAll();

if(!empty($archiveData))
{
	echo '<div class = "panel panel-primary">';
	echo '<div class="panel-heading">';
	echo '<h3>Archyvas</h3>';
	echo '</div>';
		//echo '<div class="panel-body">';
	echo '<ul class="list-group">';

	for ($i = 0; $i < count($archiveData); $i++)
	{
		echo '<li class="list-group-item text-center"><a href="#" id="a'.$archiveData[$i][0].'" class="archiveItem">'.$archiveData[$i][1].'</a></li>';
	}
	echo '</ul>';
	echo '</div>';
}
}catch(PDOException $e)
{
}
?>
