<?php

require_once("classes/Quotation.php");
$quotation = Quotation::getInstance();

require_once("classes/Applicant.php");
$applicant = Applicant::getInstance();

$data = array();
$data_quote = array();

$data['id_applicant'] = $_POST['id_applicant'];
$data['firstname'] = $_POST['firstname'];
$data['lastname'] = $_POST['lastname'];
$data['nationality'] = $_POST['nationality'];

$applicant->updateApplicant($data);

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