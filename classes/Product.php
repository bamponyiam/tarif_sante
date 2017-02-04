<?php
require_once("classes/Database.php");

class Product{
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
	
	public function getAllProduct(){
		
		$sql = "SELECT * FROM products ORDER BY id_product ASC ";
		$result = $this->mysqli->query($sql);
		$all = array();
		
		if($result->num_rows > 0){
			while($row = $result->fetch_assoc()){
				$all[] = $row;
			}
		}
		return $all;
	}
	
	public function getProductById($id){
		$sql = "SELECT * FROM products WHERE id_product = ".$id;
		$result = $this->mysqli->query($sql);
		$row = $result->fetch_assoc();
		return $row;
	}
	
	public function getProductByLevel($id){
		$sql = "SELECT * FROM products,levels WHERE levels.id_level = ".$id." AND products.id_product = levels.id_product ";
		$result = $this->mysqli->query($sql);
		$row = $result->fetch_assoc();
		return $row;
	}
	
	public function getProductFromLevelId($id){
		$sql = "SELECT products.id_product FROM products,levels WHERE products.id_product = levels.id_product AND id_level = ".$id;
		$result = $this->mysqli->query($sql);
		$row = $result->fetch_assoc();
		return $row;
	}
	
	public function insertProduct($data){
		
		$sql = "INSERT INTO products VALUES (NULL,
				'".$this->mysqli->real_escape_string($data['name_product'])."',
				".$this->mysqli->real_escape_string($data['local']).",
				'".$this->mysqli->real_escape_string($data['location'])."',
				".$this->mysqli->real_escape_string($data['LT']).",
				".$this->mysqli->real_escape_string($data['NLT']).",
				".$this->mysqli->real_escape_string($data['Z1']).",
				".$this->mysqli->real_escape_string($data['Z2']).",
				".$this->mysqli->real_escape_string($data['marine']).",
				".$this->mysqli->real_escape_string($data['discount']).",
				".$this->mysqli->real_escape_string($data['discount_percent']).",
				".$this->mysqli->real_escape_string($data['minimum_nb_contract']).",
				'".$this->mysqli->real_escape_string($data['currency'])."',
				'".$this->mysqli->real_escape_string($data['available'])."',
				'".$this->mysqli->real_escape_string($data['type_age_caculaion'])."'
				)";
		$this->mysqli->query($sql);
		//echo $sql;
	}
	
	public function updateProduct($data){
		
		$sql = "UPDATE products SET 
				name_product = '".$this->mysqli->real_escape_string($data['name_product'])."',
				local = ".$this->mysqli->real_escape_string($data['local']).",
				location = '".$this->mysqli->real_escape_string($data['location'])."',
				LT = ".$this->mysqli->real_escape_string($data['LT']).",
				NLT = ".$this->mysqli->real_escape_string($data['NLT']).",
				Z1 = ".$this->mysqli->real_escape_string($data['Z1']).",
				Z2 = ".$this->mysqli->real_escape_string($data['Z2']).",
				marine = ".$this->mysqli->real_escape_string($data['marine']).",
				discount = ".$this->mysqli->real_escape_string($data['discount']).",
				discount_percent = ".$this->mysqli->real_escape_string($data['discount_percent']).",
				minimum_nb_contract = ".$this->mysqli->real_escape_string($data['minimum_nb_contract']).",
				currency = '".$this->mysqli->real_escape_string($data['currency'])."',
				available = '".$this->mysqli->real_escape_string($data['available'])."',
				type_age_caculaion = '".$this->mysqli->real_escape_string($data['type_age_caculaion'])."' 
				WHERE id_product = ".$this->mysqli->real_escape_string($data['id_product'])." ";
		$this->mysqli->query($sql);
		//echo $sql;
	}
	
	public function insertPlanLevel($data){
		$sql = "INSERT INTO levels VALUES (NULL,
				'".$this->mysqli->real_escape_string($data['name_level'])."',
				'".$this->mysqli->real_escape_string($data['name_plan'])."',
				'".$this->mysqli->real_escape_string($data['sex'])."',
				'".$this->mysqli->real_escape_string($data['zone'])."',
				'".$this->mysqli->real_escape_string($data['lifetime_option'])."',
				".$this->mysqli->real_escape_string($data['marine']).",
				".$this->mysqli->real_escape_string($data['deductible']).",
				".$this->mysqli->real_escape_string($data['garanty']).",
				".$this->mysqli->real_escape_string($data['children']).",
				".$this->mysqli->real_escape_string($data['1_children']).",
				".$this->mysqli->real_escape_string($data['2_children']).",
				".$this->mysqli->real_escape_string($data['3_children']).",
				".$this->mysqli->real_escape_string($data['4_children']).",
				".$this->mysqli->real_escape_string($data['5_children']).",
				".$this->mysqli->real_escape_string($data['6_children']).",
				".$this->mysqli->real_escape_string($data['family']).",
				".$this->mysqli->real_escape_string($data['minimum_nb_family']).",
				".$this->mysqli->real_escape_string($data['price_family']).",
				".$this->mysqli->real_escape_string($data['assis_indiv']).",
				".$this->mysqli->real_escape_string($data['assis_family']).",
				".$this->mysqli->real_escape_string($data['adh_fee']).",
				'".$this->mysqli->real_escape_string($data['assistance_detail'])."',
				'".$this->mysqli->real_escape_string($data['room_rate'])."',
				'".$this->mysqli->real_escape_string($data['consultation'])."',
				'".$this->mysqli->real_escape_string($data['public_liability'])."',
				'".$this->mysqli->real_escape_string($data['transfer_fee'])."',
				'".$this->mysqli->real_escape_string($data['note_fr'])."',
				'".$this->mysqli->real_escape_string($data['note_en'])."',
				".$this->mysqli->real_escape_string($data['id_product'])."
				)";
		$this->mysqli->query($sql);
		return $this->mysqli->insert_id;
		echo $sql;
		
	}
	public function updatePlanLevel($data){
		$sql = "UPDATE levels SET 
				name_level = '".$this->mysqli->real_escape_string($data['name_level'])."',
				name_plan = '".$this->mysqli->real_escape_string($data['name_plan'])."',
				sex = '".$this->mysqli->real_escape_string($data['sex'])."',
				zone = '".$this->mysqli->real_escape_string($data['zone'])."',
				lifetime_option = '".$this->mysqli->real_escape_string($data['lifetime_option'])."',
				marine = ".$this->mysqli->real_escape_string($data['marine']).",
				deductible = ".$this->mysqli->real_escape_string($data['deductible']).",
				garanty = ".$this->mysqli->real_escape_string($data['garanty']).",
				children = ".$this->mysqli->real_escape_string($data['children']).",
				1_children = ".$this->mysqli->real_escape_string($data['1_children']).",
				2_children = ".$this->mysqli->real_escape_string($data['2_children']).",
				3_children = ".$this->mysqli->real_escape_string($data['3_children']).",
				4_children = ".$this->mysqli->real_escape_string($data['4_children']).",
				5_children = ".$this->mysqli->real_escape_string($data['5_children']).",
				family = ".$this->mysqli->real_escape_string($data['family']).",
				minimum_nb_family = ".$this->mysqli->real_escape_string($data['minimum_nb_family'])." ,
				price_family = ".$this->mysqli->real_escape_string($data['price_family']).", 
				assis_indiv = ".$this->mysqli->real_escape_string($data['assis_indiv']).", 
				assis_family = ".$this->mysqli->real_escape_string($data['assis_family']).", 
				adh_fee = ".$this->mysqli->real_escape_string($data['adh_fee']).",
				assistance_detail = '".$this->mysqli->real_escape_string($data['assistance_detail'])."',
				room_rate = '".$this->mysqli->real_escape_string($data['room_rate'])."',
				consultation = '".$this->mysqli->real_escape_string($data['consultation'])."',
				public_liability = '".$this->mysqli->real_escape_string($data['public_liability'])."',
				transfer_fee = '".$this->mysqli->real_escape_string($data['transfer_fee'])."',
				note_fr = '".$this->mysqli->real_escape_string($data['note_fr'])."',
				note_en = '".$this->mysqli->real_escape_string($data['note_en'])."' 
				WHERE id_level = ".$this->mysqli->real_escape_string($data['id_level'])." ";
		$this->mysqli->query($sql);
		//echo $sql;
		
	}
	
	public function insertCountryAvailable($data){
		$sql = "INSERT INTO country_available VALUES (NULL,".$this->mysqli->real_escape_string($data['id_product']).",'".$this->mysqli->real_escape_string($data['country'])."')";
		
		$this->mysqli->query($sql);
	}
	
	public function ifCountryAvailable($id_product,$country){
		$sql = "SELECT * FROM country_available WHERE id_product=".$id_product." AND country = '".$country."' ";
		$result = $this->mysqli->query($sql);
		
		if($result->num_rows > 0){
			return true;
		}else{
			return false;
		}
	}
	
	public function deleteCountryAvailableByProduct($id){
		$sql = "DELETE FROM country_available WHERE id_product = ".$id;
		$this->mysqli->query($sql);
	}
	
	public function deletePremiumByLevel($id){
		$sql = "DELETE FROM premium WHERE id_level = ".$id;
		$this->mysqli->query($sql);
		//echo $sql;
	}
	
	public function insertPremium($data){
		$sql = "INSERT INTO premium VALUES (NULL,
				".$this->mysqli->real_escape_string($data['id_level']).",
				".$this->mysqli->real_escape_string($data['age']).",
				".$this->mysqli->real_escape_string($data['price']).",
				'2017'
				)";
		$this->mysqli->query($sql);
		//echo $sql;
	}
	
	public function getPremiumById($id){
		$sql = "SELECT * FROM premium WHERE id_premium = ".$id." ";
		$result = $this->mysqli->query($sql);
		$row = $result->fetch_assoc();
		return $row; 
	}
	public function getLevelByProduct($id){
		$sql = "SELECT * FROM levels WHERE id_product = ".$id." ORDER BY id_level ASC";
		$result = $this->mysqli->query($sql);
		$all = array();
		
		if($result->num_rows > 0){
			while($row = $result->fetch_assoc()){
				$all[] = $row;
			}
		}
		return $all;
	}
	
	public function getLevelById($id){
		$sql = "SELECT * FROM levels WHERE id_level = ".$id." ";
		$result = $this->mysqli->query($sql);
		$row = $result->fetch_assoc();
		return $row;
	}
	
	public function getLevelByPremium($id){
		$sql = "SELECT levels.* FROM levels,premium WHERE levels.id_level = premium.id_level AND premium.id_premium = ".$id." ";
		$result = $this->mysqli->query($sql);
		$row = $result->fetch_assoc();
		return $row;
	}
	
	public function getPremiumByLevel($id){
		$sql = "SELECT * FROM premium WHERE id_level = ".$id." ORDER BY id_premium ASC";
		$result = $this->mysqli->query($sql);
		$all = array();
		
		if($result->num_rows > 0){
			while($row = $result->fetch_assoc()){
				$all[] = $row;
			}
		}
		return $all;
	}
	public function getPremiumByLevelAge($id,$age){
		$sql = "SELECT * FROM premium WHERE id_level = ".$id." AND age = ".$age;
		$result = $this->mysqli->query($sql);
		$row = $result->fetch_assoc();
		return $row;
	}
	
	
	public function getProductDetailsByAge($age,$type_age){
		$sql = "SELECT * FROM products,levels,premium WHERE premium.age = ".$age." AND premium.id_level = levels.id_level AND levels.id_product = products.id_product AND products.type_age_caculaion = '".$type_age."' ";
		$result = $this->mysqli->query($sql);
		$all = array();
		
		if($result->num_rows > 0){
			while($row = $result->fetch_assoc()){
				$all[] = $row;
			}
		}
		return $all;
	}
	
	public function getProductSearch($data){
		
		$sql = "SELECT * FROM products,levels,premium WHERE premium.age = ".$data['age']." AND premium.id_level = levels.id_level AND levels.id_product = products.id_product AND products.type_age_caculaion = '".$data['type_age_caculaion']."' AND products.id_product = ".$data['id_product']." AND (products.available = 'ALL' OR products.available = 'INDIV') ";
		
		if($data['M1'] == 1){
			
			$sql .= " AND (levels.name_level = 'M1' ";
			
			if($data['M2'] == 1){
				$sql .= " OR levels.name_level = 'M2' ";
				
				if($data['M3'] == 1){
					$sql .= " OR levels.name_level = 'M3') ";
				}else{
					$sql .= " ) ";
				}
			}else{
				if($data['M3'] == 1){
					$sql .= " OR levels.name_level = 'M3') ";
				}else{
					$sql .= " ) ";
				}
			}
		}else{
			if($data['M2'] == 1){
				$sql .= " AND (levels.name_level = 'M2' ";
				
				if($data['M3'] == 1){
					$sql .= " OR levels.name_level = 'M3') ";
				}else{
					$sql .= " ) ";
				}
				
			}else{
				if($data['M3'] == 1){
					$sql .= " AND levels.name_level = 'M3' ";
				}
			}
		}
		
		//$sql .= " AND products.currency = '".$data['currency']."' ";
		
		if($data['local'] == 1){
			$sql .= " AND products.local = 1 AND (products.location = '".$data['location']."' OR products.location = 'ALL') ";
		}
		
		//if($data['local'] == 0){
		//	$sql .= "  AND (products.location = '".$data['location']."' OR products.location = 'ALL' OR products.location = '') ";
		//}

		if($data['lifetime'] == 1){
			$sql .= " AND levels.lifetime_option = 'LT' ";
		}

		if($data['sex'] == 'M'){
			$sql .= " AND (levels.sex = 'ALL' OR levels.sex = 'M') ";
		}
		if($data['sex'] == 'F'){
			$sql .= " AND (levels.sex = 'ALL' OR levels.sex = 'F') ";
		}
		if($data['extended_area'] == 1){
			$sql .= " AND levels.zone = 'Z2' ";
		}
		if($data['marine'] == 0){
			$sql .= " AND levels.marine = 0 ";
		}
		
		$sql .= " ORDER BY levels.id_level ASC ";
		
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
	
	public function getPlanAvailableBySearch($data){
		$sql = "SELECT levels.*,products.* FROM products,levels,premium WHERE premium.id_level = levels.id_level AND levels.id_product = products.id_product  AND products.id_product = ".$data['id_product']." AND (products.available = 'ALL' OR products.available = 'FAMILY')  ";
		
		if($data['M1'] == 1){
			
			$sql .= " AND (levels.name_level = 'M1' ";
			
			if($data['M2'] == 1){
				$sql .= " OR levels.name_level = 'M2' ";
				
				if($data['M3'] == 1){
					$sql .= " OR levels.name_level = 'M3') ";
				}else{
					$sql .= " ) ";
				}
			}else{
				if($data['M3'] == 1){
					$sql .= " OR levels.name_level = 'M3') ";
				}else{
					$sql .= " ) ";
				}
			}
		}else{
			if($data['M2'] == 1){
				$sql .= " AND (levels.name_level = 'M2' ";
				
				if($data['M3'] == 1){
					$sql .= " OR levels.name_level = 'M3') ";
				}else{
					$sql .= " ) ";
				}
				
			}else{
				if($data['M3'] == 1){
					$sql .= " AND levels.name_level = 'M3' ";
				}
			}
		}
		
		//$sql .= " AND products.currency = '".$data['currency']."' ";
		
		if($data['local'] == 1){
			$sql .= " AND products.local = 1 AND (products.location = '".$data['location']."' OR products.location = 'ALL') ";
		}
		
		//if($data['local'] == 0){
		//	$sql .= "  AND (products.location = '".$data['location']."' OR products.location = 'ALL' OR products.location = '') ";
		//}

		if($data['lifetime'] == 1){
			$sql .= " AND levels.lifetime_option = 'LT' ";
		}

		if($data['sex'] == 'M'){
			$sql .= " AND (levels.sex = 'ALL' OR levels.sex = 'M') ";
		}
		if($data['sex'] == 'F'){
			$sql .= " AND (levels.sex = 'ALL' OR levels.sex = 'F') ";
		}
		if($data['extended_area'] == 1){
			$sql .= " AND levels.zone = 'Z2' ";
		}
		if($data['marine'] == 0){
			$sql .= " AND levels.marine = 0 ";
		}
		
		$sql .= " GROUP BY levels.id_level ";
		
		$result = $this->mysqli->query($sql);
		$all = array();
		
		if($result->num_rows > 0){
			while($row = $result->fetch_assoc()){
				$all[] = $row;
			}
		}
		return $all;
		
	}
	
	public function getProductSearchByLevelAge($id,$age){
		$all = array();
		foreach($age as $a){
			$sql = "SELECT * FROM premium WHERE id_level = ".$id." AND age = ".$a." ";
			$result = $this->mysqli->query($sql);
			$row = $result->fetch_assoc();
			$all[] = $row;
		}
		
		return $all;
	}
	
	
	public function getProductDetailsByAgeByProductId($all,$id){
		$sql = "SELECT * FROM products,levels,premium WHERE premium.age = ".$age." AND premium.id_level = levels.id_level AND levels.id_product = products.id_product AND products.id_product = ".$id." ";
		$result = $this->mysqli->query($sql);
		$all = array();
		
		if($result->num_rows > 0){
			while($row = $result->fetch_assoc()){
				$all[] = $row;
			}
		}
		return $all;
	}
	
	public function getPremiumByAgeLevel($age,$id){
		$sql = "SELECT * FROM premium WHERE id_level = ".$id." AND age=".$age." ORDER BY id_level ASC";
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