<?php
require_once("classes/Database.php");

class Applicant{
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

	
	public function getApplicantByQuoteIndiv($id){
		
		$sql = "SELECT * FROM applicants WHERE id_quote = '".$id."' ORDER BY id_applicant ASC ";
		$result = $this->mysqli->query($sql);
		$row = $result->fetch_assoc();
		return $row;
	}
	
	public function getApplicantByQuote($id){
		
		$sql = "SELECT * FROM applicants WHERE id_quote = '".$id."' ORDER BY id_applicant ASC ";
		$result = $this->mysqli->query($sql);
		$all = array();
		
		if($result->num_rows > 0){
			while($row = $result->fetch_assoc()){
				$all[] = $row;
			}
		}
		return $all;
	}
	
	public function insertApplicant($data){
		
		$sql = " INSERT INTO applicants VALUES(NULL,
			 '".$this->mysqli->real_escape_string($data['date_of_birth'])."',
			 '".$this->mysqli->real_escape_string($data['sex'])."',
			 ".$this->mysqli->real_escape_string($data['age']).",
			 '".$this->mysqli->real_escape_string($data['type_applicant'])."',
			 ".$this->mysqli->real_escape_string($data['marine']).",
			 '".$this->mysqli->real_escape_string($data['firstname'])."',
			 '".$this->mysqli->real_escape_string($data['lastname'])."',
			 '".$this->mysqli->real_escape_string($data['nationality'])."',
			 ".$this->mysqli->real_escape_string($data['id_quote'])."
			 )";
		$this->mysqli->query($sql);
		//echo $sql;
	}
	
	public function deleteApplicantsByQuote($id){
		$sql = "DELETE FROM applicants WHERE id_quote=".$id;
		$this->mysqli->query($sql);
	}
	
	public function updateApplicant($data){
		
		$sql = " UPDATE applicants SET 
			 firstname = '".$this->mysqli->real_escape_string($data['firstname'])."',
			 lastname = '".$this->mysqli->real_escape_string($data['lastname'])."', 
			 nationality = '".$this->mysqli->real_escape_string($data['nationality'])."'
			 WHERE id_applicant = ".$this->mysqli->real_escape_string($data['id_applicant'])."";
		
		$this->mysqli->query($sql);
	//echo $sql;
	}
}
?>