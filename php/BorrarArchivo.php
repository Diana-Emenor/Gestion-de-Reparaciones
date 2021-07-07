<?php
	$archivo = "../Archives/{$_POST['Archivo']}";
	
	echo unlink($archivo);
?>