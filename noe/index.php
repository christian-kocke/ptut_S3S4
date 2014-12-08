<?php
	require_once("connect.php");

	extract($_POST);

	if (isset($submit)) {
		$sql = $handler->query("INSERT INTO reservation(`name`,`nbPerson`,`dateResa`,`schedule`) VALUES ('$name','$nbpeople','$dateResa','$schedule') ");
		echo "<script type='text/javascript'>document.location.replace('recap-resa.php');</script>";
	}
?><!doctype html> 
<html lang="fr">
	<head>
		<meta charset="utf-8" />
		<title> Le restaurant </title>
		<link rel="stylesheet" href="css/style.css" />
		<link rel="stylesheet" href="js/jquery-ui-1.11.2.custom/jquery-ui.css" />
		<link rel="stylesheet" href="js/jquery-ui-1.11.2.custom/jquery-ui.min.css" />
		<link rel="stylesheet" href="js/jquery-ui-1.11.2.custom/jquery-ui.structure.css" />
		<link rel="stylesheet" href="js/jquery-ui-1.11.2.custom/jquery-ui.structure.min.css" />
		<link rel="stylesheet" href="js/jquery-ui-1.11.2.custom/jquery-ui.theme.css" />
		<link rel="stylesheet" href="js/jquery-ui-1.11.2.custom/jquery-ui.theme.min.css" />
		<script src="//code.jquery.com/jquery-1.10.2.js"></script>
		<script src="//code.jquery.com/ui/1.11.2/jquery-ui.js"></script>
	</head>
	<body>

	<button id="popup_button" onclick="openPopup()">Réservez !</button>
	<div id="popup">
		<header>
			<div> Réservation </div>
		</header>
		<form action="index.php" method="post">
			<p><img src="images/customer.png" alt="Customer"/><input type="text" name="name" placeholder="Nom de la réservation" style="width:150px"></p>
			<p><img src="images/calendar.png" alt="Calendar"/><input type="text" name="dateResa" id="datepicker" placeholder="Date" style="width:150px"></p>
			<p><img src="images/schedule.png" alt="Schedule"/><select id="time" name="schedule" style="width:165px"></select></p>
			<p><img src="images/persons.png" alt="Persons"/><select name="nbpeople" style="width:165px">
				<option value="1" selected>1 Personne</option>
				<option value="2">2 Personnes</option>
				<option value="3">3 Personnes</option>
				<option value="4">4 Personnes</option>
				<option value="5">5 Personnes</option>
				<option value="6">6 Personnes</option>
				<option value="7">7 Personnes</option>
				<option value="8">8 Personnes</option>
				<option value="9">9 Personnes</option>
				<option value="10">10 Personnes</option>
				<option value="11">11 Personnes</option>
				<option value="12">12 Personnes</option>
				<option value="13">13 Personnes</option>
				<option value="14">14 Personnes</option>
				<option value="15">15 Personnes</option>
			</select></p>
			<p><img src="images/menu.png" alt="Menu"/><input type="text" name="menu" placeholder="Menu" style="width:150px"></p>
          	<footer><input type="submit" name="submit" value="Chercher une table"></footer>
        </form>
	</div>
	<script type="text/javascript" src="js/js.js"></script>
	</body>
</html>
<script>
  	$(function() {
    	$( "#datepicker" ).datepicker();
    	$( "#anim" ).change(function() {
    	 	$( "#datepicker" ).datepicker( "option", "bounce", $( this ).val() );
    	});
  	});
</script>
