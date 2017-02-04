<?php

require_once("classes/User.php");
$user = User::getInstance();

$data = array();
$data['login'] = $_POST['username'];
$data['password'] = sha1($_POST['password']);
$data['firstname'] = $_POST['firstname'];
$data['lastname'] = $_POST['lastname'];
$data['email'] = $_POST['email'];
$data['office'] = $_POST['office'];
$data['last_login'] = date('Y-m-d H:i:s');

$user->insertUser($data);

header('Location:users');


?>