<?php 

require_once("classes/Product.php");
$product = Product::getInstance();

$data = array();

$data['name_product'] = $_POST['name_product'];
$data['id_product'] = $_POST['id_product'];
$data['currency'] = $_POST['currency'];
$data['available'] = $_POST['available'];
$data['marine'] = $_POST['marine'];
$data['type_age_caculaion'] = $_POST['type_age_cal'];

if(isset($_POST['local'])){
	$data['local'] = 1;
	$data['location'] = $_POST['location'];
}else{
	$data['local'] = 0;
	$data['location'] = "";
}

if(isset($_POST['discount'])){
	$data['discount'] = 1;
	$data['discount_percent'] = $_POST['discount_percent'];
	$data['minimum_nb_contract'] = $_POST['minimum_nb_contract'];
}else{
	$data['discount'] = 0;
	$data['discount_percent'] = 0;
	$data['minimum_nb_contract'] = 0;
}

if(isset($_POST['country_available'])){
	$product->deleteCountryAvailableByProduct($_POST['id_product']);
	foreach($_POST['country_available'] as $av){
		$data = array();
		$data['id_product'] = $_POST['id_product'];
		$data['country'] = $av;
		$product->insertCountryAvailable($data);
		unset($data);
	}
}

if(isset($_POST['lifetime_lt'])){
	$data['LT'] = 1;
	
}else{
	$data['LT'] = 0;
}

if(isset($_POST['lifetime_nlt'])){
	$data['NLT'] = 1;
	
}else{
	$data['NLT'] = 0;
}

if(isset($_POST['area_z1'])){
	$data['Z1'] = 1;
	
}else{
	$data['Z1'] = 0;
}

if(isset($_POST['area_z2'])){
	$data['Z2'] = 1;
	
}else{
	$data['Z2'] = 0;
}

$product->updateProduct($data);


header("Location:product-details?id=".$_POST['id_product']);


?>