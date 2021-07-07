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
	$Concepto = str_replace('"', "''", $_POST["Concepto"]);
	$Costo = $_POST["Costo"];
	$Dias = $_POST["Dias"];
	$Garantia = str_replace('"', "''", $_POST["Garantia"]);
	$FechaGarantia = date_format(date_create($_POST["Fecha"]), 'Y/m/d');
	$Fecha = $_POST["FechaActual"];
	$anchoimagen = $_POST["Ancho"];
	/* //Camino a Archivo local, metodo no usado ahora
	$fi = new FilesystemIterator("../Archives/", FilesystemIterator::SKIP_DOTS);
	$id = iterator_count($fi);
	*/
	$header = array('Concepto del servicio prestado', 'Costo');
	
	//Manipulación de la Base de Datos
	if(!$db->ExisteClientePorNombre($Nombre, $Apellido) && !$db->ExisteClientePorTelefono($Telefono1)) {
		$idcliente = $db->AñadirCliente($Nombre, $Apellido, $Direccion, $Telefono1, $Telefono2);
	} else {
		$idcliente = $db->IDCliente($Nombre, $Apellido, $Telefono1);
	}
	//Versión sin producto asociado
	$id = $db->AñadirGarantia($FechaGarantia, $Dias, $Concepto, $Costo, $Garantia, $idcliente, 1);
	
	$Direccionarchivo = "{$id}-{$Nombre} {$Apellido}.pdf";

	//Creación del documento PDF
	$pdf->AddFont('A2','','arial.php');
	$pdf -> AddPage();
	$pdf -> SetFont('A2', '', 11);
	$InitialX = ($pdf->GetPageWidth()/2) - ($anchoimagen/2.5);
	$pdf -> Image('http://notas.taller//img/Imagen4.png', abs(intval($InitialX)), null, 0, 0); //La url de la imagen deberá ser cambiado una vez se ponga en la web
	//$pdf -> Image('https://notas-taller.000webhostapp.com//img/Imagen4.png', abs(intval($InitialX)), null, 0, 0); //Version de producción
	$pdf->Ln();
	$pdf->Cell(0, 12, iconv('utf-8', 'ISO-8859-15', "Soporte Técnico y Reparaciones."), 0, 0, 'C');
	$pdf->Ln();
	$pdf->Cell(0, 12, iconv('utf-8', 'ISO-8859-15', "Manuel J. Clouthier. # 46 San Jerónimo Chicahualco, Metepec, Estado de México"), 0, 0, 'C');
	$pdf->Ln();
	$pdf->Cell(0, 12, iconv('utf-8', 'ISO-8859-15', "Técnico JAred Solis 729-26-41-466"), 0, 0, 'C');
	$pdf->Ln();
	$pdf->Ln();
	$pdf->Cell(0, 12, iconv('utf-8', 'ISO-8859-15', "Cliente: " . $Nombre . ' ' . $Apellido), 0, 0, 'C');
	$pdf->Ln();
	$pdf->Cell(0, 12, iconv('utf-8', 'ISO-8859-15', "Dirección: " . $Direccion), 0, 0, 'C');
	$pdf->Ln();
	$pdf->Cell(0, 12, iconv('utf-8', 'ISO-8859-15', "Teléfono: " . $Telefono1), 0, 0, 'C');
	$pdf->Ln();
	$Concepto2 = iconv('utf-8', 'ISO-8859-15', $Concepto);
	$arraya = $Concepto2 . ';$' . $Costo;
	$pdf->BasicTable($header, Array(explode(';', $arraya)));
	$pdf->Ln();
	$pdf->Ln();
	$pdf->Cell(0, 12, iconv('utf-8', 'ISO-8859-15', "Garantía"), 0, 0, 'C');
	$pdf->Ln();
	$pdf->MultiCell(0, 12, iconv('utf-8', 'ISO-8859-15', "El servicio prestado tiene una garantia de: {$Dias} días a partir del día {$FechaGarantia}. La garantia cubre: {$Garantia}"));
	$pdf->AddPage('L');
	$pdf->Image('http://notas.taller//img/Tarjeta-Alfredo-1.jpg', 0, 0, $pdf->GetPageWidth(), $pdf->GetPageHeight());
	//$pdf->Image('https://notas-taller.000webhostapp.com//img/Tarjeta-Alfredo-1.jpg', 0, 0, $pdf->GetPageWidth(), $pdf->GetPageHeight()); //Ver. producción
	$pdf->AddPage('L');
	$pdf->Image('http://notas.taller//img/Tarjeta-Alfredo-2.jpg', 0, 0, $pdf->GetPageWidth(), $pdf->GetPageHeight());
	//$pdf->Image('https://notas-taller.000webhostapp.com//img/Tarjeta-Alfredo-2.jpg', 0, 0, $pdf->GetPageWidth(), $pdf->GetPageHeight()); //Ver. Producción
	
	$pdf->Output('F', "../../Archives/{$Direccionarchivo}");
	
	/* Solo necesario en caso de no contar con una base de datos con SQL
	$database = fopen("../database.txt", "a+") or die("Unable to open file!");
	fwrite($database, "{$id};{$Nombre . ' ' . $Apellido};{$Telefono1};{$date};{$Direccionarchivo}"."\r\n");
	fclose($database);
	*/
	echo "{$Direccionarchivo}";
?>