<?php
require_once("classes/Product.php");
$product = Product::getInstance();

$data['name_product'] 		= $_POST['name_product'];

if(isset($_POST['local'])){$data['local'] = 1;$data['location'] = $_POST['location'];}else{$data['local'] = 0;$data['location']="";}
if(isset($_POST['discount'])){$data['discount'] = 1;}else{$data['discount'] = 0;}

if($_POST['discount_percent'] != ""){$data['discount_percent'] = $_POST['discount_percent'];}else{$data['discount_percent'] = 0;}
if($_POST['minimum_nb_contract'] != ""){$data['minimum_nb_contract'] = $_POST['minimum_nb_contract'];}else{$data['minimum_nb_contract'] = 0;}

$data['currency'] 				= $_POST['currency'];
$data['marine'] 				= $_POST['marine'];

if(isset($_POST['lifetime_lt'])){$data['LT'] = 1;}else{$data['LT'] = 0;}
if(isset($_POST['lifetime_nlt'])){$data['NLT'] = 1;}else{$data['NLT'] = 0;}

if(isset($_POST['area_z1'])){$data['Z1'] = 1;}else{$data['Z1'] = 0;}
if(isset($_POST['area_z2'])){$data['Z2'] = 1;}else{$data['Z2'] = 0;}

$data['type_age_caculaion'] 	= $_POST['type_age_cal'];
$data['available'] 	= $_POST['available'];

//print_r($data);

$product->insertProduct($data);
header("Location:product_list.php")


?>