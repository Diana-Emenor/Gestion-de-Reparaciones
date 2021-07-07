<?php
	require_once '../DB_Functions.php';
	require_once '../PDF.php';

	$db = new DB_Functions();
	$pdf = new PDF(); 
	
	$idg = $_POST["IDGarantia"];
	$idc = $_POST["IDCliente"];
	
	$header = array('Concepto del servicio prestado', 'Costo');
	
	//Manipulación de la Base de Datos
	$Garantia = $db -> ObtenerGarantia($idg);
	$Cliente = $db -> ObtenerCliente($idc);
	
	//Equivalencias
	$Nombre = $Cliente[1];
	$Apellido = $Cliente[2];
	$Direccion = $Cliente[5];
	$Telefono1 = $Cliente[3];
	$Concepto = $Garantia[3];
	$Costo = $Garantia[4];
	$Dias = $Garantia[2];
	$FechaGarantia = $Garantia[1];
	$Garantias = $Garantia[5];
	$Fecha = $_POST["FechaActual"];
	$anchoimagen = $_POST["Ancho"];
	
	
	$Direccionarchivo = "{$idg}-{$Nombre} {$Apellido}.pdf";

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
	$pdf->Cell(0, 12, iconv('utf-8', 'ISO-8859-15', "Mariano Matamoros N.Ext 13 N.Int 4 en San José Guadalupe, Toluca, Estado de México."), 0, 0, 'C');
	$pdf->Ln();
	$pdf->Cell(0, 12, iconv('utf-8', 'ISO-8859-15', "Técnico Alfredo Solis 56-11-03-76-71"), 0, 0, 'C');
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
	$pdf->MultiCell(0, 12, iconv('utf-8', 'ISO-8859-15', "El servicio prestado tiene una garantia de: {$Dias} días a partir del día {$FechaGarantia}. La garantia cubre: {$Garantias}"));
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