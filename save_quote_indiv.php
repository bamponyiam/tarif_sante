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
$data['company'] = $_POST['company_indiv'];
$data['address'] = $_POST['address_indiv'];
$data['tel'] = $_POST['phone_indiv'];
$data['email'] = $_POST['email_indiv'];
$data['country'] = $_POST['country_indiv'];
$data['id_user'] = $_SESSION['login'];

if($_POST['profession_indiv'] == ""){
	if($_POST['marine_indiv'] == 1){
		$data['profession'] = "Employé du secteur maritime";
	}else{
		$data['profession'] = $_POST['profession_indiv'];
	}
}else{
	$data['profession'] = $_POST['profession_indiv'];
}

$id_quote = $quotation->insertQuotation($data);

$app = array();

$app['date_of_birth'] = $_POST['dob_indiv'];

$app['sex'] = $_POST['sex_indiv'];
if($_POST['age_indiv'] != ""){
	$app['age'] = $_POST['age_indiv'];
}else{
	$app['age'] = 0;
}

$app['type_applicant'] = "INDIV";
$app['marine'] = $_POST['marine_indiv'];
$app['firstname'] = $_POST['firstname_indiv'];
$app['lastname'] = $_POST['lastname_indiv'];
$app['nationality'] = $_POST['nationality_indiv'];
$app['id_quote'] = $id_quote;

$applicant->insertApplicant($app);

$premium = array();

	
foreach($_POST['selected_indiv'] as $p){
	
	$price = $product->getPremiumById($p);
	$fee = $product->getLevelById($price['id_level']);
	$pro = $product->getProductById($fee['id_product']);
	
	$rate = 1;
	if($pro['currency'] != $_POST['currency']){
		$curr = $currency->getCurrenyById($pro['currency']);
		$rate = $curr['rate'];
	}
	
	$premium['id_level'] = $price['id_level'];
	$premium['id_premium'] = $p;
	$premium['id_quote'] = $id_quote;
	$premium['1st_adult'] = floor($price['price']*$rate);
	$premium['2nd_adult'] = 0;
	$premium['1_children'] = 0;
	$premium['2_children'] = 0;
	$premium['3_children'] = 0;
	$premium['4_children'] = 0;
	$premium['discount'] = 0;
	$premium['family_pack'] = 0;
	$premium['children_pack'] = 0;
	$premium['adh_cie_fee'] = floor($fee['adh_fee']*$rate);
	$premium['ass_cie_indiv'] = floor($fee['assis_indiv']*$rate);
	$premium['adh_poema_fee'] = 0;
	$premium['ass_cie_family'] = 0;
	$premium['ass_poema'] = 0;
	
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