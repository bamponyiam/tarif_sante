<?php

require_once("classes/Product.php");
$product = Product::getInstance();

$data['name_plan'] = $_POST['name_plan'];
$data['name_level'] = $_POST['name_level'];
$data['sex'] = $_POST['sex'];
$data['zone'] = $_POST['zone'];
$data['lifetime_option'] = $_POST['lifetime_option'];
$data['marine'] = $_POST['marine'];
$data['deductible'] = $_POST['deductible'];

$data['assistance_detail'] = $_POST['assistance_detail'];
$data['room_rate'] = $_POST['room_rate'];
$data['consultation'] = $_POST['consultation'];
$data['public_liability'] = $_POST['public_liability'];
$data['transfer_fee'] = $_POST['transfer_fee'];

if($_POST['garanty'] != ""){
	$data['garanty'] = $_POST['garanty'];
}else{
	$data['garanty'] = 0;
}



if(isset($_POST['family_option'])){
	$data['family'] = 1;
	$data['minimum_nb_family'] = $_POST['minimum_nb_family'];
	$data['price_family'] = $_POST['family_price'];
}else{
	$data['family'] = 0;
	$data['minimum_nb_family'] = 0;
	$data['price_family'] = 0;
}

if(isset($_POST['children'])){
	$data['children'] = $_POST['children'];
	$data['1_children'] = $_POST['1_children'];
	$data['2_children'] = $_POST['2_children'];
	$data['3_children'] = $_POST['3_children'];
	$data['4_children'] = $_POST['4_children'];
	$data['5_children'] = $_POST['5_children'];
	$data['6_children'] = $_POST['6_children'];
}else{
	$data['children'] = 0;
	$data['1_children'] = 0;
	$data['2_children'] = 0;
	$data['3_children'] = 0;
	$data['4_children'] = 0;
	$data['5_children'] = 0;
	$data['6_children'] = 0;
}

$data['assis_indiv'] 	= $_POST['assis_indiv'];
$data['assis_family'] 	= $_POST['assis_family'];
$data['adh_fee'] 		= $_POST['adh_fee'];
$data['note_fr'] 		= nl2br($_POST['note_fr']);
$data['note_en'] 		= nl2br($_POST['note_en']);
$data['id_product'] = $_POST['id_product'];

$id_level = $product->insertPlanLevel($data);


for($i=0;$i<=83;$i++){
	
	if($_POST['premium_'.$i] != ""){
		$data_p = array();
		$data_p['id_level'] = $id_level;
		$data_p['age'] = $i;
		$data_p['price'] = $_POST['premium_'.$i];
		
		$product->insertPremium($data_p);
		unset($data_p);
	}
	
}

header("Location:product-details?id=".$_POST['id_product']);


?>