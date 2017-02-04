<?php 

	require_once("classes/Quotation.php");
	$quotation = Quotation::getInstance();

	require_once("classes/Applicant.php");
	$applicant = Applicant::getInstance();

	$quotation->deleteSelectedPremiumByQuote($_GET['id']);
	$quotation->deleteSearchByQuote($_GET['id']);
	$applicant->deleteApplicantsByQuote($_GET['id']);
	$quotation->deleteQuote($_GET['id']);

	header("Location:quotes?msg=delete-success");

?>