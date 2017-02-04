<?php
require_once("classes/Database.php");

class Country{
	private $mysqli;
	private static $_instance; //The single instance
	
	public static function getInstance() {
		if(!self::$_instance) { // If no instance then make one
			self::$_instance = new self();
		}
		return self::$_instance;
	}
	private function __construct(){
		$db = Database::getInstance();
		$this->mysqli = $db->getConnection();
	}
	
	public function getAllCountry(){
		
		$sql = "SELECT * FROM countries ORDER BY country_name ASC ";
		$result = $this->mysqli->query($sql);
		$all = array();
		
		if($result->num_rows > 0){
			while($row = $result->fetch_assoc()){
				$all[] = $row;
			}
		}
		return $all;
	}
	
	public function getCountryNameById($id){
		
		$sql = "SELECT country_name FROM countries WHERE id = ".$id." ";
		$result = $this->mysqli->query($sql);
		$row = $result->fetch_assoc();
		return $row;
	}
	
	
}
?>