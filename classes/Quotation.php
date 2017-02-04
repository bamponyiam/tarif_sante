<?php
require_once("classes/Database.php");

class Quotation{
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

	
	public function getAllQuotation(){
		
		$sql = "SELECT * FROM quotations ORDER BY id_quote ASC ";
		$result = $this->mysqli->query($sql);
		$all = array();
		
		if($result->num_rows > 0){
			while($row = $result->fetch_assoc()){
				$all[] = $row;
			}
		}
		return $all;
	}
	
	public function getAllQuotationByOffice($id){
		
		$sql = "SELECT quotations.* FROM quotations,user WHERE quotations.id_user = user.id_user AND user.office = '".$id."' ORDER BY id_quote ASC ";
		$result = $this->mysqli->query($sql);
		$all = array();
		
		if($result->num_rows > 0){
			while($row = $result->fetch_assoc()){
				$all[] = $row;
			}
		}
		return $all;
	}
	
	public function getQuotationById($id){
		
		$sql = "SELECT * FROM quotations WHERE id_quote = ".$id;
		$result = $this->mysqli->query($sql);
		$row = $result->fetch_assoc();
		return $row;
	}
	
	public function insertQuotation($data){
		$sql = " INSERT INTO quotations VALUES(NULL,
			 '".$this->mysqli->real_escape_string($data['reference'])."',
			 '".$this->mysqli->real_escape_string($data['currency'])."',
			 NOW(),
			 '".$this->mysqli->real_escape_string($data['type_con'])."',
			 '".$this->mysqli->real_escape_string($data['company'])."',
			 '".$this->mysqli->real_escape_string($data['address'])."',
			 '".$this->mysqli->real_escape_string($data['tel'])."',
			 '".$this->mysqli->real_escape_string($data['email'])."',
			 '".$this->mysqli->real_escape_string($data['country'])."',
			 '".$this->mysqli->real_escape_string($data['profession'])."',
			 'NEW',
			 ".$this->mysqli->real_escape_string($data['id_user'])."
			 )";
		$this->mysqli->query($sql);
		return $this->mysqli->insert_id;
		//echo $sql;
	}
	
	public function updateQuotation($data){
		$sql = " UPDATE quotations SET 
			 company = '".$this->mysqli->real_escape_string($data['company'])."',
			 address = '".$this->mysqli->real_escape_string($data['address'])."',
			 tel = '".$this->mysqli->real_escape_string($data['tel'])."',
			 email = '".$this->mysqli->real_escape_string($data['email'])."',
			 country = '".$this->mysqli->real_escape_string($data['country'])."',
			 profession = '".$this->mysqli->real_escape_string($data['profession'])."'
			 WHERE id_quote = ".$this->mysqli->real_escape_string($data['id_quote']);
		$this->mysqli->query($sql);
		return $this->mysqli->insert_id;
		//echo $sql;
	}
	
	public function insertSelectedPremium($data){
		$sql = " INSERT INTO premium_quote_selected VALUES(NULL,
			 ".$this->mysqli->real_escape_string($data['id_level']).",
			 ".$this->mysqli->real_escape_string($data['id_premium']).",
			 NOW(),
			 NOW(),
			 ".$this->mysqli->real_escape_string($data['1st_adult']).",
			 ".$this->mysqli->real_escape_string($data['2nd_adult']).",
			 ".$this->mysqli->real_escape_string($data['1_children']).",
			 ".$this->mysqli->real_escape_string($data['2_children']).",
			 ".$this->mysqli->real_escape_string($data['3_children']).",
			 ".$this->mysqli->real_escape_string($data['4_children']).",
			 ".$this->mysqli->real_escape_string($data['discount']).",
			 ".$this->mysqli->real_escape_string($data['family_pack']).",
			 ".$this->mysqli->real_escape_string($data['children_pack']).",
			 ".$this->mysqli->real_escape_string($data['adh_cie_fee']).",
			 ".$this->mysqli->real_escape_string($data['adh_poema_fee']).",
			 ".$this->mysqli->real_escape_string($data['ass_cie_indiv']).",
			 ".$this->mysqli->real_escape_string($data['ass_cie_family']).",
			 ".$this->mysqli->real_escape_string($data['ass_poema']).",
			 ".$this->mysqli->real_escape_string($data['id_quote'])."
			 )";
		$this->mysqli->query($sql);
		//echo $sql;
	}
	
	public function deleteQuote($id){
		$sql = "DELETE FROM quotations WHERE id_quote=".$id;
		$this->mysqli->query($sql);
	}
	
	public function deleteSelectedPremiumByQuote($id){
		$sql = "DELETE FROM premium_quote_selected WHERE id_quote=".$id;
		$this->mysqli->query($sql);
	}
	
	public function deleteSearchByQuote($id){
		$sql = "DELETE FROM search WHERE id_quote=".$id;
		$this->mysqli->query($sql);
	}
	
	
	public function updateSelectedPremium($data){
		$sql = "UPDATE premium_quote_selected SET 
				 date_modify = NOW(),
				 1st_adult = ".$this->mysqli->real_escape_string($data['1st_adult']).",
				 2nd_adult = ".$this->mysqli->real_escape_string($data['2nd_adult']).",
				 1_children = ".$this->mysqli->real_escape_string($data['1_children']).",
				 2_children = ".$this->mysqli->real_escape_string($data['2_children']).",
				 3_children = ".$this->mysqli->real_escape_string($data['3_children']).",
				 4_children = ".$this->mysqli->real_escape_string($data['4_children']).",
				 4_children = ".$this->mysqli->real_escape_string($data['4_children']).",
				 family_pack = ".$this->mysqli->real_escape_string($data['family_pack']).",
				 children_pack = ".$this->mysqli->real_escape_string($data['children_pack']).",
				 adh_cie_fee = ".$this->mysqli->real_escape_string($data['adh_cie_fee']).",
				 adh_poema_fee = ".$this->mysqli->real_escape_string($data['adh_poema_fee']).",
				 ass_cie_indiv = ".$this->mysqli->real_escape_string($data['ass_cie_indiv']).",
				 ass_cie_family = ".$this->mysqli->real_escape_string($data['ass_cie_family']).",
				 ass_poema = ".$this->mysqli->real_escape_string($data['ass_poema'])."  
				 WHERE id_premium_selected = ".$this->mysqli->real_escape_string($data['id_premium_selected'])." ";
		
		$this->mysqli->query($sql);
		//echo $sql;
	}
	
	public function getAdditionalFieldByIdPremiumSelected($id){
		$sql = "SELECT * FROM additional_fields_premium_selected WHERE id_premium_selected = ".$id." ORDER BY id_field ASC";
		$result = $this->mysqli->query($sql);
		$all = array();
		
		if($result->num_rows > 0){
			while($row = $result->fetch_assoc()){
				$all[] = $row;
			}
		}
		return $all;
	}
	
	public function deleteAdditionalField($id_premium){
		$sql = "DELETE FROM additional_fields_premium_selected WHERE id_premium_selected = ".$id_premium;
		$this->mysqli->query($sql);
	}
	
	public function insertAdditionalField($data){
		$sql = "INSERT INTO additional_fields_premium_selected VALUES(NULL,
				'".$this->mysqli->real_escape_string($data['name_field'])."',
				".$this->mysqli->real_escape_string($data['value_field']).",
				".$this->mysqli->real_escape_string($data['id_premium_selected']).")";
		$this->mysqli->query($sql);
		//echo $sql;
	}
	
	public function getSelectedPremiumByQuote($id){
		$sql = "SELECT * FROM premium_quote_selected WHERE id_quote = ".$id." ORDER BY id_premium_selected ASC";
		$result = $this->mysqli->query($sql);
		$all = array();
		
		if($result->num_rows > 0){
			while($row = $result->fetch_assoc()){
				$all[] = $row;
			}
		}
		return $all;
	}
	public function getSelectedPremiumByQuoteByLevel($id,$level){
		$sql = "SELECT premium_quote_selected.*,levels.name_level,levels.name_plan,levels.garanty,levels.note_en,levels.note_fr FROM premium_quote_selected,levels WHERE premium_quote_selected.id_quote = ".$id."  AND premium_quote_selected.id_level = levels.id_level AND levels.name_level = '".$level."' ORDER BY id_premium_selected ASC";
		//echo $sql;
		$result = $this->mysqli->query($sql);
		$all = array();
		
		if($result->num_rows > 0){
			while($row = $result->fetch_assoc()){
				$all[] = $row;
			}
		}
		return $all;
	}
	public function getSelectedPremiumById($id){
		$sql = "SELECT * FROM premium_quote_selected WHERE id_premium_selected = ".$id." ";
		$result = $this->mysqli->query($sql);
		$row = $result->fetch_assoc();
		return $row;
	}
	
	public function getSearchByQuote($id){
		$sql = "SELECT * FROM search WHERE id_quote = ".$id." ";
		$result = $this->mysqli->query($sql);
		$row = $result->fetch_assoc();
		return $row;
	}
	
	public function insertSearch($data){
		$sql = " INSERT INTO search VALUES(NULL,NOW(),
			 ".$this->mysqli->real_escape_string($data['M1']).",
			 ".$this->mysqli->real_escape_string($data['M2']).",
			 ".$this->mysqli->real_escape_string($data['M3']).",
			 '".$this->mysqli->real_escape_string($data['currency'])."',
			 '".$this->mysqli->real_escape_string($data['year_effective'])."',
			 '".$this->mysqli->real_escape_string($data['location'])."',
			 ".$this->mysqli->real_escape_string($data['local']).",
			 ".$this->mysqli->real_escape_string($data['lifetime']).",
			 ".$this->mysqli->real_escape_string($data['extended_area']).",
			 ".$this->mysqli->real_escape_string($data['id_quote'])."
			 )";
		$this->mysqli->query($sql);
		//echo $sql;
	}
	
}
?>