<?php
header('Content-type: text/html; charset=utf-8');
require_once 'dbini.php';
?>
<!DOCTYPE html>
<html>
<head>
	<title>PHP užduotis</title>
	<link rel="stylesheet" href="lib/css/bootstrap.min.css">
</head>
<body style="margin: 10px; padding:10px">

	<div class="page-header">
		<h1 class="text-center">Testinė užduotis</h1>
	</div>

	<div class="container">
		<div class="row">
			<div class="col-md-3" style="padding-bottom:10px">
				<form action="" method="post" enctype="multipart/form-data">
					<label class="btn btn-primary" for="fileID">
						<input id="fileID" type="file" style="display:none;" name="csvFile" accept=".csv"
						onchange = "$('#fileInfo').html(this.files[0].name)">
						Pasirinkite failą
					</label>
					<span class="label label-info" id="fileInfo"></span>
					<button class="btn btn-success" type="submit" name="submit">Įkelti</button>
				</form>	
			</div>
			<div class = "col-md-6" id="table">
			</div>
			<div class="col-md-3" id="archivePanel">
			</div>
		</div>
		<script src="lib/js/jquery-3.2.1.min.js"></script>
		<script src="lib/js/bootstrap.min.js"></script>


		<script src="lib/js/eventListeners.js"></script>

		<?php
		if(isset($_POST["submit"]))
		{

			if(empty($_FILES['csvFile']['tmp_name']))
			{
				Message('Įkelkite failą!','danger','Klaida!');
				return;
			}
			$warning = false;
			$inputFile = $_FILES['csvFile'];

			$tmpFileName = addslashes($inputFile['tmp_name']);
			$extension = strtolower(pathinfo($inputFile['name'], PATHINFO_EXTENSION));

			if($extension != 'csv')
			{
				Message('Failo formatas privalo būti .csv', 'danger', 'Klaida!');
				return;
			}

	/*if($inputFile['size'] > 500)
	{
		Message('Failas per didelis, maksimalus dydis 500MB','danger','Klaida!');
		return;
	}
	*/
	
	$handle = fopen($tmpFileName,'r');
	$contents = array();
	$pdo->exec("Insert into files VALUES()");
	$archive_id = $pdo->lastInsertId();
	$sql ='INSERT into file_contents (pirmas, antras, trecias, ketvirtas, file_id) VALUES ';
	if($firstline = fgetcsv($handle,'0','|'))
	{
		if(count($firstline) != 4)
		{
			Message('Stulpelių kiekis netinkamas patikrinkite .csv failą', 'danger', 'Klaida!');
			return;
		}
		$firstline = array_map('mb_strtolower',$firstline);
		if($firstline[0] == 'pirmas' && $firstline[1] == 'antras' && ($firstline[2] == 'trečias' || $firstline[2] == 'trecias') && $firstline[3] =='ketvirtas')
		{
			
		}
		else{
			$contents = array_merge($contents, $firstline);
			array_push($contents,$archive_id);
			$sql .= '(?,?,?,?,?),';
		}
	}
			
	while($line = fgetcsv($handle,'0','|'))
	{
		if(count($line) == 4)
		{
			$contents = array_merge($contents, $line);
			array_push($contents,$archive_id);
			$sql .= '(?,?,?,?,?),';
		}
		else $warning = true;
	}

	$sql = rtrim($sql,',');
	$prep = $pdo->prepare($sql);

	try{

		$prep->execute($contents);

		echo "<script>buildTable(".$archive_id.");</script>";
		echo "<script>buildArchive();</script>";

		if($warning)
			Message('Nevisos eilutės buvo įkeltos patikrinkite .csv failą','warning','');
		Message('Failas įkeltas sėkmingai!','success','');


	}catch(PDOException $e)
	{
		$query = $pdo->prepare("delete from files where id = :id");
		$query->execute(array('id'=>$archive_id));
		Message('Nepavyko įkelti failo', 'danger', 'Klaida!');
	}
}


function Message($text, $type, $strongText)
{	
	echo '<div class= "alert alert-'.$type.' alert-dismissable">';
	echo '<a href="#" class="close" data-dismiss="alert" arria-label="close">&times;</a>';
	echo "<strong>$strongText </strong>";
	echo $text;
	echo '</div>';
}

?>
</div>

</body>
</html>
