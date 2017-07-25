<?php
require_once 'dbini.php';

if(isset($_POST['file_id']))
{
	$file_id = $_POST['file_id'];

	$query = $pdo->prepare("select * from file_contents where file_id = :id");
	$query->execute(array('id'=>$file_id));
	$tableData = $query->setFetchMode(PDO::FETCH_NUM);
	$tableData = $query->fetchAll();

	//var_dump($tableData);
}
echo '<table class="table table-striped">';
echo '<thead >';
echo '<tr class ="info">';
echo '<th>'.'Pirmas'.'</th>';
echo '<th>'.'Antras'.'</th>';
echo '<th>'.'Trečias'.'</th>';
echo '<th>'.'Ketvirtas'.'</th>';
echo '<th></th>';
echo '</tr>';
echo '</thead>';

for ($i = 0; $i < count($tableData); $i++)
{
	echo '<tr>';

	for ($j = 1; $j < count($tableData[$i])-1; $j++)
		echo '<td id="u'.$tableData[$i][0].'_'.($j-1).'" contenteditable>'.htmlspecialchars($tableData[$i][$j]).'</td>';
	echo'<td><button type="button" id="d'.$tableData[$i][0].'" class="close" name="deleteBtn" aria-label="Close">
  <span aria-hidden="true">&times;</span>
</button></td>';

	echo '</tr>';

} 
echo '</table>';

?>

<script>
$('[name=deleteBtn]').on('click',
	function()
	{	
		var row_id = this.id;
		row_id = row_id.substr(1); 

		if(confirm('Ar tikrai norite ištrinti šią eilutę?'))
		{


		$.post('deleteRow.php',{row_id:row_id},
			function()
			{
				buildTable(file_id);
			});
	}
		

	});

$('table').on('blur','[contenteditable]',function()
	{
		//alert(this.id);
		var row_id = this.id;
		row_id  = row_id.substr(1);
		var text = $(this).text();
		$.post('updateRow.php',{row_id:row_id, text:text},
			function()
			{
				buildTable(file_id);
			});
			
	});

$('table').on('keydown','[contenteditable]',function(e)
	{
		if(e.keyCode ==13)
		{
			e.preventDefault();
		var row_id = this.id;
		row_id  = row_id.substr(1);
		var text = $(this).text();
		$.post('updateRow.php',{row_id:row_id, text:text},
			function()
			{
				buildTable(file_id);
			});
	}
			
	});

</script>
