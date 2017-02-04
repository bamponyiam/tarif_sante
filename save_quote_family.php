<?php 
session_start();
require_once("classes/Quotation.php");
$quotation = Quotation::getInstance();

require_once("classes/Applicant.php");
$applicant = Applicant::getInstance();

require_once("classes/Product.php");
$product = Product::getInstance();

require_once("classes/Currency.php");
$currency = Currency::getInstance();

$data = array();
$data['reference'] = $_POST['location'].''.date('Ymd');
$data['currency'] = $_POST['currency'];
$data['type_con'] = $_POST['type_con'];
$data['company'] = $_POST['company_family'];
$data['address'] = $_POST['address_family'];
$data['tel'] = $_POST['phone_family'];
$data['email'] = $_POST['email_family'];
$data['country'] = $_POST['country_family'];
$data['id_user'] = $_SESSION['login'];


if($_POST['profession_family'] == ""){
	if($_POST['marine_1st_family'] == 1){
		$data['profession'] = "Employé du secteur maritime";
	}else{
		$data['profession'] = $_POST['profession_family'];
	}
}else{
	$data['profession'] = $_POST['profession_family'];
}


$id_quote = $quotation->insertQuotation($data);

/* 1st insured adult */
$app_1st = array();
$app_1st['date_of_birth'] = $_POST['dob_1st_family'];

$app_1st['sex'] = $_POST['sex_1st_family'];
if($_POST['age_1st_family'] != ""){
	$app_1st['age'] = $_POST['age_1st_family'];
}else{
	$app_1st['age'] = 0;
}

$app_1st['type_applicant'] = "1ST";
$app_1st['marine'] = $_POST['marine_1st_family'];
$app_1st['firstname'] = $_POST['firstname_1st_family'];
$app_1st['lastname'] = $_POST['lastname_1st_family'];
$app_1st['nationality'] = $_POST['nationality_1st_family'];
$app_1st['id_quote'] = $id_quote;
$applicant->insertApplicant($app_1st);

/* 2nd insured adult if exist */
if(($_POST['dob_2nd_family'] != "") || $_POST['age_2nd_family'] != ""){
	
	$app_2nd = array();
	$app_2nd['date_of_birth'] = $_POST['dob_2nd_family'];

	$app_2nd['sex'] = $_POST['sex_2nd_family'];
	if($_POST['age_2nd_family'] != ""){
		$app_2nd['age'] = $_POST['age_2nd_family'];
	}else{
		$app_2nd['age'] = 0;
	}

	$app_2nd['type_applicant'] = "2ND";
	$app_2nd['marine'] = $_POST['marine_2nd_family'];
	$app_2nd['firstname'] = $_POST['firstname_2nd_family'];
	$app_2nd['lastname'] = $_POST['lastname_2nd_family'];
	$app_2nd['nationality'] = $_POST['nationality_2nd_family'];
	$app_2nd['id_quote'] = $id_quote;
	$applicant->insertApplicant($app_2nd);
	
}

/* 1 children insured if exist */
if(($_POST['dob_1_child_family'] != "") || $_POST['age_1_child_family'] != ""){
	
	$app_child_1 = array();
	$app_child_1['date_of_birth'] = $_POST['dob_1_child_family'];

	$app_child_1['sex'] = $_POST['sex_1_child_family'];
	if($_POST['age_1_child_family'] != ""){
		$app_child_1['age'] = $_POST['age_1_child_family'];
	}else{
		$app_child_1['age'] = 0;
	}

	$app_child_1['type_applicant'] = "1CHILD";
	$app_child_1['marine'] = 0;
	$app_child_1['firstname'] = $_POST['firstname_1_child_family'];
	$app_child_1['lastname'] = $_POST['lastname_1_child_family'];
	$app_child_1['nationality'] = $_POST['nationality_1_child_family'];
	$app_child_1['id_quote'] = $id_quote;
	$applicant->insertApplicant($app_child_1);
	
}

/* 2 children insured if exist */
if(($_POST['dob_2_child_family'] != "") || $_POST['age_2_child_family'] != ""){
	
	$app_child_2 = array();
	$app_child_2['date_of_birth'] = $_POST['dob_2_child_family'];

	$app_child_2['sex'] = $_POST['sex_2_child_family'];
	if($_POST['age_2_child_family'] != ""){
		$app_child_2['age'] = $_POST['age_2_child_family'];
	}else{
		$app_child_2['age'] = 0;
	}

	$app_child_2['type_applicant'] = "2CHILD";
	$app_child_2['marine'] = 0;
	$app_child_2['firstname'] = $_POST['firstname_2_child_family'];
	$app_child_2['lastname'] = $_POST['lastname_2_child_family'];
	$app_child_2['nationality'] = $_POST['nationality_2_child_family'];
	$app_child_2['id_quote'] = $id_quote;
	$applicant->insertApplicant($app_child_2);
	
}

/* 3 children insured if exist */
if(($_POST['dob_3_child_family'] != "") || $_POST['age_3_child_family'] != ""){
	
	$app_child_3 = array();
	$app_child_3['date_of_birth'] = $_POST['dob_3_child_family'];

	$app_child_3['sex'] = $_POST['sex_3_child_family'];
	if($_POST['age_3_child_family'] != ""){
		$app_child_3['age'] = $_POST['age_3_child_family'];
	}else{
		$app_child_3['age'] = 0;
	}

	$app_child_3['type_applicant'] = "3CHILD";
	$app_child_3['marine'] = 0;
	$app_child_3['firstname'] = $_POST['firstname_3_child_family'];
	$app_child_3['lastname'] = $_POST['lastname_3_child_family'];
	$app_child_3['nationality'] = $_POST['nationality_3_child_family'];
	$app_child_3['id_quote'] = $id_quote;
	$applicant->insertApplicant($app_child_3);
	
}

/* 4 children insured if exist */
if(($_POST['dob_4_child_family'] != "") || $_POST['age_4_child_family'] != ""){
	
	$app_child_4 = array();
	$app_child_4['date_of_birth'] = $_POST['dob_4_child_family'];

	$app_child_4['sex'] = $_POST['sex_4_child_family'];
	if($_POST['age_4_child_family'] != ""){
		$app_child_4['age'] = $_POST['age_4_child_family'];
	}else{
		$app_child_4['age'] = 0;
	}

	$app_child_4['type_applicant'] = "4CHILD";
	$app_child_4['marine'] = 0;
	$app_child_4['firstname'] = $_POST['firstname_4_child_family'];
	$app_child_4['lastname'] = $_POST['lastname_4_child_family'];
	$app_child_4['nationality'] = $_POST['nationality_4_child_family'];
	$app_child_4['id_quote'] = $id_quote;
	$applicant->insertApplicant($app_child_4);
	
}

$premium = array();

	
foreach($_POST['selected_permium'] as $p){
	
	$fee = $product->getLevelById($p);
	
	$pro = $product->getProductById($fee['id_product']);
	
	$rate = 1;
	if($pro['currency'] != $_POST['currency']){
		$curr = $currency->getCurrenyById($pro['currency']);
		$rate = $curr['rate'];
	}
	
	$premium['id_level'] = $p;
	$premium['id_premium'] = 0;
	$premium['id_quote'] = $id_quote;
	
	if(isset($_POST['family_pack_'.$p.''])){
		$premium['family_pack'] = floor($_POST['family_pack_'.$p.'']*$rate);
		$premium['1st_adult'] = 0;
		$premium['2nd_adult'] = 0;
		$premium['1_children'] = 0;
		$premium['2_children'] = 0;
		$premium['3_children'] = 0;
		$premium['4_children'] = 0;
		
	}else{
		$premium['family_pack'] = 0;
		$premium['1st_adult'] = floor($_POST['adult_1_'.$p.'']*$rate);
		if(isset($_POST['adult_2_'.$p.''])){
			$premium['2nd_adult'] = floor($_POST['adult_2_'.$p.'']*$rate);
		}else{
			$premium['2nd_adult'] = 0;
		}
	}
	
	if(isset($_POST['children_pack_'.$p.''])){
		$premium['children_pack'] = floor($_POST['children_pack_'.$p.'']*$rate);

		if(isset($_POST['children_1_'.$p.''])){
			$premium['1_children'] = floor($_POST['children_1_'.$p.'']*$rate);
		}else{
			$premium['1_children'] = 0;
		}
		if(isset($_POST['children_2_'.$p.''])){
			$premium['2_children'] = floor($_POST['children_2_'.$p.'']*$rate);
		}else{
			$premium['2_children'] = 0;
		}
		if(isset($_POST['children_3_'.$p.''])){
			$premium['3_children'] = floor($_POST['children_3_'.$p.'']*$rate);
		}else{
			$premium['3_children'] = 0;
		}
		if(isset($_POST['children_4_'.$p.''])){
			$premium['4_children'] = floor($_POST['children_4_'.$p.'']*$rate);
		}else{
			$premium['4_children'] = 0;
		}
		
	}else{
		$premium['children_pack'] = 0;
		
		if(isset($_POST['children_1_'.$p.''])){
			$premium['1_children'] = floor($_POST['children_1_'.$p.'']*$rate);
		}else{
			$premium['1_children'] = 0;
		}
		if(isset($_POST['children_2_'.$p.''])){
			$premium['2_children'] = floor($_POST['children_2_'.$p.'']*$rate);
		}else{
			$premium['2_children'] = 0;
		}
		if(isset($_POST['children_3_'.$p.''])){
			$premium['3_children'] = floor($_POST['children_3_'.$p.'']*$rate);
		}else{
			$premium['3_children'] = 0;
		}
		if(isset($_POST['children_4_'.$p.''])){
			$premium['4_children'] = floor($_POST['children_4_'.$p.'']*$rate);
		}else{
			$premium['4_children'] = 0;
		}
	}
	
		$premium['adh_cie_fee'] = floor($fee['adh_fee']*$rate);
		$premium['ass_cie_indiv'] = 0;
		$premium['adh_poema_fee'] = 0;
		$premium['ass_cie_family'] = floor($fee['assis_family']*$rate);
		$premium['ass_poema'] = 0;
	
	$premium['discount'] = $_POST['discount_'.$p.''];
	$quotation->insertSelectedPremium($premium);
}

$search = array();

$search['M1'] = $_POST['M1'];
$search['M2'] = $_POST['M2'];
$search['M3'] = $_POST['M3'];
$search['currency'] = $_POST['currency'];
$search['year_effective'] = $_POST['year_effective'];
$search['location'] = $_POST['location'];
$search['local'] = $_POST['local'];
$search['lifetime'] = $_POST['lifetime'];
$search['extended_area'] = $_POST['extended_area'];
$search['id_quote'] = $id_quote;

$quotation->insertSearch($search);

header("Location:view-quote?id=".$id_quote);



?>