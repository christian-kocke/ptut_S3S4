<html>
	<head>
		<title>Gestion Menu</title>
	</head>
		<body>
		</body>
</html>


<?php


	try
	{
	    $bdd = new PDO('mysql:host=localhost;dbname=bd_menu', 'root', 'root');
	}
	catch (Exception $e)
	{
	        die('Erreur : ' . $e->getMessage());
	}

	


	$reponse = $bdd->query('SELECT nom, ingredient, prix, disponible FROM entree ');

	echo '<h2>Entrée : </h2>';
	while ($donnees = $reponse->fetch())
	{
		if($donnees['disponible']==1) {
		echo '<strong>' . $donnees['nom'] . '</strong>' . '<br />' . $donnees['ingredient']  .'<br/>' . $donnees['prix'] . '€' . '<br /> <br />';
		}
	}

	$reponse->closeCursor();



	$reponse = $bdd->query('SELECT nom, ingredient, prix, disponible FROM plat ');

	echo '<h2>Plat : </h2>';
	while ($donnees = $reponse->fetch())
	{
		if($donnees['disponible']==1) {
		echo '<strong>' . $donnees['nom'] . '</strong> '. '<br />' . $donnees['ingredient']  .'<br />' . $donnees['prix'] . '€' . '<br /> <br />';
		}
	}

	$reponse->closeCursor();

	

	$reponse = $bdd->query('SELECT nom, ingredient, prix, disponible FROM dessert ');

	echo '<h2>Dessert : </h2>';
	while ($donnees = $reponse->fetch())
	{
		if($donnees['disponible']==1) {
		echo '<strong>' . $donnees['nom'] . '</strong>' . '<br />' . $donnees['ingredient']  .'<br />' . $donnees['prix'] . '€' . '<br /> <br />';
		}
	}	

	$reponse->closeCursor();


	
	
?>
