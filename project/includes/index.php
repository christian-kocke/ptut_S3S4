<?php
include_once "../core/init.php";
$user = new user();
include_once "head.php";
$db = db::getInstance();
$bdd = $db->getPDO();
?>
		
		<div class="background">
			<div class="row">
				<div class="column large-12 large-centered text-center t1">Bienvenue sur</div> 
				<div class="column large-12 large-centered text-center t2">Le Restaurant</div>
			</div>
			<div class="arrowContainer">
				<a href="#suite">
					<img src="assets/img/down.png" alt="downarrow">
				</a>
			</div>
		</div>
		<div id="suite">
		</div>
		
		<div class="menu">
		
			<h1>Le Menu</h1>
			
			<?php
		


			$reponse = $bdd->query('SELECT nom, ingredient, prix, disponible FROM entree ');
		
			echo '<h2>Entrée</h2></br>';
			while ($donnees = $reponse->fetch())
			{
				if($donnees['disponible']==1) {
				echo '<strong>' .  $donnees['nom'] . '</strong>' . '<br />' . $donnees['ingredient']   . '<h4>' . $donnees['prix']  . ' €' . '</h4>' . '<br/>*' . '<br /> <br />';
				}
			}

			$reponse->closeCursor();



			$reponse = $bdd->query('SELECT nom, ingredient, prix, disponible FROM plat ');

			echo '<h2>Plat</h2></br>';
			while ($donnees = $reponse->fetch())
			{
				if($donnees['disponible']==1) {
				echo '<strong>' . $donnees['nom'] . '</strong> '. '<br />'  . $donnees['ingredient']  . '<h4>' . $donnees['prix'] . ' €' . '</h4>' . '<br/>*' . '<br /> <br />';
				}
			}

			$reponse->closeCursor();

			

			$reponse = $bdd->query('SELECT nom, ingredient, prix, disponible FROM dessert ');

			echo '<h2>Dessert</h2></br>';
			while ($donnees = $reponse->fetch())
			{
				if($donnees['disponible']==1) {
				echo '<strong>' . $donnees['nom'] . '</strong>' . '<br />'  .  $donnees['ingredient']   . '<h4>' . $donnees['prix'] . ' €' . '</h4>' . '<br/>*'. '<br /> <br />';
				}
			}	

			$reponse->closeCursor();
			
		?>
	</div>
<?php
include_once 'footer.php';
?>
	
