<?php
session_start();
require_once("classes/User.php");
$user = User::getInstance();

$u = $user->getUserByLoginPass($_POST['user'],$_POST['password']);


if($u != 0){
	$_SESSION['login'] = $u['id_user'];
	$myLastLogin = date('Y-m-d H:i:s');
	$user->updateUserLastLogin($myLastLogin,$u['id_user']);
	header('Location:index');
}else{
	header('Location:login-page?error=1');
}



?>