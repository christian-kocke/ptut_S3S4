<?php
include_once "../core/init.php";
$user = new user();
include_once "head.php";
?>
		
		<div class="background">
			
			<h2>Bienvenue sur
			<em>Le Restaurant</em></h2>
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
			try
			{
			   $bdd = new PDO('mysql:host=iutdoua-webetu.univ-lyon1.fr;dbname=p1300909', 'p1300909', '188035');
			}
			catch (Exception $e)
			{
			        die('Erreur : ' . $e->getMessage());
			}


			$reponse = $bdd->query('SELECT nom, ingredient, prix, disponible FROM entree ');
		
			echo '<h2>Entrée</h2>';
			while ($donnees = $reponse->fetch())
			{
				if($donnees['disponible']==1) {
				echo '<strong>' .  $donnees['nom'] . '</strong>' . '<br />' .  '<h4>' . $donnees['ingredient'] . '</h4>'  . '<h3>' . $donnees['prix']  . ' €' . '</h3>' . '<br/> <br/>*' . '<br /> <br />';
				}
			}

			$reponse->closeCursor();



			$reponse = $bdd->query('SELECT nom, ingredient, prix, disponible FROM plat ');

			echo '<h2>Plat</h2>';
			while ($donnees = $reponse->fetch())
			{
				if($donnees['disponible']==1) {
				echo '<strong>' . $donnees['nom'] . '</strong> '. '<br />' . '<h4>' . $donnees['ingredient'] . '</h4>'  . '<h3>' . $donnees['prix'] . ' €' . '</h3>' . '<br/> <br/>*' . '<br /> <br />';
				}
			}

			$reponse->closeCursor();

			

			$reponse = $bdd->query('SELECT nom, ingredient, prix, disponible FROM dessert ');

			echo '<h2>Dessert</h2>';
			while ($donnees = $reponse->fetch())
			{
				if($donnees['disponible']==1) {
				echo '<strong>' . $donnees['nom'] . '</strong>' . '<br />' . '<h4>' .  $donnees['ingredient'] . '</h4>'  . '<h3>' . $donnees['prix'] . ' €' . '</h3>' . '<br/> <br/>*'. '<br /> <br />';
				}
			}	

			$reponse->closeCursor();
			
		?>
	</div>

					
		
		
		<footer>
			<div>©Le Restaurant 2014</div>
			<div>Back to <a href="#top">top</div>
		</footer>
			
			<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
			<script>window.jQuery || document.write('<script src="/js/libs/jquery.min.js"><\/script>')</script>  
		</body>
	</html>	
	