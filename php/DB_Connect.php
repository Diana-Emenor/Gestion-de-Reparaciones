<?php
class DB_Connect {
	private $conn;

	public function connect() {
		require_once 'Config.php';
		$this->conn = new mysqli(DB_SERVER, DB_USER, DB_PASSWORD, DB_DATABASE);
		return $this->conn;
	}
}
?>