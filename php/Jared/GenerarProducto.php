<?php
	require_once '../DB_Functions.php';
	require_once '../PDF.php';

	$db = new DB_Functions();
	$pdf = new PDF();
	$Nombre = $_POST["Nombre"];
	$Apellido = $_POST["Apellido"];
	$Direccion = str_replace('"', "''", $_POST["Direccion"]);
	$Telefono1 = $_POST["Telefono1"];
	$Telefono2 = $_POST["Telefono2"];
	$Servicio = str_replace('"', "''", $_POST["Servicio"]);
	$Anticipado = $_POST["Anticipado"];
	$Tipo = $_POST["Tipo"];
	$Marca = $_POST["Marca"];
	$Modelo = $_POST["Modelo"];
	$Fallo = str_replace('"', "''", $_POST["Fallo"]);
	$Cable = $_POST["Cable"];
	if($_POST["Cable"] == 'true'){
		$Cable = 1;
	} else {
		$Cable = 0;
	}
	$Control = $_POST["Control"];
	$Caracteristicas = $_POST["Caracteristicas"];
	$General = $_POST["General"];
	$Fecha = $_POST["FechaActual"];
	$anchoimagen = $_POST["Ancho"];
	$idcliente = 0;
	/* //Camino a Archivo local, metodo no usado ahora
	$fi = new FilesystemIterator("../Archives/", FilesystemIterator::SKIP_DOTS);
	$id = iterator_count($fi);
	*/
	
	//Manipulación de la Base de Datos
	$id=$db->ObtenerIDProducto();
	if(!$db->ExisteClientePorNombre($Nombre, $Apellido) && !$db->ExisteClientePorTelefono($Telefono1)) {
		$idcliente = $db->AñadirCliente($Nombre, $Apellido, $Direccion, $Telefono1, $Telefono2);
	} else {
		$idcliente = $db->IDCliente($Nombre, $Apellido, $Telefono1);
	}
	$db->AñadirProducto($Tipo, $Marca, $Modelo, $idcliente, $Anticipado, $Fallo, $Control, $Cable, $Caracteristicas, null, 0, $Fecha, $Servicio);
	
	$Direccionarchivo = "Recibo-{$id}-{$Nombre}-{$Apellido}.pdf";
	
	
	$Data1 = array();
	$Data1[0] = array("Cliente", $Nombre . ' ' . $Apellido);
	$Data1[1] = array("Dirección", $Direccion);
	$Data1[2] = array("Telefono", $Telefono1);
	if($Telefono2 == '') {
		$Data1[3] = array("Telefono 2", "No tiene");
	} else {
		$Data1[3] = array("Telefono 2", $Telefono2);
	}
	
	$Data2 = array();
	$Data2[0] = array("Tipo de Servicio", $Servicio);
	$Data2[1] = array("Pago Anticipado", $Anticipado);
	$Data2[2] = array("Fecha", $Fecha);
	
	$Data3 = array();
	$Data3[0] = array("Tipo", $Tipo);
	if($Marca == '') {
		$Data3[1] = array("Marca", "Sin Marca");
	} else {
		$Data3[1] = array("Marca", $Marca);
	}
	if($Modelo == '') {
		$Data3[2] = array("Modelo", "Sin Modelo");
	} else {
		$Data3[2] = array("Modelo", $Modelo);
	}
	$Data3[3] = array("Fallo", $Fallo);
	if($Cable == 1) {
		$Data3[4] = array("Cable", "Si contiene cable");
	} else {
		$Data3[4] = array("Cable", "No contiene cable");
	}
	if($Control == '') {
		$Data3[5] = array("Control", "Sin control");
	} else {
		$Data3[5] = array("Control", $Control);
	}
	$Data3[6] = array("Otros", $Caracteristicas);
	
	//Creación del documento PDF
	$pdf->AddFont('A2','','arial.php');
	$pdf -> AddPage();
	$pdf -> SetFont('A2', '', 11);
	$InitialX = ($pdf->GetPageWidth()/2) - ($anchoimagen/2.5);
	$pdf->Cell(0, 12, iconv('utf-8', 'ISO-8859-15', "{$Fecha}."), 0, 0, 'L');
	$pdf->SetX(100);
	$pdf->Cell(0, 12, iconv('utf-8', 'ISO-8859-15', "Folio: {$id}"), 0, 0, 'L');
	$pdf->SetX(0);
	$pdf->ln();
	$pdf -> Image('http://notas.taller//img/Imagen4.png', abs(intval($InitialX)), null, 0, 0); //La url de la imagen deberá ser cambiado una vez se ponga en la web
	//$pdf -> Image('https://notas-taller.000webhostapp.com//img/Imagen4.png', abs(intval($InitialX)), null, 0, 0); //Version de producción
	$pdf->ln(0);
	$pdf->Cell(0, 12, iconv('utf-8', 'ISO-8859-15', "Soporte Técnico y Reparaciones."), 0, 0, 'C');
	$pdf->ln(6);
	$pdf->Cell(0, 12, iconv('utf-8', 'ISO-8859-15', "Recibo de dispositivo."), 0, 0, 'C');
	$pdf->ln();
	$pdf->Table($Data1);
	$pdf->ln();
	$pdf->Table($Data2);
	$pdf->ln();
	$pdf->Table($Data3);
	$pdf->ln();
	$pdf->SetLineWidth(3);
	$pdf->MultiCellMod(0, 12, iconv('utf-8', 'ISO-8859-15', $General));
	$pdf->ln(6);
	$pdf->Cell(0, 12, iconv('utf-8', 'ISO-8859-15', "Encargado: Jared Solís"), 0, 0, 'C');
	$pdf->ln(6);
	$pdf->Cell(0, 12, iconv('utf-8', 'ISO-8859-15', "Técnico principal."), 0, 0, 'C');
	//Preguntar si quiere imagen en este apartado
	/*
	$pdf->AddPage('L');
	$pdf->Image('http://notas.taller//img/Tarjeta-Alfredo-1.jpg', 0, 0, $pdf->GetPageWidth(), $pdf->GetPageHeight());
	//$pdf->Image('https://notas-taller.000webhostapp.com//img/Tarjeta-Alfredo-1.jpg', 0, 0, $pdf->GetPageWidth(), $pdf->GetPageHeight()); //Ver. producción
	$pdf->AddPage('L');
	$pdf->Image('http://notas.taller//img/Tarjeta-Alfredo-2.jpg', 0, 0, $pdf->GetPageWidth(), $pdf->GetPageHeight());
	//$pdf->Image('https://notas-taller.000webhostapp.com//img/Tarjeta-Alfredo-2.jpg', 0, 0, $pdf->GetPageWidth(), $pdf->GetPageHeight()); //Ver. Producción
	*/
	
	$pdf->Output('F', "../../Archives/{$Direccionarchivo}");
	
	/* Solo necesario en caso de no contar con una base de datos con SQL
	$database = fopen("../database.txt", "a+") or die("Unable to open file!");
	fwrite($database, "{$id};{$Nombre . ' ' . $Apellido};{$Telefono1};{$date};{$Direccionarchivo}"."\r\n");
	fclose($database);
	*/
	echo "{$Direccionarchivo}";
?>