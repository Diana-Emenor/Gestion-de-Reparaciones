<?php
	require_once '../DB_Functions.php';
	
	$Table = "";
	$Usuario = $_POST["Usuario"];
	$DB = new DB_Functions();
	$object = array();

	$data = $DB->ObtenerDatosdeTabla($Usuario);
	if(!$data) {
		$object[0] = 'Error';
		echo json_encode($object);
	}
	
	foreach($data as $row) {
		$table.="<tr>";
		$index = 0;
		foreach($row as $cell) {
			if($index<5) {
				$table.="<td>{$cell}</td>";
			} else {
				$table.="<td>Descargar</td>";
			}
			$index++;
		}
		$table.="</tr>";
		$object[] = $table;
		$table="";
	}
	echo json_encode($object);
?>