<?php
$fileroute="../database.txt";
$table="";
$file = file($fileroute);
$data = array();
foreach($file as $line){
	$data[] = explode(';', trim($line));
}
$object = array();
foreach($data as $row) {
	$table.="<tr>";
	foreach($row as $cell) {
		if(strpos($cell, 'pdf')===false) {
			$table.="<td>{$cell}</td>";
		} else {
			$table.="<td><a href='./Archives/{$cell}'>Descargar</a></td>";
		}
	}
	$table.="</tr>";
	$object[] = $table;
	$table="";
}
echo json_encode($object);
?>