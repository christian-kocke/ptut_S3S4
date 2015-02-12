<?php
include_once "../core/init.php";
$user = new user();
include_once "head.php";
$db = db::getInstance();
$bdd = $db->getPDO();

	
	if(isset($_POST['maj'])) {
		if(isset($_POST['dispo'])){
		$bdd->exec("update entree set nom='$_POST[nom]', ingredient='$_POST[ingredient]', prix='$_POST[prix]', disponible='1' where nom='$_POST[hidden]'");
		
		}
		else {
		$bdd->exec("update entree set nom='$_POST[nom]', ingredient='$_POST[ingredient]', prix='$_POST[prix]', disponible='0' where nom='$_POST[hidden]'");
		}
	}


	if(isset($_POST['suprimer'])) {
		$bdd->exec("delete from entree where nom='$_POST[hidden]'");
	}

	if(isset($_POST['add1']) && ($_POST['addnom1']) && ($_POST['addingredient1']) && ($_POST['addprix1']) ) {
		$bdd->exec("insert into entree (nom, ingredient, prix, disponible) values ('$_POST[addnom1]', '$_POST[addingredient1]', '$_POST[addprix1]', 1) ");
	}

	


	$reponse = $bdd->query('SELECT nom, ingredient, prix, disponible FROM entree ');
	
	echo "<h1>Entrée</h1>";
	echo "<table>
	<tr>
	<th>Nom</th>
	<th>Ingredient</th>
	<th>Prix</th>
	</tr>";
	while ($record = $reponse->fetch()){
		
		if($record['disponible']==1){
			$checked='checked';
		}
		else {
			$checked='';
		}

		echo "<form action=cook.php method=post>";
		echo "<tr>";
		echo "<td>" . "<input type=text name=nom value='" . $record['nom']  . "' </td>";
		echo "<td>" . "<input type=text name=ingredient size = 50 value='" . $record['ingredient'] . "' </td>";
		echo "<td>" . "<input type=number name=prix value='" . $record['prix'] . "' </td>";
		echo "<td>" . "<input type=hidden name=hidden value='" . $record['nom'] ."' </td>";
		echo "<td>" . "Disponible :";
		echo "<td>" . "<input type=checkbox name=dispo $checked"  ." </td>";
		echo "<td>" . "<input type=submit name=maj value=Modifier" . " </td>";
		echo "<td>" . "<input type=submit name=suprimer value=X" . " </td>";
		echo "</tr>";
		echo "</form>";
	}

	$reponse->closeCursor();

	echo "<form action=cook.php method=post>";
	echo "<tr>";
	echo "<td><input type=text name=addnom1></td>";
	echo "<td><input type=text size=50 name=addingredient1></td>";
	echo "<td><input type=number name=addprix1></td>";
	echo "<td>" . "<input type=submit name=add1 value=Ajouter" . " </td>";
	echo "</form>";
	echo "</table>";
	echo "</br>";
	echo "</br>";





	if(isset($_POST['maj'])) {
		if(isset($_POST['dispo'])){
		$bdd->exec("update plat set nom='$_POST[nom]', ingredient='$_POST[ingredient]', prix='$_POST[prix]', disponible='1' where nom='$_POST[hidden]'");
		}
		else {
		$bdd->exec("update plat set nom='$_POST[nom]', ingredient='$_POST[ingredient]', prix='$_POST[prix]', disponible='0' where nom='$_POST[hidden]'");
		}
	}


	if(isset($_POST['suprimer'])) {
		$bdd->exec("delete from plat where nom='$_POST[hidden]'");
	}

	if(isset($_POST['add2']) && ($_POST['addnom2']) && ($_POST['addingredient2']) && ($_POST['addprix2'])) {
		$bdd->exec("insert into plat (nom, ingredient, prix, disponible) values ('$_POST[addnom2]', '$_POST[addingredient2]', '$_POST[addprix2]', 1) ");
	}




	$reponse = $bdd->query('SELECT nom, ingredient, prix, disponible FROM plat ');
	
	echo "<h1>Plat</h1>";
	echo "<table>
	<tr>
	<th>Nom</th>
	<th>Ingredient</th>
	<th>Prix</th>
	</tr>";
	while ($record = $reponse->fetch()){

		if($record['disponible']==1){
			$checked='checked';
		}
		else {
			$checked='';
		}

		echo "<form action=cook.php method=post>";
		echo "<tr>";
		echo "<td>" . "<input type=text name=nom value='" . $record['nom']  . "' </td>";
		echo "<td>" . "<input type=text name=ingredient size = 50 value='" . $record['ingredient'] . "' </td>";
		echo "<td>" . "<input type=number name=prix value='" . $record['prix'] . "' </td>";
		echo "<td>" . "<input type=hidden name=hidden value='" . $record['nom'] ."' </td>";
		echo "<td>" . "Disponible :";
		echo "<td>" . "<input type=checkbox name=dispo $checked"  ." </td>";
		echo "<td>" . "<input type=submit name=maj value=Modifier" . " </td>";
		echo "<td>" . "<input type=submit name=suprimer value=X" . " </td>";

		echo "</tr>";
		echo "</form>";
	}

	$reponse->closeCursor();

	echo "<form action=cook.php method=post>";
	echo "<tr>";
	echo "<td><input type=text name=addnom2></td>";
	echo "<td><input type=text size=50 name=addingredient2></td>";
	echo "<td><input type=number name=addprix2></td>";
	echo "<td>" . "<input type=submit name=add2 value=Ajouter" . " </td>";
	echo "</form>";
	echo "</table>";
	echo "</br>";
	echo "</br>";




	if(isset($_POST['maj'])) {
		if(isset($_POST['dispo'])){
		$bdd->exec("update dessert set nom='$_POST[nom]', ingredient='$_POST[ingredient]', prix='$_POST[prix]', disponible='1' where nom='$_POST[hidden]'");
		}
		else {
		$bdd->exec("update dessert set nom='$_POST[nom]', ingredient='$_POST[ingredient]', prix='$_POST[prix]', disponible='0' where nom='$_POST[hidden]'");
		}
	}


	if(isset($_POST['suprimer'])) {
		$bdd->exec("delete from dessert where nom='$_POST[hidden]'");
	}

	if(isset($_POST['add3']) && ($_POST['addnom3']) && ($_POST['addingredient3']) && ($_POST['addprix3'])) {
		$bdd->exec("insert into dessert (nom, ingredient, prix, disponible) values ('$_POST[addnom3]', '$_POST[addingredient3]', '$_POST[addprix3]', 1) ");
	}





	$reponse = $bdd->query('SELECT nom, ingredient, prix, disponible FROM dessert ');
	echo "<h1>Dessert</h1>";
	echo "<table>
	<tr>
	<th>Nom</th>
	<th>Ingredient</th>
	<th>Prix</th>
	</tr>";
	while ($record = $reponse->fetch()){

		if($record['disponible']==1){
			$checked='checked';
		}
		else {
			$checked='';
		}

		echo "<form action=cook.php method=post>";
		echo "<tr>";
		echo "<td>" . "<input type=text name=nom value='" . $record['nom']  . "' </td>";
		echo "<td>" . "<input type=text name=ingredient size = 50 value='" . $record['ingredient'] . "' </td>";
		echo "<td>" . "<input type=number name=prix value='" . $record['prix'] . "' </td>";
		echo "<td>" . "<input type=hidden name=hidden value='" . $record['nom'] ."' </td>";
		echo "<td>" . "Disponible :";
		echo "<td>" . "<input type=checkbox name=dispo $checked"  ." </td>";
		echo "<td>" . "<input type=submit name=maj value=Modifier" . " </td>";
		echo "<td>" . "<input type=submit name=suprimer value=X" . " </td>";
		echo "</tr>";
		echo "</form>";
	}

	$reponse->closeCursor();

	echo "<form action=cook.php method=post>";
	echo "<tr>";
	echo "<td><input type=text name=addnom3></td>";
	echo "<td><input type=text size=50 name=addingredient3></td>";
	echo "<td><input type=number name=addprix3></td>";
	echo "<td>" . "<input type=submit name=add3 value=Ajouter" . " </td>";
	echo "</form>";
	echo "</table>";
	echo "</br>";
	echo "</br>";

	?>

<?php
include_once 'footer.php';
?>
