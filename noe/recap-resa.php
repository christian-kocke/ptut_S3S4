<?php	
	require_once("connect.php");

	$errorMessage = "";
	extract($_POST);
	
	$query_save_tables = $handler->query("SELECT id FROM tables WHERE available = 1");
	$save_tables = $query_save_tables->fetch(PDO::FETCH_NUM);
	
	$save_nbpeople = $nbpeople;
	$temp = $nbpeople % 4;
	$nbpeople -= $temp;
	$temp += ($temp == 1) + ($temp == 3);

	$query = $handler->query("SELECT * FROM tables WHERE available = 1 AND seats = $temp");
	$count = $query->fetch(PDO::FETCH_NUM);
	
	if($count > 0) {
		$query = $handler->query("UPDATE tables SET available = 0 WHERE id = $count[0]");
	} else {
		$errorMessage = "Désolé ... nous n'avons plus de tables disponibles ! ";
		foreach ($save_tables as $value) {
			$query = $handler->query("UPDATE tables SET available = 1 WHERE id = $value");
		}
	}
	$cpt = $nbpeople / 4;

	for ($i = 0; $i < $cpt; $i++) {
		$query = $handler->query("SELECT * FROM tables WHERE available = 1 AND seats = 4");
		$count = $query->fetch(PDO::FETCH_NUM);
		if ($count > 0) {
    		$query = $handler->query("UPDATE tables SET available = 0 WHERE id = $count[0]");
		} else {
    		$errorMessage = "Désolé ... nous n'avons plus de tables disponibles ! ";
    		foreach ($save_tables as $value) {
				$query = $handler->query("UPDATE tables SET available = 1 WHERE id = $value");
			}
		}
	}
	$nbpeople = $save_nbpeople;
?><!doctype html> 
<html lang="fr">
	<head>
		<meta charset="utf-8" />
		<title> Le restaurant </title>
		<link rel="stylesheet" href="css/style.css" />
	</head>
	<body>
		<header>
			<div> Recapitulatif de la réservation </div>
		</header>
		<div id="recap_resa">
			<table> 
                <tr> 
                    <th> Nom </th> 
                    <th> Nombre de personnes </th> 
                    <th> Date </th>
                    <th> Horaire </th>
                    <th> Menu </th> 
                </tr> 
                <?php 
                	$sql = $handler->query("SELECT * FROM reservation");
                    while ($row = $sql->fetch(PDO::FETCH_NUM)) {
                ?> 
                <tr>
                    <td><?php echo $row[1];?></td> 
                    <td><?php echo $row[2];?></td>
                    <td><?php echo $row[3];?></td>
                    <td><?php echo $row[4];?></td>
                </tr> 
                <?php 
                    } 
                ?> 
            </table>
		</div>	
	</body>
</html>