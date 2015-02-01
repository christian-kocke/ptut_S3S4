<?php
try {
	$handler = new PDO('mysql:host=iutdoua-webetu.univ-lyon1.fr;dbname=p1300909', 'p1300909', '188035');
	$handler->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
	echo $e->getMessage();
	die();
}