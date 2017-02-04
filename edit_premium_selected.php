<?php
require_once("classes/Quotation.php");
$quotation = Quotation::getInstance();

$data = array();

$data['adh_cie_fee'] = $_POST['adh_cie_fee_'.$_GET['id'].''];
$data['adh_poema_fee'] = $_POST['adh_poema_fee_'.$_GET['id'].''];

if($_POST['type_con'] == 'INDIV'){
	$data['ass_cie_indiv'] = $_POST['ass_cie_'.$_GET['id'].''];
	$data['ass_cie_family'] = 0;
	$data['1st_adult'] = $_POST['price_premium_'.$_GET['id'].''];
	$data['2nd_adult'] = 0;
	$data['1_children'] = 0;
	$data['2_children'] = 0;
	$data['3_children'] = 0;
	$data['4_children'] = 0;
	$data['family_pack'] = 0;
	$data['children_pack'] = 0;
	
}else{
	$data['ass_cie_family'] = $_POST['ass_cie_'.$_GET['id'].''];
	$data['ass_cie_indiv'] = 0;
	
	if(isset($_POST['family_pack_'.$_GET['id'].''])){
		$data['family_pack'] = $_POST['family_pack_'.$_GET['id'].''];
		$data['1st_adult'] = 0;
		$data['2nd_adult'] = 0;
		$data['1_children'] = 0;
		$data['2_children'] = 0;
		$data['3_children'] = 0;
		$data['4_children'] = 0;
		$data['children_pack'] = 0;
	}else{
		$data['family_pack'] = 0;
		$data['1st_adult'] = $_POST['1st_adult_'.$_GET['id'].''];
		if(isset($_POST['2nd_adult_'.$_GET['id'].''])){
			$data['2nd_adult'] = $_POST['2nd_adult_'.$_GET['id'].''];
		}else{
			$data['2nd_adult'] = 0;
		}
		if(isset($_POST['children_pack_'.$_GET['id'].''])){
			$data['children_pack'] = $_POST['children_pack_'.$_GET['id'].''];
			
			if(isset($_POST['1_children_'.$_GET['id'].''])){
				$data['1_children'] = $_POST['1_children_'.$_GET['id'].''];
			}else{
				$data['1_children'] = 0;
			}
			if(isset($_POST['2_children_'.$_GET['id'].''])){
				$data['2_children'] = $_POST['2_children_'.$_GET['id'].''];
			}else{
				$data['2_children'] = 0;
			}
			
			if(isset($_POST['3_children_'.$_GET['id'].''])){
				$data['3_children'] = $_POST['3_children_'.$_GET['id'].''];
			}else{
				$data['3_children'] = 0;
			}
			
			if(isset($_POST['4_children_'.$_GET['id'].''])){
				$data['4_children'] = $_POST['4_children_'.$_GET['id'].''];
			}else{
				$data['4_children'] = 0;
			}
		}else{
			$data['children_pack'] = 0;
			if(isset($_POST['1_children_'.$_GET['id'].''])){
				$data['1_children'] = $_POST['1_children_'.$_GET['id'].''];
			}else{
				$data['1_children'] = 0;
			}
			if(isset($_POST['2_children_'.$_GET['id'].''])){
				$data['2_children'] = $_POST['2_children_'.$_GET['id'].''];
			}else{
				$data['2_children'] = 0;
			}
			
			if(isset($_POST['3_children_'.$_GET['id'].''])){
				$data['3_children'] = $_POST['3_children_'.$_GET['id'].''];
			}else{
				$data['3_children'] = 0;
			}
			
			if(isset($_POST['4_children_'.$_GET['id'].''])){
				$data['4_children'] = $_POST['4_children_'.$_GET['id'].''];
			}else{
				$data['4_children'] = 0;
			}
		}
	}
}
$data['ass_poema'] = $_POST['ass_poema_'.$_GET['id'].''];
$data['id_premium_selected'] = $_GET['id'];

$quotation->updateSelectedPremium($data);
$quotation->deleteAdditionalField($_GET['id']);

if($_POST['title_field_1'] != "" && $_POST['field_1'] != ""){
	
	$data_field_1 = array();
	$data_field_1['name_field'] 			= $_POST['title_field_1'];
	$data_field_1['value_field'] 			= $_POST['field_1'];
	$data_field_1['id_premium_selected'] 	= $_GET['id'];
	
	$quotation->insertAdditionalField($data_field_1);
}
if($_POST['title_field_2'] != "" && $_POST['field_2'] != ""){
	
	$data_field_2 = array();
	$data_field_2['name_field'] 			= $_POST['title_field_2'];
	$data_field_2['value_field'] 			= $_POST['field_2'];
	$data_field_2['id_premium_selected'] 	= $_GET['id'];
	
	$quotation->insertAdditionalField($data_field_2);
}

header("Location:view-quote?id=".$_GET['quote']);

?>