<?php
class DB_Functions {
	private $conn;

	function __construct() {
		require 'DB_Connect.php';
		$db = new Db_Connect();
		$this->conn = $db->connect();
	}

	function __destruct() {
	}
	
	public function ObtenerIDProducto(){
		$stmt = $this->conn->prepare("SELECT COUNT(*) FROM PRODUCTO");
		$stmt->execute();
		$stmt->store_result();
		$result = $this->fetchAssocStatement($stmt);
		$stmt->close();
		return $result['COUNT(*)'];
	}
	
	public function AñadirGarantia($Fecha, $Duracion, $Concepto, $Costo, $Garantia, $Cliente, $Usuario) {
		$stmt = $this->conn->prepare("SELECT COUNT(*) FROM GARANTIA");
		$stmt->execute();
		$stmt->store_result();
		$result = $this->fetchAssocStatement($stmt);
		$stmt->close();
		$ID = $result['COUNT(*)'];
		$stmt = $this->conn->prepare("INSERT INTO GARANTIA (ID, FECHA, DURACION, CONCEPTO, COSTO, DESCRIPCION, IDCLIENTE, IDUSUARIO) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
		$stmt->bind_param("ssssssss", $ID, $Fecha, $Duracion, $Concepto, $Costo, $Garantia, $Cliente, $Usuario);
		$stmt->execute();
		$stmt->store_result();
		$result = $this->fetchAssocStatement($stmt);
		$stmt->close();
		return $ID;
	}
	
	public function ObtenerGarantia($ID){
		$stmt = $this->conn->prepare("SELECT * FROM GARANTIA WHERE ID = ?");
		$stmt->bind_param("s", $ID);
		if($stmt->execute()){
			$result = $stmt->get_result();
			$index = 0;
			$row = $result->fetch_row();
			$Garantia[0] = $row[0];
			$Garantia[1] = $row[1];
			$Garantia[2] = $row[2];
			$Garantia[3] = $row[3];
			$Garantia[4] = $row[4];
			$Garantia[5] = $row[5];
			$stmt->close();
			return $Garantia;
		} else {
			return false;
		}
	}
	
	public function ObtenerProducto($ID) {
		$stmt = $this->conn->prepare("SELECT * FROM PRODUCTO WHERE ID = ?");
		$stmt->bind_param("s", $ID);
		if($stmt->execute()){
			$result = $stmt->get_result();
			$index = 0;
			$row = $result->fetch_row();
			$Producto[0] = $row[0];
			$Producto[1] = $row[1];
			$Producto[2] = $row[2];
			$Producto[3] = $row[3];
			$Producto[4] = $row[4];
			$Producto[5] = $row[5];
			$Producto[6] = $row[6];
			$Producto[7] = $row[7];
			$Producto[8] = $row[8];
			$Producto[9] = $row[9];
			$Producto[10] = $row[10];
			$Producto[11] = $row[11];
			$Producto[12] = $row[12];
			$Producto[13] = $row[13];
			$stmt->close();
			return $Producto;
		} else {
			return false;
		}
	}
	
	
	public function ObtenerCliente($ID) {
		$stmt = $this->conn->prepare("SELECT * FROM CLIENTE WHERE ID = ?");
		$stmt->bind_param("s", $ID);
		if($stmt->execute()){
			$result = $stmt->get_result();
			$row = $result->fetch_row();
			$Garantia[0] = $row[0];
			$Garantia[1] = $row[1];
			$Garantia[2] = $row[2];
			$Garantia[3] = $row[3];
			$Garantia[4] = $row[4];
			$Garantia[5] = $row[5];
			$stmt->close();
			return $Garantia;
		} else {
			return false;
		}
	}
	
	//Usando nombre
	public function ExisteClientePorNombre($Nombre, $Apellido) {
		$stmt = $this->conn->prepare("SELECT * FROM CLIENTE WHERE NOMBRE = ? AND APELLIDO = ?");
		$stmt->bind_param("ss", $Nombre, $Apellido);
		$stmt->execute();
		$stmt->store_result();
		if ($stmt->num_rows > 0) {
			$stmt->close();
			return true;
		} else {
			$stmt->close();
			return false;
		}
	}
	
	//Usando Telefono
	public function ExisteClientePorTelefono($Telefono) {
		$stmt = $this->conn->prepare("SELECT * FROM CLIENTE WHERE TELEFONO = ?");
		$stmt->bind_param("s", $Telefono);
		$stmt->execute();
		$stmt->store_result();
		if ($stmt->num_rows > 0) {
			$stmt->close();
			return true;
		} else {
			$stmt->close();
			return false;
		}
	}
	
	public function IDCliente($Nombre, $Apellido, $Telefono){
		$stmt = $this->conn->prepare("SELECT ID, NOMBRE FROM CLIENTE WHERE NOMBRE = ? AND APELLIDO = ? AND TELEFONO = ?");
		$stmt->bind_param("sss", $Nombre, $Apellido, $Telefono);
		if($stmt->execute()){
			$result = $stmt->get_result();
			$row = $result->fetch_row();
			$Garantia = $row[0];
			$stmt->close();
			return $Garantia;
		} else {
			return false;
		}
	}
	
	public function AñadirCliente($Nombre, $Apellido, $Direccion, $Telefono1, $Telefono2){
		if(!$this->ExisteClientePorNombre($Nombre, $Apellido) && !$this->ExisteClientePorTelefono($Telefono1)) {
			$stmt = $this->conn->prepare("SELECT COUNT(*) FROM CLIENTE");
			$stmt->execute();
			$stmt->store_result();
			$result = $this->fetchAssocStatement($stmt);
			$stmt->close();
			$ID = $result['COUNT(*)'];
			unset($stmt);
			$stmt = $this->conn->prepare("INSERT INTO CLIENTE (ID, NOMBRE, APELLIDO, DIRECCION, TELEFONO, TELEFONO_ALT) VALUES (?, ?, ?, ?, ?, ?)");
			$stmt->bind_param("ssssss", $ID, $Nombre, $Apellido, $Direccion, $Telefono1, $Telefono2);
			$result = $stmt->execute();
			$stmt->close();
			return $ID;
		} else {
			return false;
		}
	}
	
	public function AñadirProducto($Tipo, $Marca, $Modelo, $Cliente, $Anticipo, $Falla, $Control, $Cable, $Otros, $Garantia, $Usuario, $Fecha, $Servicio) {
		$stmt = $this->conn->prepare("SELECT COUNT(*) FROM PRODUCTO");
		$stmt->execute();
		$stmt->store_result();
		$result = $this->fetchAssocStatement($stmt);
		$stmt->close();
		$ID = $result['COUNT(*)'];
		$stmt = $this->conn->prepare("INSERT INTO PRODUCTO (ID, TIPO, MARCA, MODELO, IDCLIENTE, ANTICIPO, FALLA, CONTROL, CABLE, OTROS, IDGARANTIA, IDUSUARIO, FECHA) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
		$stmt->bind_param("sssssssssssss", $ID, $Tipo, $Marca, $Modelo, $Cliente, $Anticipo, $Falla, $Control, $Cable, $Otros, $Garantia, $Usuario, $Fecha, $Servicio);
		$result = $stmt->execute();
		$stmt->close();
		return $result;
	}
	
	public function AsociarGarantia($Producto, $Garantia){
		$stmt = $this->conn->prepare("UPDATE PRODUCTO SET IDGARANTIA = ? WHERE ID = ?");
		$stmt->bind_param("ss", $Garantia, $Producto);
		$result = $stmt->execute();
		$stmt->close();
		return $result;
	}
	
	public function ObtenerDatosdeTabla($Usuario) {
		$stmt = $this->conn->prepare("SELECT GAR.ID, GAR.FECHA, CLI.ID, CLI.NOMBRE, CLI.APELLIDO, CLI.TELEFONO FROM GARANTIA GAR LEFT OUTER JOIN CLIENTE CLI ON GAR.IDCLIENTE = CLI.ID WHERE GAR.IDUSUARIO = ?");
		$stmt->bind_param("s", $Usuario);
		if($stmt->execute()){
			$result = $stmt->get_result();
			$index = 0;
			while($row = $result->fetch_row()){
				$tabla[$index][0] = $row[0];
				$tabla[$index][1] = $row[1];
				$tabla[$index][2] = $row[2];
				$tabla[$index][3] = $row[3] . ' ' . $row[4];
				$tabla[$index][4] = $row[5];
				$index++;
			}
			$stmt->close();
			return $tabla;
		} else {
			return false;
		}
	}
	
	public function ObtenerDatosdeTablaProducto($Usuario) {
		$stmt = $this->conn->prepare("SELECT PRO.ID, PRO.FECHA, CLI.ID, CLI.NOMBRE, CLI.APELLIDO, CLI.TELEFONO FROM PRODUCTO PRO LEFT OUTER JOIN CLIENTE CLI ON PRO.IDCLIENTE = CLI.ID WHERE PRO.IDUSUARIO = ?");
		$stmt->bind_param("s", $Usuario);
		if($stmt->execute()){
			$result = $stmt->get_result();
			$index = 0;
			while($row = $result->fetch_row()){
				$tabla[$index][0] = $row[0];
				$tabla[$index][1] = $row[1];
				$tabla[$index][2] = $row[2];
				$tabla[$index][3] = $row[3] . ' ' . $row[4];
				$tabla[$index][4] = $row[5];
				$index++;
			}
			$stmt->close();
			return $tabla;
		} else {
			return false;
		}
	}
	
	
	
	
	
	
	
	
	
	
	
	
	public function borrarDatos(){
		$stmt = $this->conn->prepare("TRUNCATE INVENTARIO");
		if($stmt->execute()){
			$stmt->close();
		} else {
			return false;
		}
		$stmt = $this->conn->prepare("TRUNCATE RUTAS");
		if($stmt->execute()){
			$stmt->close();
		} else {
			return false;
		}
		$stmt = $this->conn->prepare("TRUNCATE HANDHELDBARCEL");
		if($stmt->execute()){
			$stmt->close();
		} else {
			return false;
		}
		$stmt = $this->conn->prepare("TRUNCATE HANDHELDBIMBO");
		if($stmt->execute()){
			$stmt->close();
		} else {
			return false;
		}
		$stmt = $this->conn->prepare("TRUNCATE HANDHELDRICOLINO");
		if($stmt->execute()){
			$stmt->close();
		} else {
			return false;
		}
		$stmt = $this->conn->prepare("TRUNCATE DETALLESBAJAS");
		if($stmt->execute()){
			$stmt->close();
		} else {
			return false;
		}
		$stmt = $this->conn->prepare("TRUNCATE CV");
		if($stmt->execute()){
			$stmt->close();
		} else {
			return false;
		}
		$stmt = $this->conn->prepare("TRUNCATE CELULARESBARCEL");
		if($stmt->execute()){
			$stmt->close();
		} else {
			return false;
		}
		$stmt = $this->conn->prepare("TRUNCATE CELULARESBIMBO");
		if($stmt->execute()){
			$stmt->close();
		} else {
			return false;
		}
		$stmt = $this->conn->prepare("TRUNCATE CELULARESRICOLINO");
		if($stmt->execute()){
			$stmt->close();
		} else {
			return false;
		}
		return true;
	}

	public function getInventario(){
		$stmt = $this->conn->prepare("SELECT * FROM INVENTARIO");
		if($stmt->execute()){
			$result = $stmt->get_result();
			$index = 0;
			while($row = $result->fetch_row()){
				$inventario[$index][0] = $row[0];
				$inventario[$index][1] = $row[1];
				$inventario[$index][2] = $row[2];
				$inventario[$index][3] = $row[3];
				$inventario[$index][4] = $row[4];
				$inventario[$index][5] = $row[5];
				$inventario[$index][6] = $row[6];
				$inventario[$index][7] = $row[7];
				$inventario[$index][8] = $row[8];
				$inventario[$index][9] = $row[9];
				$inventario[$index][10] = $row[10];
				$inventario[$index][11] = $row[11];
				$inventario[$index][12] = $row[12];
				$index++;
			}
			$stmt->close();
			return $inventario;
		} else {
			return false;
		}
	}
	
	public function obtenerConteoHandHeldBimbo() {
		$stmt = $this->conn->prepare("SELECT COUNT(*) FROM INVENTARIO WHERE EMPRESA LIKE '%BIMBO%' AND DISPOSITIVO = 'HAND HELD'");
		if($stmt->execute()){
			$result = $stmt->get_result();
			while($row = $result->fetch_row()){
				$inventario = $row[0];
			}
			$stmt->close();
			return $inventario;
		} else {
			return false;
		}
	}
	
	public function obtenerConteoHandHeldBarcel() {
		$stmt = $this->conn->prepare("SELECT COUNT(*) FROM INVENTARIO WHERE EMPRESA LIKE '%BARCEL%' AND DISPOSITIVO = 'HAND HELD'");
		if($stmt->execute()){
			$result = $stmt->get_result();
			while($row = $result->fetch_row()){
				$inventario = $row[0];
			}
			$stmt->close();
			return $inventario;
		} else {
			return false;
		}
	}
	
	public function obtenerConteoHandHeldRicolino() {
		$stmt = $this->conn->prepare("SELECT COUNT(*) FROM INVENTARIO WHERE EMPRESA LIKE '%RICOLINO%' AND DISPOSITIVO = 'HAND HELD'");
		if($stmt->execute()){
			$result = $stmt->get_result();
			while($row = $result->fetch_row()){
				$inventario = $row[0];
			}
			$stmt->close();
			return $inventario;
		} else {
			return false;
		}
	}
	
	public function obtenerConteoRemorzoBarcel() {
		$stmt = $this->conn->prepare("SELECT COUNT(*) FROM INVENTARIO WHERE EMPRESA = 'BARCEL' AND DISPOSITIVO = 'HAND HELD' AND REMORZAR = 'SI'");
		if($stmt->execute()){
			$result = $stmt->get_result();
			while($row = $result->fetch_row()){
				$inventario = $row[0];
			}
			$stmt->close();
			return $inventario;
		} else {
			return false;
		}
	}
	
	public function obtenerConteoRemorzoBimbo() {
		$stmt = $this->conn->prepare("SELECT COUNT(*) FROM INVENTARIO WHERE EMPRESA = 'BIMBO' AND DISPOSITIVO = 'HAND HELD' AND REMORZAR = 'SI'");
		if($stmt->execute()){
			$result = $stmt->get_result();
			while($row = $result->fetch_row()){
				$inventario = $row[0];
			}
			$stmt->close();
			return $inventario;
		} else {
			return false;
		}
	}
	
	public function obtenerConteoRemorzoRicolino() {
		$stmt = $this->conn->prepare("SELECT COUNT(*) FROM INVENTARIO WHERE EMPRESA = 'RICOLINO' AND DISPOSITIVO = 'HAND HELD' AND REMORZAR = 'SI'");
		if($stmt->execute()){
			$result = $stmt->get_result();
			while($row = $result->fetch_row()){
				$inventario = $row[0];
			}
			$stmt->close();
			return $inventario;
		} else {
			return false;
		}
	}
	
	public function obtenerConteoBajaBarcel() {
		$stmt = $this->conn->prepare("SELECT COUNT(*) FROM DETALLESBAJAS WHERE ORGANIZACIONPROV LIKE '%BARCEL%'");
		if($stmt->execute()){
			$result = $stmt->get_result();
			while($row = $result->fetch_row()){
				$inventario = $row[0];
			}
			$stmt->close();
			return $inventario;
		} else {
			return false;
		}
	}
	
	public function obtenerConteoBajaBimbo() {
		$stmt = $this->conn->prepare("SELECT COUNT(*) FROM DETALLESBAJAS WHERE ORGANIZACIONPROV LIKE '%BIMBO%'");
		if($stmt->execute()){
			$result = $stmt->get_result();
			while($row = $result->fetch_row()){
				$inventario = $row[0];
			}
			$stmt->close();
			return $inventario;
		} else {
			return false;
		}
	}
	
	public function obtenerConteoBajaRicolino() {
		$stmt = $this->conn->prepare("SELECT COUNT(*) FROM DETALLESBAJAS WHERE ORGANIZACIONPROV LIKE '%RICOLINO%'");
		if($stmt->execute()){
			$result = $stmt->get_result();
			while($row = $result->fetch_row()){
				$inventario = $row[0];
			}
			$stmt->close();
			return $inventario;
		} else {
			return false;
		}
	}
	
	public function obtenetConteoReal(){
		$stmt = $this->conn->prepare("SELECT COUNT(*) FROM DETALLESBAJAS WHERE ORGANIZACIONPROV LIKE '%BIMBO%' OR ORGANIZACIONPROV LIKE '%BARCEL%' OR ORGANIZACIONPROV LIKE '%RICOLINO%'");
		if($stmt->execute()){
			$result = $stmt->get_result();
			while($row = $result->fetch_row()){
				$inventario = $row[0];
			}
			$stmt->close();
			return $inventario;
		} else {
			return false;
		}
	}
	
	public function obtenetConteoRealBarcel(){
		$stmt = $this->conn->prepare("SELECT COUNT(*) FROM DETALLESBAJAS WHERE ORGANIZACIONPROV LIKE '%BARCEL%'");
		if($stmt->execute()){
			$result = $stmt->get_result();
			while($row = $result->fetch_row()){
				$inventario = $row[0];
			}
			$stmt->close();
			return $inventario;
		} else {
			return false;
		}
	}public function obtenetConteoRealBimbo(){
		$stmt = $this->conn->prepare("SELECT COUNT(*) FROM DETALLESBAJAS WHERE ORGANIZACIONPROV LIKE '%BIMBO%'");
		if($stmt->execute()){
			$result = $stmt->get_result();
			while($row = $result->fetch_row()){
				$inventario = $row[0];
			}
			$stmt->close();
			return $inventario;
		} else {
			return false;
		}
	}public function obtenetConteoRealRicolino(){
		$stmt = $this->conn->prepare("SELECT COUNT(*) FROM DETALLESBAJAS WHERE ORGANIZACIONPROV LIKE '%RICOLINO%'");
		if($stmt->execute()){
			$result = $stmt->get_result();
			while($row = $result->fetch_row()){
				$inventario = $row[0];
			}
			$stmt->close();
			return $inventario;
		} else {
			return false;
		}
	}
	
	public function obtenerConteoCelular(){
		$cantidad = 0;
		$stmt = $this->conn->prepare("SELECT SUM(CANTIDAD) FROM CELULARESBARCEL");
		$stmt->execute();
		$result = $stmt->get_result();
		while($row = $result->fetch_row()){
			$cantidad += $row[0];
		}
		$stmt->close();
		$stmt = $this->conn->prepare("SELECT SUM(CANTIDAD) FROM CELULARESBIMBO");
		$stmt->execute();
		$result = $stmt->get_result();
		while($row = $result->fetch_row()){
			$cantidad += $row[0];
		}
		$stmt->close();
		$stmt = $this->conn->prepare("SELECT SUM(CANTIDAD) FROM CELULARESRICOLINO");
		$stmt->execute();
		$result = $stmt->get_result();
		while($row = $result->fetch_row()){
			$inventario = $row[0];
		}
		$stmt->close();
		if($cantidad > 0){
			return $cantidad * 0.9;
		} else {
			return false;
		}
	}
	
	public function obtenerConteoCelularBarcel(){
		$cantidad = 0;
		$stmt = $this->conn->prepare("SELECT SUM(CANTIDAD) FROM CELULARESBARCEL");
		$stmt->execute();
		$result = $stmt->get_result();
		while($row = $result->fetch_row()){
			$cantidad += $row[0];
		}
		$stmt->close();
		if($cantidad > 0){
			return $cantidad * 0.9;
		} else {
			return false;
		}
	}
	
	public function obtenerConteoCelularBimbo(){
		$cantidad = 0;
		$stmt = $this->conn->prepare("SELECT SUM(CANTIDAD) FROM CELULARESBIMBO");
		$stmt->execute();
		$result = $stmt->get_result();
		while($row = $result->fetch_row()){
			$cantidad += $row[0];
		}
		$stmt->close();
		if($cantidad > 0){
			return $cantidad * 0.9;
		} else {
			return false;
		}
	}
	
	public function obtenerConteoCelularRicolino(){
		$cantidad = 0;
		$stmt = $this->conn->prepare("SELECT SUM(CANTIDAD) FROM CELULARESRICOLINO");
		$stmt->execute();
		$result = $stmt->get_result();
		while($row = $result->fetch_row()){
			$cantidad = $row[0];
		}
		$stmt->close();
		if($cantidad > 0){
			return $cantidad * 0.9;
		} else {
			return false;
		}
	}
	
	public function conteoPorSprintPorEmpresa($empresa){
		$stmt = $this->conn->prepare("SELECT COUNT(CELRIC.CANTIDAD), COUNT(CELBIM.CANTIDAD), COUNT(CELBAR.CANTIDAD) FROM CV CEVE LEFT OUTER JOIN CELULARESRICOLINO CELRIC ON CEVE.CODIGO = CELRIC.CODIGO LEFT OUTER JOIN CELULARESBARCEL CELBAR ON CEVE.CODIGO = CELBAR.CODIGO LEFT OUTER JOIN CELULARESBIMBO CELBIM ON CEVE.CODIGO = CELBIM.CODIGO GROUP BY CEVE.SPRINT");
		$stmt->execute();
		$result = $stmt->get_result();
		$barcel = array();
		$bimbo = array();
		$ricolino = array();
		$index = 0;
		while($row = $result->fetch_row()){
			$barcel[$index] = $row[2];
			$bimbo[$index] = $row[1];
			$ricolino[$index] = $row[0];
			$index++;
		}
		$stmt->close();
		if($empresa == 'BARCEL') {
			return $barcel;
		} elseif($empresa == 'BIMBO') {
			return $bimbo;
		} elseif($empresa == 'RICOLINO') {
			return $ricolino;
		}
		return null;
	}
	
	public function conteoPorSprint(){
		$sprint = '';
		$stmt = $this->conn->prepare("SELECT COUNT(CELRIC.CANTIDAD), COUNT(CELBIM.CANTIDAD), COUNT(CELBAR.CANTIDAD) FROM CV CEVE LEFT OUTER JOIN CELULARESRICOLINO CELRIC ON CEVE.CODIGO = CELRIC.CODIGO LEFT OUTER JOIN CELULARESBARCEL CELBAR ON CEVE.CODIGO = CELBAR.CODIGO LEFT OUTER JOIN CELULARESBIMBO CELBIM ON CEVE.CODIGO = CELBIM.CODIGO WHERE CEVE.SPRINT = '01'");
		$stmt->execute();
		$result = $stmt->get_result();
		while($row = $result->fetch_row()){
			if($row[0] != 0 || $row[1] != 0 || $row[2] != 0){
				$sprint = $sprint . '1';
			}
		}
		$stmt->close();
		$stmt = $this->conn->prepare("SELECT COUNT(CELRIC.CANTIDAD), COUNT(CELBIM.CANTIDAD), COUNT(CELBAR.CANTIDAD) FROM CV CEVE LEFT OUTER JOIN CELULARESRICOLINO CELRIC ON CEVE.CODIGO = CELRIC.CODIGO LEFT OUTER JOIN CELULARESBARCEL CELBAR ON CEVE.CODIGO = CELBAR.CODIGO LEFT OUTER JOIN CELULARESBIMBO CELBIM ON CEVE.CODIGO = CELBIM.CODIGO WHERE CEVE.SPRINT = '01.5'");
		$stmt->execute();
		$result = $stmt->get_result();
		while($row = $result->fetch_row()){
			if($row[0] != 0 || $row[1] != 0 || $row[2] != 0){
				$sprint = $sprint . ', 1.5';
			}
		}
		$stmt->close();
		$stmt = $this->conn->prepare("SELECT COUNT(CELRIC.CANTIDAD), COUNT(CELBIM.CANTIDAD), COUNT(CELBAR.CANTIDAD) FROM CV CEVE LEFT OUTER JOIN CELULARESRICOLINO CELRIC ON CEVE.CODIGO = CELRIC.CODIGO LEFT OUTER JOIN CELULARESBARCEL CELBAR ON CEVE.CODIGO = CELBAR.CODIGO LEFT OUTER JOIN CELULARESBIMBO CELBIM ON CEVE.CODIGO = CELBIM.CODIGO WHERE CEVE.SPRINT = '02'");
		$stmt->execute();
		$result = $stmt->get_result();
		while($row = $result->fetch_row()){
			if($row[0] != 0 || $row[1] != 0 || $row[2] != 0){
				$sprint = $sprint .  ', 2';
			}
		}
		$stmt->close();
		$stmt = $this->conn->prepare("SELECT COUNT(CELRIC.CANTIDAD), COUNT(CELBIM.CANTIDAD), COUNT(CELBAR.CANTIDAD) FROM CV CEVE LEFT OUTER JOIN CELULARESRICOLINO CELRIC ON CEVE.CODIGO = CELRIC.CODIGO LEFT OUTER JOIN CELULARESBARCEL CELBAR ON CEVE.CODIGO = CELBAR.CODIGO LEFT OUTER JOIN CELULARESBIMBO CELBIM ON CEVE.CODIGO = CELBIM.CODIGO WHERE CEVE.SPRINT = '03'");
		$stmt->execute();
		$result = $stmt->get_result();
		while($row = $result->fetch_row()){
			if($row[0] != 0 || $row[1] != 0 || $row[2] != 0){
				$sprint = $sprint .  ', 3';
			}
		}
		$stmt->close();
		$stmt = $this->conn->prepare("SELECT COUNT(CELRIC.CANTIDAD), COUNT(CELBIM.CANTIDAD), COUNT(CELBAR.CANTIDAD) FROM CV CEVE LEFT OUTER JOIN CELULARESRICOLINO CELRIC ON CEVE.CODIGO = CELRIC.CODIGO LEFT OUTER JOIN CELULARESBARCEL CELBAR ON CEVE.CODIGO = CELBAR.CODIGO LEFT OUTER JOIN CELULARESBIMBO CELBIM ON CEVE.CODIGO = CELBIM.CODIGO WHERE CEVE.SPRINT = '04'");
		$stmt->execute();
		$result = $stmt->get_result();
		while($row = $result->fetch_row()){
			if($row[0] != 0 || $row[1] != 0 || $row[2] != 0){
				$sprint = $sprint .  ', 4';
			}
		}
		$stmt->close();
		$stmt = $this->conn->prepare("SELECT COUNT(CELRIC.CANTIDAD), COUNT(CELBIM.CANTIDAD), COUNT(CELBAR.CANTIDAD) FROM CV CEVE LEFT OUTER JOIN CELULARESRICOLINO CELRIC ON CEVE.CODIGO = CELRIC.CODIGO LEFT OUTER JOIN CELULARESBARCEL CELBAR ON CEVE.CODIGO = CELBAR.CODIGO LEFT OUTER JOIN CELULARESBIMBO CELBIM ON CEVE.CODIGO = CELBIM.CODIGO WHERE CEVE.SPRINT = '05'");
		$stmt->execute();
		$result = $stmt->get_result();
		while($row = $result->fetch_row()){
			if($row[0] != 0 || $row[1] != 0 || $row[2] != 0){
				$sprint = $sprint .  ', 5';
			}
		}
		$stmt->close();
		$stmt = $this->conn->prepare("SELECT COUNT(CELRIC.CANTIDAD), COUNT(CELBIM.CANTIDAD), COUNT(CELBAR.CANTIDAD) FROM CV CEVE LEFT OUTER JOIN CELULARESRICOLINO CELRIC ON CEVE.CODIGO = CELRIC.CODIGO LEFT OUTER JOIN CELULARESBARCEL CELBAR ON CEVE.CODIGO = CELBAR.CODIGO LEFT OUTER JOIN CELULARESBIMBO CELBIM ON CEVE.CODIGO = CELBIM.CODIGO WHERE CEVE.SPRINT = '06'");
		$stmt->execute();
		$result = $stmt->get_result();
		while($row = $result->fetch_row()){
			if($row[0] != 0 || $row[1] != 0 || $row[2] != 0){
				$sprint = $sprint .  ', 6';
			}
		}
		$stmt->close();
		$stmt = $this->conn->prepare("SELECT COUNT(CELRIC.CANTIDAD), COUNT(CELBIM.CANTIDAD), COUNT(CELBAR.CANTIDAD) FROM CV CEVE LEFT OUTER JOIN CELULARESRICOLINO CELRIC ON CEVE.CODIGO = CELRIC.CODIGO LEFT OUTER JOIN CELULARESBARCEL CELBAR ON CEVE.CODIGO = CELBAR.CODIGO LEFT OUTER JOIN CELULARESBIMBO CELBIM ON CEVE.CODIGO = CELBIM.CODIGO WHERE CEVE.SPRINT = '07'");
		$stmt->execute();
		$result = $stmt->get_result();
		while($row = $result->fetch_row()){
			if($row[0] != 0 || $row[1] != 0 || $row[2] != 0){
				$sprint = $sprint .  ', 7';
			}
		}
		$stmt->close();
		$stmt = $this->conn->prepare("SELECT COUNT(CELRIC.CANTIDAD), COUNT(CELBIM.CANTIDAD), COUNT(CELBAR.CANTIDAD) FROM CV CEVE LEFT OUTER JOIN CELULARESRICOLINO CELRIC ON CEVE.CODIGO = CELRIC.CODIGO LEFT OUTER JOIN CELULARESBARCEL CELBAR ON CEVE.CODIGO = CELBAR.CODIGO LEFT OUTER JOIN CELULARESBIMBO CELBIM ON CEVE.CODIGO = CELBIM.CODIGO WHERE CEVE.SPRINT = '08'");
		$stmt->execute();
		$result = $stmt->get_result();
		while($row = $result->fetch_row()){
			if($row[0] != 0 || $row[1] != 0 || $row[2] != 0){
				$sprint = $sprint .  ', 8';
			}
		}
		$stmt->close();
		$stmt = $this->conn->prepare("SELECT COUNT(CELRIC.CANTIDAD), COUNT(CELBIM.CANTIDAD), COUNT(CELBAR.CANTIDAD) FROM CV CEVE LEFT OUTER JOIN CELULARESRICOLINO CELRIC ON CEVE.CODIGO = CELRIC.CODIGO LEFT OUTER JOIN CELULARESBARCEL CELBAR ON CEVE.CODIGO = CELBAR.CODIGO LEFT OUTER JOIN CELULARESBIMBO CELBIM ON CEVE.CODIGO = CELBIM.CODIGO WHERE CEVE.SPRINT = '09'");
		$stmt->execute();
		$result = $stmt->get_result();
		while($row = $result->fetch_row()){
			if($row[0] != 0 || $row[1] != 0 || $row[2] != 0){
				$sprint = $sprint .  ', 9';
			}
		}
		$stmt->close();
		$stmt = $this->conn->prepare("SELECT COUNT(CELRIC.CANTIDAD), COUNT(CELBIM.CANTIDAD), COUNT(CELBAR.CANTIDAD) FROM CV CEVE LEFT OUTER JOIN CELULARESRICOLINO CELRIC ON CEVE.CODIGO = CELRIC.CODIGO LEFT OUTER JOIN CELULARESBARCEL CELBAR ON CEVE.CODIGO = CELBAR.CODIGO LEFT OUTER JOIN CELULARESBIMBO CELBIM ON CEVE.CODIGO = CELBIM.CODIGO WHERE CEVE.SPRINT = '10'");
		$stmt->execute();
		$result = $stmt->get_result();
		while($row = $result->fetch_row()){
			if($row[0] != 0 || $row[1] != 0 || $row[2] != 0){
				$sprint = $sprint .  ', 10';
			}
		}
		$stmt->close();
		$stmt = $this->conn->prepare("SELECT COUNT(CELRIC.CANTIDAD), COUNT(CELBIM.CANTIDAD), COUNT(CELBAR.CANTIDAD) FROM CV CEVE LEFT OUTER JOIN CELULARESRICOLINO CELRIC ON CEVE.CODIGO = CELRIC.CODIGO LEFT OUTER JOIN CELULARESBARCEL CELBAR ON CEVE.CODIGO = CELBAR.CODIGO LEFT OUTER JOIN CELULARESBIMBO CELBIM ON CEVE.CODIGO = CELBIM.CODIGO WHERE CEVE.SPRINT = '11'");
		$stmt->execute();
		$result = $stmt->get_result();
		while($row = $result->fetch_row()){
			if($row[0] != 0 || $row[1] != 0 || $row[2] != 0){
				$sprint = $sprint .  ', 11';
			}
		}
		$stmt->close();
		$stmt = $this->conn->prepare("SELECT COUNT(CELRIC.CANTIDAD), COUNT(CELBIM.CANTIDAD), COUNT(CELBAR.CANTIDAD) FROM CV CEVE LEFT OUTER JOIN CELULARESRICOLINO CELRIC ON CEVE.CODIGO = CELRIC.CODIGO LEFT OUTER JOIN CELULARESBARCEL CELBAR ON CEVE.CODIGO = CELBAR.CODIGO LEFT OUTER JOIN CELULARESBIMBO CELBIM ON CEVE.CODIGO = CELBIM.CODIGO WHERE CEVE.SPRINT = '12'");
		$stmt->execute();
		$result = $stmt->get_result();
		while($row = $result->fetch_row()){
			if($row[0] != 0 || $row[1] != 0 || $row[2] != 0){
				$sprint = $sprint .  ', 12';
			}
		}
		$stmt->close();
		$stmt = $this->conn->prepare("SELECT COUNT(CELRIC.CANTIDAD), COUNT(CELBIM.CANTIDAD), COUNT(CELBAR.CANTIDAD) FROM CV CEVE LEFT OUTER JOIN CELULARESRICOLINO CELRIC ON CEVE.CODIGO = CELRIC.CODIGO LEFT OUTER JOIN CELULARESBARCEL CELBAR ON CEVE.CODIGO = CELBAR.CODIGO LEFT OUTER JOIN CELULARESBIMBO CELBIM ON CEVE.CODIGO = CELBIM.CODIGO WHERE CEVE.SPRINT = '13'");
		$stmt->execute();
		$result = $stmt->get_result();
		while($row = $result->fetch_row()){
			if($row[0] != 0 || $row[1] != 0 || $row[2] != 0){
				$sprint = $sprint .  ', 13';
			}
		}
		$stmt->close();
		$stmt = $this->conn->prepare("SELECT COUNT(CELRIC.CANTIDAD), COUNT(CELBIM.CANTIDAD), COUNT(CELBAR.CANTIDAD) FROM CV CEVE LEFT OUTER JOIN CELULARESRICOLINO CELRIC ON CEVE.CODIGO = CELRIC.CODIGO LEFT OUTER JOIN CELULARESBARCEL CELBAR ON CEVE.CODIGO = CELBAR.CODIGO LEFT OUTER JOIN CELULARESBIMBO CELBIM ON CEVE.CODIGO = CELBIM.CODIGO WHERE CEVE.SPRINT = 'PILOTO'");
		$stmt->execute();
		$result = $stmt->get_result();
		while($row = $result->fetch_row()){
			if($row[0] != 0 || $row[1] != 0 || $row[2] != 0){
				$sprint = $sprint . ', PILOTO';
			}
		}
		$stmt->close();
		$stmt = $this->conn->prepare("SELECT COUNT(CELRIC.CANTIDAD), COUNT(CELBIM.CANTIDAD), COUNT(CELBAR.CANTIDAD) FROM CV CEVE LEFT OUTER JOIN CELULARESRICOLINO CELRIC ON CEVE.CODIGO = CELRIC.CODIGO LEFT OUTER JOIN CELULARESBARCEL CELBAR ON CEVE.CODIGO = CELBAR.CODIGO LEFT OUTER JOIN CELULARESBIMBO CELBIM ON CEVE.CODIGO = CELBIM.CODIGO WHERE CEVE.SPRINT = 'TBC'");
		$stmt->execute();
		$result = $stmt->get_result();
		while($row = $result->fetch_row()){
			if($row[0] != 0 || $row[1] != 0 || $row[2] != 0){
				$sprint = $sprint .  ', TBC';
			}
		}
		$stmt->close();
		$stmt = $this->conn->prepare("SELECT COUNT(CELRIC.CANTIDAD), COUNT(CELBIM.CANTIDAD), COUNT(CELBAR.CANTIDAD) FROM CV CEVE LEFT OUTER JOIN CELULARESRICOLINO CELRIC ON CEVE.CODIGO = CELRIC.CODIGO LEFT OUTER JOIN CELULARESBARCEL CELBAR ON CEVE.CODIGO = CELBAR.CODIGO LEFT OUTER JOIN CELULARESBIMBO CELBIM ON CEVE.CODIGO = CELBIM.CODIGO WHERE CEVE.SPRINT = 'TMM'");
		$stmt->execute();
		$result = $stmt->get_result();
		while($row = $result->fetch_row()){
			if($row[0] != 0 || $row[1] != 0 || $row[2] != 0){
				$sprint = $sprint .  ', TMM';
			}
		}
		return $sprint;
	}
	
	public function obtenerConteoBajaSinRegBarcel() {
		$stmt = $this->conn->prepare("SELECT COUNT(*) FROM DETALLESBAJAS WHERE EMPRESA LIKE '%BARCEL%' AND ORGANIZACIONPROV LIKE '%NO REGISTRADO%'");
		if($stmt->execute()){
			$result = $stmt->get_result();
			while($row = $result->fetch_row()){
				$inventario = $row[0];
			}
			$stmt->close();
			return $inventario;
		} else {
			return false;
		}
	}
	
	public function obtenerConteoBajaSinRegBimbo() {
		$stmt = $this->conn->prepare("SELECT COUNT(*) FROM DETALLESBAJAS WHERE EMPRESA LIKE '%BIMBO%' AND ORGANIZACIONPROV LIKE '%NO REGISTRADO%'");
		if($stmt->execute()){
			$result = $stmt->get_result();
			while($row = $result->fetch_row()){
				$inventario = $row[0];
			}
			$stmt->close();
			return $inventario;
		} else {
			return false;
		}
	}
	
	public function obtenerConteoBajaSinRegRicolino() {
		$stmt = $this->conn->prepare("SELECT COUNT(*) FROM DETALLESBAJAS WHERE EMPRESA LIKE '%RICOLINO%' AND ORGANIZACIONPROV LIKE '%NO REGISTRADO%'");
		if($stmt->execute()){
			$result = $stmt->get_result();
			while($row = $result->fetch_row()){
				$inventario = $row[0];
			}
			$stmt->close();
			return $inventario;
		} else {
			return false;
		}
	}
	
	public function obtenerReporteBARCEL(){
		$stmt = $this->conn->prepare("SELECT 
CEVE.CODIGO, 
CEVE.NOMBRE, 
CEL.CANTIDAD AS CELULARES, 
CEVE.SPRINT, 
COUNT(INV.NOMBRECV),
MDI.HANDHELD AS RUTA, 
HH.CANTIDAD AS HANDHELDS 
FROM CV CEVE 
LEFT OUTER JOIN CELULARESBARCEL CEL ON CEVE.CODIGO = CEL.CODIGO 
LEFT OUTER JOIN RUTAS MDI ON CEVE.CODIGO = MDI.CV 
LEFT OUTER JOIN HANDHELDBARCEL HH ON CEVE.CODIGO = HH.CV 
LEFT OUTER JOIN INVENTARIO INV ON CEVE.NOMBRE = INV.NOMBRECV
AND INV.EMPRESA = 'BARCEL' 
WHERE CEVE.CODIGO < 20000 GROUP BY CEVE.CODIGO");
		if($stmt->execute()){
			$result = $stmt->get_result();
			$index = 0;
			while($row = $result->fetch_row()){
				$inventario[$index][0] = $row[0];
				$inventario[$index][1] = $row[1];
				$inventario[$index][2] = intval($row[2]);
				$inventario[$index][3] = $row[3];
				$inventario[$index][4] = intval($row[4]);
				$inventario[$index][5] = intval($row[5]);
				$inventario[$index][6] = intval($row[6]);
				$inventario[$index][7] = $inventario[$index][6] - $inventario[$index][5];
				$inventario[$index][8] = $inventario[$index][6] - $inventario[$index][2];
				$index++;
			}
			$stmt->close();
			return $inventario;
		} else {
			return false;
		}
	}
	
	public function obtenerReporteBIMBO(){
		$stmt = $this->conn->prepare("SELECT 
CEVE.CODIGO, 
CEVE.NOMBRE, 
CEL.CANTIDAD AS CELULARES, 
CEVE.SPRINT, 
COUNT(INV.NOMBRECV),
MDI.HANDHELD AS RUTA, 
HH.CANTIDAD AS HANDHELDS 
FROM CV CEVE 
LEFT OUTER JOIN CELULARESBIMBO CEL ON CEVE.CODIGO = CEL.CODIGO 
LEFT OUTER JOIN RUTAS MDI ON CEVE.CODIGO = MDI.CV 
LEFT OUTER JOIN HANDHELDBIMBO HH ON CEVE.CODIGO = HH.CV 
LEFT OUTER JOIN INVENTARIO INV ON CEVE.NOMBRE = INV.NOMBRECV
AND INV.EMPRESA = 'BIMBO' 
WHERE CEVE.CODIGO < 30000 AND CEVE.CODIGO > 20000 GROUP BY CEVE.CODIGO");
		if($stmt->execute()){
			$result = $stmt->get_result();
			$index = 0;
			while($row = $result->fetch_row()){
				$inventario[$index][0] = $row[0];
				$inventario[$index][1] = $row[1];
				$inventario[$index][2] = intval($row[2]);
				$inventario[$index][3] = $row[3];
				$inventario[$index][4] = intval($row[4]);
				$inventario[$index][5] = intval($row[5]);
				$inventario[$index][6] = intval($row[6]);
				$inventario[$index][7] = $inventario[$index][6] - $inventario[$index][5];
				$inventario[$index][8] = $inventario[$index][6] - $inventario[$index][2];
				$index++;
			}
			$stmt->close();
			return $inventario;
		} else {
			return false;
		}
	}
	
	public function reporteBarcel(){
		$stmt = $this->conn->prepare("SELECT SUM(CANTIDAD) FROM CELULARESBARCEL");
		$reporte = array();
		if($stmt->execute()){
			$result = $stmt->get_result();
			while($row = $result->fetch_row()){
				$reporte[0] = $row[0];
				$reporte[1] = $row[0] * 0.9;
			}
			$stmt->close();
		} else {
			return false;
		}
		$stmt = $this->conn->prepare("SELECT SUM(CANTIDAD) FROM HANDHELDBARCEL");
		if($stmt->execute()){
			$result = $stmt->get_result();
			while($row = $result->fetch_row()){
				$reporte[2] = $row[0];
				$reporte[3] = $reporte[1] - $row[0];
			}
			$stmt->close();
		} else {
			return false;
		}
		$stmt = $this->conn->prepare("SELECT COUNT(*) FROM DETALLESBAJAS WHERE EMPRESA LIKE '%BARCEL%'");
		if($stmt->execute()){
			$result = $stmt->get_result();
			while($row = $result->fetch_row()){
				$reporte[4] = $row[0];
			}
			$stmt->close();
		} else {
			return false;
		}
		$stmt = $this->conn->prepare("SELECT COUNT(*) FROM DETALLESBAJAS DB LEFT OUTER JOIN INVENTARIO INV ON INV.SERIE = DB.SERIE WHERE INV.EMPRESA = 'BARCEL' AND DB.EMPRESA != ''");
		if($stmt->execute()){
			$result = $stmt->get_result();
			while($row = $result->fetch_row()){
				$reporte[5] = $row[0];
			}
			$stmt->close();
		} else {
			return false;
		}
		$stmt = $this->conn->prepare("SELECT COUNT(*) FROM INVENTARIO WHERE EMPRESA = 'BARCEL' AND REMORZAR = 'SI'");
		if($stmt->execute()){
			$result = $stmt->get_result();
			while($row = $result->fetch_row()){
				$reporte[6] = $row[0];
			}
			$stmt->close();
		} else {
			return false;
		}
		return $reporte;
	}
	
	public function reporteBimbo(){
		$stmt = $this->conn->prepare("SELECT SUM(CANTIDAD) FROM CELULARESBIMBO");
		$reporte = array();
		if($stmt->execute()){
			$result = $stmt->get_result();
			while($row = $result->fetch_row()){
				$reporte[0] = $row[0];
				$reporte[1] = $row[0] * 0.9;
			}
			$stmt->close();
		} else {
			return false;
		}
		$stmt = $this->conn->prepare("SELECT SUM(CANTIDAD) FROM HANDHELDBIMBO");
		if($stmt->execute()){
			$result = $stmt->get_result();
			while($row = $result->fetch_row()){
				$reporte[2] = $row[0];
				$reporte[3] = $reporte[1] - $row[0];
			}
			$stmt->close();
		} else {
			return false;
		}
		$stmt = $this->conn->prepare("SELECT COUNT(*) FROM DETALLESBAJAS WHERE EMPRESA LIKE '%BIMBO%'");
		if($stmt->execute()){
			$result = $stmt->get_result();
			while($row = $result->fetch_row()){
				$reporte[4] = $row[0];
			}
			$stmt->close();
		} else {
			return false;
		}
		$stmt = $this->conn->prepare("SELECT COUNT(*) FROM DETALLESBAJAS DB LEFT OUTER JOIN INVENTARIO INV ON INV.SERIE = DB.SERIE WHERE INV.EMPRESA = 'BIMBO' AND DB.EMPRESA != ''");
		if($stmt->execute()){
			$result = $stmt->get_result();
			while($row = $result->fetch_row()){
				$reporte[5] = $row[0];
			}
			$stmt->close();
		} else {
			return false;
		}
		$stmt = $this->conn->prepare("SELECT COUNT(*) FROM INVENTARIO WHERE EMPRESA = 'BIMBO' AND REMORZAR = 'SI'");
		if($stmt->execute()){
			$result = $stmt->get_result();
			while($row = $result->fetch_row()){
				$reporte[6] = $row[0];
			}
			$stmt->close();
		} else {
			return false;
		}
		return $reporte;
	}
	
	public function reporteRicolino(){
		$stmt = $this->conn->prepare("SELECT SUM(CANTIDAD) FROM CELULARESRICOLINO");
		$reporte = array();
		if($stmt->execute()){
			$result = $stmt->get_result();
			while($row = $result->fetch_row()){
				$reporte[0] = $row[0];
				$reporte[1] = $row[0] * 0.9;
			}
			$stmt->close();
		} else {
			return false;
		}
		$stmt = $this->conn->prepare("SELECT SUM(CANTIDAD) FROM HANDHELDRICOLINO");
		if($stmt->execute()){
			$result = $stmt->get_result();
			while($row = $result->fetch_row()){
				$reporte[2] = $row[0];
				$reporte[3] = $reporte[1] - $row[0];
			}
			$stmt->close();
		} else {
			return false;
		}
		$stmt = $this->conn->prepare("SELECT COUNT(*) FROM DETALLESBAJAS WHERE EMPRESA LIKE '%RICOLINO%'");
		if($stmt->execute()){
			$result = $stmt->get_result();
			while($row = $result->fetch_row()){
				$reporte[4] = $row[0];
			}
			$stmt->close();
		} else {
			return false;
		}
		$stmt = $this->conn->prepare("SELECT COUNT(*) FROM DETALLESBAJAS DB LEFT OUTER JOIN INVENTARIO INV ON INV.SERIE = DB.SERIE WHERE INV.EMPRESA = 'RICOLINO' AND DB.EMPRESA != ''");
		if($stmt->execute()){
			$result = $stmt->get_result();
			while($row = $result->fetch_row()){
				$reporte[5] = $row[0];
			}
			$stmt->close();
		} else {
			return false;
		}
		$stmt = $this->conn->prepare("SELECT COUNT(*) FROM INVENTARIO WHERE EMPRESA = 'RICOLINO' AND REMORZAR = 'SI'");
		if($stmt->execute()){
			$result = $stmt->get_result();
			while($row = $result->fetch_row()){
				$reporte[6] = $row[0];
			}
			$stmt->close();
		} else {
			return false;
		}
		return $reporte;
	}
	
	public function obtenerReporteRICOLINO(){
		$stmt = $this->conn->prepare("SELECT 
CEVE.CODIGO, 
CEVE.NOMBRE, 
CEL.CANTIDAD AS CELULARES, 
CEVE.SPRINT, 
COUNT(INV.NOMBRECV),
MDI.HANDHELD AS RUTA, 
HH.CANTIDAD AS HANDHELDS 
FROM CV CEVE 
LEFT OUTER JOIN CELULARESRICOLINO CEL ON CEVE.CODIGO = CEL.CODIGO 
LEFT OUTER JOIN RUTAS MDI ON CEVE.CODIGO = MDI.CV 
LEFT OUTER JOIN HANDHELDRICOLINO HH ON CEVE.CODIGO = HH.CV 
LEFT OUTER JOIN INVENTARIO INV ON CEVE.NOMBRE = INV.NOMBRECV
AND INV.EMPRESA = 'RICOLINO' 
WHERE CEVE.CODIGO >30000 GROUP BY CEVE.CODIGO");
		if($stmt->execute()){
			$result = $stmt->get_result();
			$index = 0;
			while($row = $result->fetch_row()){
				$inventario[$index][0] = $row[0];
				$inventario[$index][1] = $row[1];
				$inventario[$index][2] = intval($row[2]);
				$inventario[$index][3] = $row[3];
				$inventario[$index][4] = intval($row[4]);
				$inventario[$index][5] = intval($row[5]);
				$inventario[$index][6] = intval($row[6]);
				$inventario[$index][7] = $inventario[$index][6] - $inventario[$index][5];
				$inventario[$index][8] = $inventario[$index][6] - $inventario[$index][2];
				$index++;
			}
			$stmt->close();
			return $inventario;
		} else {
			return false;
		}
	}
	
	public function añadirInventario($array) {
		$statement = "INSERT INTO INVENTARIO (ID, REGION, NOMBRECV, FECHA, ENTREGANOMBRE, DISPOSITIVO, MARCA, MODELO, SERIE, REMORZAR, ESTADO, BODEGA, EMPRESA) VALUES $array";
		$db = new Db_Connect();
		$stmt = $db->connect();
		$result = $stmt->query($statement);
		$stmt->close();
		return $result;
	}
	
	public function añadirCV($array) {
		$statement = 'INSERT INTO CV (NOMBRE, CODIGO, SPRINT) VALUES ';
		for ($i = 0; $i < count($array); $i++) {
			if($i == count($array) - 1) {
				$statement = $statement . '("' . implode('", "', $array[$i]) . '")';
			} else {
				$statement = $statement . '("' . implode('", "', $array[$i]) . '"),';
			}
		}
		$db = new Db_Connect();
		$stmt = $db->connect();
		$result = $stmt->query($statement);
		$stmt->close();
		return $result;
	}
	
	public function añadirHHBarcel($array) {
		$statement = 'INSERT INTO HANDHELDBARCEL(CV, CANTIDAD) VALUES ';
		for ($i = 0; $i < count($array); $i++) {
			if($i == count($array) - 1) {
				$statement = $statement . '("' . implode('", "', $array[$i]) . '")';
			} else {
				$statement = $statement . '("' . implode('", "', $array[$i]) . '"),';
			}
		}
		$db = new Db_Connect();
		$stmt = $db->connect();
		$result = $stmt->query($statement);
		$stmt->close();
		return $result;
	}
	
	public function añadirHHBimbo($array) {
		$statement = 'INSERT INTO HANDHELDBIMBO(CV, CANTIDAD) VALUES ';
		for ($i = 0; $i < count($array); $i++) {
			if($i == count($array) - 1) {
				$statement = $statement . '("' . implode('", "', $array[$i]) . '")';
			} else {
				$statement = $statement . '("' . implode('", "', $array[$i]) . '"),';
			}
		}
		$db = new Db_Connect();
		$stmt = $db->connect();
		$result = $stmt->query($statement);
		$stmt->close();
		return $result;
	}
	
	public function añadirHHRicolino($array) {
		$statement = 'INSERT INTO HANDHELDRICOLINO(CV, CANTIDAD) VALUES ';
		for ($i = 0; $i < count($array); $i++) {
			if($i == count($array) - 1) {
				$statement = $statement . '("' . implode('", "', $array[$i]) . '")';
			} else {
				$statement = $statement . '("' . implode('", "', $array[$i]) . '"),';
			}
		}
		$db = new Db_Connect();
		$stmt = $db->connect();
		$result = $stmt->query($statement);
		$stmt->close();
		return $result;
	}
	
	public function añadirCelularesBARCEL($array) {
		$statement = 'INSERT INTO CELULARESBARCEL(CODIGO, CV, CANTIDAD) VALUES ';
		for ($i = 0; $i < count($array); $i++) {
			if($i == count($array) - 1) {
				$statement = $statement . '("' . implode('", "', $array[$i]) . '")';
			} else {
				$statement = $statement . '("' . implode('", "', $array[$i]) . '"),';
			}
		}
		$db = new Db_Connect();
		$stmt = $db->connect();
		$result = $stmt->query($statement);
		$stmt->close();
		return $result;
	} 
	
	public function añadirCelularesBIMBO($array) {
		$statement = 'INSERT INTO CELULARESBIMBO(CODIGO, CV, CANTIDAD) VALUES ';
		for ($i = 0; $i < count($array); $i++) {
			if($i == count($array) - 1) {
				$statement = $statement . '("' . implode('", "', $array[$i]) . '")';
			} else {
				$statement = $statement . '("' . implode('", "', $array[$i]) . '"),';
			}
		}
		$db = new Db_Connect();
		$stmt = $db->connect();
		$result = $stmt->query($statement);
		$stmt->close();
		return $result;
	}
	
	public function añadirCelularesRICOLINO($array) {
		$statement = 'INSERT INTO CELULARESRICOLINO(CODIGO, CV, CANTIDAD) VALUES ';
		for ($i = 0; $i < count($array); $i++) {
			if($i == count($array) - 1) {
				$statement = $statement . '("' . implode('", "', $array[$i]) . '")';
			} else {
				$statement = $statement . '("' . implode('", "', $array[$i]) . '"),';
			}
		}
		$db = new Db_Connect();
		$stmt = $db->connect();
		$result = $stmt->query($statement);
		$stmt->close();
		return $result;
	}
	
	public function añadirRutas($array) {
		$statement = 'INSERT INTO RUTAS(CV, PAIS, GERENCIA, RUTAS, HANDHELD, STOCKOP) VALUES ';
		for ($i = 0; $i < count($array); $i++) {
			if($i == count($array) - 1) {
				$statement = $statement . '("' . implode('", "', $array[$i]) . '")';
			} else {
				$statement = $statement . '("' . implode('", "', $array[$i]) . '"),';
			}
		}
		$db = new Db_Connect();
		$stmt = $db->connect();
		$result = $stmt->query($statement);
		$stmt->close();
		return $result;
	}
	
	public function añadirDetalles($array) {
		$statement = 'INSERT INTO DETALLESBAJAS (SERIE, EMPRESA, ORGANIZACIONPROV, FECHABAJA, TICKET, MOTIVO, FECHAREPORTE, BAJA_APLICADA) VALUES ';
		for ($i = 0; $i < count($array); $i++) {
			if($i == count($array) - 1) {
				$statement = $statement . '("' . implode('", "', $array[$i]) . '")';
			} else {
				$statement = $statement . '("' . implode('", "', $array[$i]) . '"),';
			}
		}
		$db = new Db_Connect();
		$stmt = $db->connect();
		$result = $stmt->query($statement);
		$stmt->close();
		return $result;
	}
	
	public function almacenarUsuario($email, $password) {
		$stmt = $this->conn->prepare("SELECT COUNT(*) FROM USUARIOS");
		$stmt->execute();
		$stmt->store_result();
		$result = $this->fetchAssocStatement($stmt);
		$stmt->close();
		$uuid = $result['COUNT(*)'];
		$hash = $this->hashSSHA($password);
		$encrypted_password = $hash["encrypted"];
		$salt = $hash["salt"];
		$stmt = $this->conn->prepare("INSERT INTO USUARIOS VALUES(?, ?, ?, ?)");
		$stmt->bind_param("ssss", $uuid, $email, $encrypted_password, $salt);
		$result = $stmt->execute();
		$stmt->close();
		return $result;
	}

	public function getUsuario($email, $password) {
		$stmt = $this->conn->prepare("SELECT * FROM USUARIOS WHERE EMAIL = ?");
		$stmt->bind_param("s", $email);
		if ($stmt->execute()) {
			$stmt->store_result();
			$user = $this->fetchAssocStatement($stmt);
			$stmt->close();
			$salt = $user['salt'];
			$encrypted_password = $user['encrypted_password'];
			$hash = $this->checkhashSSHA($salt, $password);
			if ($encrypted_password == $hash) {
				return $user;
			}
		} else {
			return NULL;
		}
	}
	
	public function obtenerCentrosDeVenta($empresa) {
		$STATEMENT = "SELECT CODIGO FROM CV WHERE ";
		if($empresa == 'barcel' || $empresa == 'Barcel') {
			$STATEMENT .= "CODIGO < 20000";
		}
		elseif($empresa == 'bimbo' || $empresa == 'Bimbo') {
			$STATEMENT .= "CODIGO > 20000 AND CODIGO < 30000";
		}
		elseif($empresa == 'ricolino' || $empresa == 'Ricolino') {
			$STATEMENT .= "CODIGO > 30000";
		}
		$stmt = $this->conn->prepare($STATEMENT);
		if ($stmt->execute()) {
			$result = $stmt->get_result();
			if($result == false) {
				return false;
			}
			$index = 0;
			$cv = array();
			while($row = $result->fetch_row()){
				$cv[$index] = $row[0];
				$index++;
			}
			$stmt->close();
			return $cv;
		} else {
			return NULL;
		}
	}
	
	public function obtenerInfoDeCV($ceve) {
		if($ceve < 20000) {
			$stmt = $this->conn->prepare("SELECT CEL.CANTIDAD, MDI.HANDHELD, HH.CANTIDAD FROM CV CEVE LEFT OUTER JOIN CELULARESBARCEL CEL ON CEVE.CODIGO = CEL.CODIGO LEFT OUTER JOIN RUTAS MDI ON CEVE.CODIGO = MDI.CV LEFT OUTER JOIN HANDHELDBARCEL HH ON CEVE.CODIGO = HH.CV WHERE CEVE.CODIGO = ?");
		} elseif($ceve > 30000) {
			$stmt = $this->conn->prepare("SELECT CEL.CANTIDAD, MDI.HANDHELD, HH.CANTIDAD FROM CV CEVE LEFT OUTER JOIN CELULARESRICOLINO CEL ON CEVE.CODIGO = CEL.CODIGO LEFT OUTER JOIN RUTAS MDI ON CEVE.CODIGO = MDI.CV LEFT OUTER JOIN HANDHELDRICOLINO HH ON CEVE.CODIGO = HH.CV WHERE CEVE.CODIGO = ?");
		} else {
			$stmt = $this->conn->prepare("SELECT CEL.CANTIDAD, MDI.HANDHELD, HH.CANTIDAD FROM CV CEVE LEFT OUTER JOIN CELULARESBIMBO CEL ON CEVE.CODIGO = CEL.CODIGO LEFT OUTER JOIN RUTAS MDI ON CEVE.CODIGO = MDI.CV LEFT OUTER JOIN HANDHELDBIMBO HH ON CEVE.CODIGO = HH.CV WHERE CEVE.CODIGO = ?");
		}
		$stmt->bind_param("s", $ceve);
		if ($stmt->execute()) {
			$result = $stmt->get_result();
			$data = array();
			while($row = $result->fetch_row()){
				$data[0] = $row[0];
				$data[1] = $row[1];
				$data[2] = $row[2];
			}
			$stmt->close();
			return $data;
		} else {
			return NULL;
		}
	}
	
	public function actualizarDatosPorCV($empresa, $ceve, $celular, $ruta, $handheld){
		if($empresa == 'barcel') {
			$stmt = $this->conn->prepare("UPDATE CELULARESBARCEL SET CANTIDAD = ? WHERE CODIGO = ?");
			$stmt->bind_param("ss", $celular, $ceve);
			if(!$stmt->execute()) {
				return false;
			}
			$stmt->close();
			$stmt = $this->conn->prepare("UPDATE HANDHELDBARCEL SET CANTIDAD = ? WHERE CV = ?");
			$stmt->bind_param("ss", $handheld, $ceve);
			if(!$stmt->execute()) {
				return false;
			}
			$stmt->close();
		} elseif($empresa == 'bimbo') {
			$stmt = $this->conn->prepare("UPDATE CELULARESBIMBO SET CANTIDAD = ? WHERE CODIGO = ?");
			$stmt->bind_param("ss", $celular, $ceve);
			if(!$stmt->execute()) {
				return false;
			}
			$stmt->close();
			unset($stmt);
			$stmt = $this->conn->prepare("UPDATE HANDHELDBIMBO SET CANTIDAD = ? WHERE CV = ?");
			$stmt->bind_param("ss", $handheld, $ceve);
			if(!$stmt->execute()) {
				return false;
			}
			$stmt->close();
		} elseif($empresa == 'ricolino') {
			$stmt = $this->conn->prepare("UPDATE CELULARESRICOLINO SET CANTIDAD = ? WHERE CODIGO = ?");
			$stmt->bind_param("ss", $celular, $ceve);
			if(!$stmt->execute()) {
				return false;
			}
			$stmt->close();
			$stmt = $this->conn->prepare("UPDATE HANDHELDRICOLINO SET CANTIDAD = ? WHERE CV = ?");
			$stmt->bind_param("ss", $handheld, $ceve);
			if(!$stmt->execute()) {
				return false;
			}
			$stmt->close();
		}
		$stmt = $this->conn->prepare("UPDATE RUTAS SET HANDHELD = ? WHERE CV = ?");
		$stmt->bind_param("ss", $ruta, $ceve);
		if(!$stmt->execute()) {
			return false;
		}
		$stmt->close();
		return true;
	}
	
	public function changeRootPassword($password){
		$hash = $this->hashSSHA($password);
		$encrypted_password = $hash["encrypted"];
		$salt = $hash["salt"];
		$email = 'root@localhost';
		$stmt = $this->conn->prepare("UPDATE USUARIOS SET encrypted_password = ?, salt = ? WHERE EMAIL = ?;");
		$stmt->bind_param("sss", $encrypted_password, $salt, $email);
		$result = $stmt->execute();
		$stmt->close();
		if ($result) {
			return true;
		} else {
			return false;
		}
	}

	public function isUserExisted($email) {
		$stmt = $this->conn->prepare("SELECT EMAIL FROM USUARIOS WHERE EMAIL = ?");
		$stmt->bind_param("s", $email);
		$stmt->execute();
		$stmt->store_result();
		if ($stmt->num_rows > 0) {
			$stmt->close();
			return true;
		} else {
			$stmt->close();
			return false;
		}
	}

	public function hashSSHA($password) {
		$salt = sha1(rand());
		$salt = substr($salt, 0, 10);
		$encrypted = base64_encode(sha1($password . $salt, true) . $salt);
		$hash = array("salt" => $salt, "encrypted" => $encrypted);
		return $hash;
	}

	public function checkhashSSHA($salt, $password) {
		return base64_encode(sha1($password . $salt, true) . $salt);
	}
	
	public function fetchAssocStatement($stmt){
		if($stmt->num_rows>0){
			$result = array();
			$md = $stmt->result_metadata();
			$params = array();
			while($field = $md->fetch_field()) {
				$params[] = &$result[$field->name];
			}
			call_user_func_array(array($stmt, 'bind_result'), $params);
			if($stmt->fetch())
				return $result;
		}
		return null;
	}
}
?>