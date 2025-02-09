<?php
	require("fpdf.php");
	require_once 'DB_Functions.php';
	require_once 'PDF.php';
	
	$db = new DB_Functions();
	$Nombre = $_POST["Nombre"];
	$Apellido = $_POST["Apellido"];
	$Direccion = $_POST["Direccion"];
	$Telefono1 = $_POST["Telefono1"];
	$Telefono2 = $_POST["Telefono2"];
	$Concepto = $_POST["Concepto"];
	$Costo = $_POST["Costo"];
	$Dias = $_POST["Dias"];
	$Garantia = $_POST["Garantia"];
	$FechaGarantia = date_format(date_create($_POST["Fecha"]), 'd/m/Y');
	$Fecha = $_POST["FechaActual"];
	$anchoimagen = $_POST["Ancho"];
	/* Camino a Archivo local, metodo no usado ahora
	$fi = new FilesystemIterator("../Archives/", FilesystemIterator::SKIP_DOTS);
	$id = iterator_count($fi);
	*/
	$direccionarchivo = "{$id}-{$cliente}.pdf";
	$header = array('Concepto del servicio prestado', 'Costo');
	$pdf = new PDF(); 
	
	//Manipulación de la Base de Datos
	if(!$db->ExisteClientePorNombre($Nombre, $Apellido) && !$db->ExisteClientePorTelefono($Telefono)) {
		$db->AñadirCliente($Nombre, $Apellido, $Direccion, $Telefono1, $Telefono2)
	}
	//Versión sin producto asociado
	$db->AñadirGarantia($FechaGarantia, $Dias, $Garantia);
	
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
	$pdf->Cell(0, 12, iconv('utf-8', 'ISO-8859-15', "Cliente: " . $cliente), 0, 0, 'C');
	$pdf->Ln();
	$pdf->Cell(0, 12, iconv('utf-8', 'ISO-8859-15', "Dirección: " . $direccion), 0, 0, 'C');
	$pdf->Ln();
	$pdf->Cell(0, 12, iconv('utf-8', 'ISO-8859-15', "Teléfono: " . $telefono), 0, 0, 'C');
	$pdf->Ln();
	$concepto2 = iconv('utf-8', 'ISO-8859-15', $concepto);
	$arraya = $concepto2 . ';$' . $costo;
	$pdf->BasicTable($header, Array(explode(';', $arraya)));
	$pdf->Ln();
	$pdf->Ln();
	$pdf->Cell(0, 12, iconv('utf-8', 'ISO-8859-15', "Garantía"), 0, 0, 'C');
	$pdf->Ln();
	$pdf->MultiCell(0, 12, iconv('utf-8', 'ISO-8859-15', "El servicio prestado tiene una garantia de: {$dias_garantia} días a partir del día {$fecha_garantia}. La garantia cubre: {$garantia}"));
	$pdf->AddPage('L');
	$pdf->Image('http://notas.taller//img/Tarjeta-Alfredo-1.jpg', 0, 0, $pdf->GetPageWidth(), $pdf->GetPageHeight());
	//$pdf->Image('https://notas-taller.000webhostapp.com//img/Tarjeta-Alfredo-1.jpg', 0, 0, $pdf->GetPageWidth(), $pdf->GetPageHeight()); //Ver. producción
	$pdf->AddPage('L');
	$pdf->Image('http://notas.taller//img/Tarjeta-Alfredo-2.jpg', 0, 0, $pdf->GetPageWidth(), $pdf->GetPageHeight());
	//$pdf->Image('https://notas-taller.000webhostapp.com//img/Tarjeta-Alfredo-2.jpg', 0, 0, $pdf->GetPageWidth(), $pdf->GetPageHeight()); //Ver. Producción
	
	$pdf->Output('F', "../Archives/{$direccionarchivo}");
	
	$database = fopen("../database.txt", "a+") or die("Unable to open file!");
	fwrite($database, "{$id};{$cliente};{$telefono};{$date};{$direccionarchivo}"."\r\n");
	fclose($database);
	echo "{$direccionarchivo}";
	//Retorno, se tratará de enviar la URL para su descarga. En dado caso de que no se pueda, se tendra que manejar de distinta forma para poder generar la url y hacer la descarga manual, tengo mis dudas debido al FAQ de la libreria que dice que "No uses a AJAX request para obtener el PDF."
	
?>