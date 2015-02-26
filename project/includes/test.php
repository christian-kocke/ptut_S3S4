<?php
include_once('../core/init.php');
$user = new user();
$db = db::getInstance(); 
$u = "username";
$n = "grossesalope";
$i = 33;
try{
	$db->update("users", 34, array("user_group" => 2));
}catch(Exception $e){
	echo $e->getMessage();
}