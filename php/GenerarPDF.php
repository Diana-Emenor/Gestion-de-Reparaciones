<?php
	require("fpdf.php");
	
	class PDF extends FPDF{
		function BasicTable($header, $data){
			foreach($header as $col)
				$this->Cell(80,7,$col,1);
			$this->Ln();
			foreach($data as $row){
				$y = $this->GetY();
				$flag = false;
				$x = 0;
				foreach($row as $col){
					$this->SetY($y, false);
					if($flag) {
						$this->SetX(90);
					}
					$this->MultiCell(80,6,$col,1);
					$flag = true;
				}
				$this->Ln();
			}
		}
	}
	
	$cliente = $_POST["Cliente"];
	$direccion = $_POST["Direccion"];
	$telefono = $_POST["Telefono"];
	
	$concepto = $_POST["Concepto"];
	$costo = $_POST["Costo"];
	
	$dias_garantia = $_POST["Dias"];
	$fecha_garantia = date_format(date_create($_POST["Fecha"]), 'd/m/Y');
	$garantia = $_POST["Garantia"];
	$anchoimagen = $_POST["Ancho"];
	
	$date = $_POST["FechaActual"];
	
	$fi = new FilesystemIterator("../Archives/", FilesystemIterator::SKIP_DOTS);
	$id = iterator_count($fi);
	
	$direccionarchivo = "{$id}-{$cliente}.pdf";
	
	$header = array('Concepto del servicio prestado', 'Costo');
	
	$pdf = new PDF(); 
	$pdf->AddFont('A2','','arial.php');
	$pdf -> AddPage();
	$pdf -> SetFont('A2', '', 11);
	$InitialX = ($pdf->GetPageWidth()/2) - ($anchoimagen/2.5);
	$pdf -> Image('https://notas-taller.000webhostapp.com//img/Imagen4.png', abs(intval($InitialX)), null, 0, 0); //La url de la imagen deberá ser cambiado una vez se ponga en la web
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
	/*$pdf->AddPage('L');
	$pdf->Image('https://notas-taller.000webhostapp.com//img/tarjeta.jpg', 0, 0, $pdf->GetPageWidth(), $pdf->GetPageHeight());
	Imagen incorrecta, error de aramis. Retirando imagen hasta encontrar la verdadera */
	
	$pdf->Output('F', "../Archives/{$direccionarchivo}");
	
	$database = fopen("../database.txt", "a+") or die("Unable to open file!");
	fwrite($database, "{$id};{$cliente};{$telefono};{$date};{$direccionarchivo}"."\r\n");
	fclose($database);
	echo "{$direccionarchivo}";
	//Retorno, se tratará de enviar la URL para su descarga. En dado caso de que no se pueda, se tendra que manejar de distinta forma para poder generar la url y hacer la descarga manual, tengo mis dudas debido al FAQ de la libreria que dice que "No uses a AJAX request para obtener el PDF."
	
?>