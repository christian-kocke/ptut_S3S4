<?php
include_once('../core/init.php');
$user = new user();
$db = db::getInstance(); 
$sth = $db->getPDO()->prepare("SELECT * FROM users");
$sth->execute();
$rslt = $sth->fetchAll();