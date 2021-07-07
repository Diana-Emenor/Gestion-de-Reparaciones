<?php
	require_once '../DB_Functions.php';
	
	$Table = "";
	$Usuario = 1;
	$DB = new DB_Functions();
	$object = array();

	$data = $DB->ObtenerDatosdeTablaProducto($Usuario);
	if(!$data) {
		$object[0] = 'Error';
		echo json_encode($object);
	}
	
	foreach($data as $row) {
		$Table.="<tr>";
		foreach($row as $cell) {
			$Table.="<td>{$cell}</td>";
		}
		$Table.="</tr>";
		$object[] = $Table;
		$Table="";
	}
	echo json_encode($object);
?>