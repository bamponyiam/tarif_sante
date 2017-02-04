<?php
require_once("classes/Database.php");

class User{
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

	public function insertUser($data){
		$sql = "INSERT INTO user VALUES(NULL,
		'".$this->mysqli->real_escape_string($data['login'])."',
		'".$this->mysqli->real_escape_string($data['password'])."',
		'".$this->mysqli->real_escape_string($data['firstname'])."',
		'".$this->mysqli->real_escape_string($data['lastname'])."',
		'".$this->mysqli->real_escape_string($data['email'])."',
		'".$this->mysqli->real_escape_string($data['office'])."',
		'".$this->mysqli->real_escape_string($data['last_login'])."')";
		$this->mysqli->query($sql);
	}
	
	public function updateUserInfo($data){
		$sql = "UPDATE user SET 
		password = '".$this->mysqli->real_escape_string($data['password'])."',
		firstname = '".$this->mysqli->real_escape_string($data['firstname'])."',
		lastname = '".$this->mysqli->real_escape_string($data['lastname'])."',
		email = '".$this->mysqli->real_escape_string($data['email'])."' 
		WHERE id_user = ".$this->mysqli->real_escape_string($data['id_user']);
		
		$this->mysqli->query($sql);
	}
	
	public function updateUserLastLogin($date,$id){
		$sql = "UPDATE user SET 
		last_login = '".$this->mysqli->real_escape_string($date)."' WHERE id_user = ".$this->mysqli->real_escape_string($id);
		$this->mysqli->query($sql);
	}
	
	public function deleteUser($id){
		$sql = "DELETE FROM user WHERE id_user=".$id;
		$this->mysqli->query($sql);
	}
	
	public function getUserById($id){
		$sql = "SELECT * FROM user WHERE id_user=".$id."";
		$result = $this->mysqli->query($sql);
		$row = $result->fetch_assoc();
		return $row;
	}
	public function getUserByLoginPass($login,$pass){
		$sql = "SELECT * FROM user WHERE login ='".$login."' AND password = '".sha1($pass)."' ";
		$result = $this->mysqli->query($sql);
		
		if($result->num_rows > 0){
			$row = $result->fetch_assoc();
			return $row;
		}else{
			return 0;
		}
	}
	
	public function getAllUser(){
		
		$sql = "SELECT * FROM user ";
		$result = $this->mysqli->query($sql);
		$all = array();
		
		if($result->num_rows > 0){
			while($row = $result->fetch_assoc()){
				$all[] = $row;
			}
		}
		return $all;
	}
	
	
}
?>