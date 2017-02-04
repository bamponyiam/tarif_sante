<?php
require_once("classes/Currency.php");
$currency = Currency::getInstance();

$currency->updateCurrency($_POST['id'],$_POST['val']);
echo $_POST['val'];

?>