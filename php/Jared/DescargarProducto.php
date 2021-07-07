<?php
	require_once '../DB_Functions.php';
	require_once '../PDF.php';

	$db = new DB_Functions();
	$pdf = new PDF();
	$IDProducto = $_POST["IDProducto"];
	$IDCliente = $_POST["IDCliente"];
	$anchoimagen = $_POST["Ancho"];
	
	$id=$IDProducto;
	
	//Manipulación de la Base de Datos
	
	$Producto = $db->ObtenerProducto($IDProducto);
	$Cliente = $db->ObtenerCliente($IDCliente);
	$Nombre = $Cliente[1];
	$Apellido = $Cliente[2];
	$Direccion = $Cliente[5];
	$Telefono1 = $Cliente[3];
	$Telefono2 = $Cliente[4];
	$Servicio = $Producto[13];
	$Anticipado = $Producto[5];
	$Fecha = $Producto[12];
	$Tipo = $Producto[1];
	$Marca = $Producto[2];
	$Modelo = $Producto[3];
	$Fallo = $Producto[6];
	$Cable = $Producto[8];
	$Control = $Producto[7];
	$Caracteristicas = $Producto[9];
	
	$General = "Dispositivo de {$Nombre} {$Apellido} de tipo {$Tipo} ";
	
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
		$General .= "Sin Marca ";
	} else {
		$Data3[1] = array("Marca", $Marca);
		$General .= "{$Marca} ";
	}
	if($Modelo == '') {
		$Data3[2] = array("Modelo", "Sin Modelo");
		$General .= "Sin Modelo ";
	} else {
		$Data3[2] = array("Modelo", $Modelo);
		$General .= "{$Modelo} ";
	}
	$General .= "con fallo de {$Fallo}.";
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
	
	if($Cable == 0 && $Control== '' && $Caracteristicas == ''){
			$General.= ' No contiene elementos adicionales.';
		} else {
			$General.= ' Contiene:';
			if($Cable == 1) {
				$General.= ' cable de luz';
				if($Control != '') {
					$General.= ", {$Control}";
				}
				if($Caracteristicas != '') {
					$General.= ", {$Caracteristicas}";
				}
			} else if($Control != '') {
				$General.= " {$Control}";
				if($Caracteristicas != '') {
					$General.= ", {$Caracteristicas}";
				}
			} else if($Caracteristicas != '') {
				$General.= " {$Caracteristicas}";
			}
			$General.='.';
		}
	
	
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

	$pdf->Output('F', "../../Archives/{$Direccionarchivo}");
	
	/* Solo necesario en caso de no contar con una base de datos con SQL
	$database = fopen("../database.txt", "a+") or die("Unable to open file!");
	fwrite($database, "{$id};{$Nombre . ' ' . $Apellido};{$Telefono1};{$date};{$Direccionarchivo}"."\r\n");
	fclose($database);
	*/
	echo "{$Direccionarchivo}";
?>