<?php

require_once("classes/Quotation.php");
$quotation = Quotation::getInstance();

require_once("classes/Applicant.php");
$applicant = Applicant::getInstance();

$data = array();
$data_quote = array();

$data['id_applicant'] = $_POST['id_applicant_1st'];
$data['firstname'] = $_POST['firstname_1st'];
$data['lastname'] = $_POST['lastname_1st'];
$data['nationality'] = $_POST['nationality_1st'];
$applicant->updateApplicant($data);



if(isset($_POST['id_applicant_2nd'])){
	
	unset($data);$data = array();
	$data['id_applicant'] = $_POST['id_applicant_2nd'];
	$data['firstname'] = $_POST['firstname_2nd'];
	$data['lastname'] = $_POST['lastname_2nd'];
	$data['nationality'] = $_POST['nationality_2nd'];
	
	$applicant->updateApplicant($data);
}

if(isset($_POST['id_applicant_1_child'])){
	
	unset($data);$data = array();
	$data['id_applicant'] = $_POST['id_applicant_1_child'];
	$data['firstname'] = $_POST['firstname_1_child'];
	$data['lastname'] = $_POST['lastname_1_child'];
	$data['nationality'] = $_POST['nationality_1_child'];
	
	$applicant->updateApplicant($data);
}

if(isset($_POST['id_applicant_2_child'])){
	
	unset($data);$data = array();
	$data['id_applicant'] = $_POST['id_applicant_2_child'];
	$data['firstname'] = $_POST['firstname_2_child'];
	$data['lastname'] = $_POST['lastname_2_child'];
	$data['nationality'] = $_POST['nationality_2_child'];
	
	$applicant->updateApplicant($data);
}

if(isset($_POST['id_applicant_3_child'])){
	
	unset($data);$data = array();
	$data['id_applicant'] = $_POST['id_applicant_3_child'];
	$data['firstname'] = $_POST['firstname_3_child'];
	$data['lastname'] = $_POST['lastname_3_child'];
	$data['nationality'] = $_POST['nationality_3_child'];
	
	$applicant->updateApplicant($data);
}

if(isset($_POST['id_applicant_4_child'])){
	
	unset($data);$data = array();
	$data['id_applicant'] = $_POST['id_applicant_4_child'];
	$data['firstname'] = $_POST['firstname_4_child'];
	$data['lastname'] = $_POST['lastname_4_child'];
	$data['nationality'] = $_POST['nationality_4_child'];
	
	$applicant->updateApplicant($data);
}




$data_quote['company'] = $_POST['company'];
$data_quote['email'] = $_POST['email'];
$data_quote['address'] = $_POST['address'];
$data_quote['tel'] = $_POST['phone'];
$data_quote['country'] = $_POST['country'];
$data_quote['profession'] = $_POST['profession'];
$data_quote['id_quote'] = $_POST['id_quote'];

$quotation->updateQuotation($data_quote);

header("Location:view-quote?id=".$_POST['id_quote'])

?>