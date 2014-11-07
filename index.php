<!DOCTYPE html>
<html id="top">
	<head>
		<meta charset="utf-8">
		<link rel="stylesheet" type="text/css" href="assets/style.css">
		<link rel="icon" href="assets/images/favicon.ico" />
		<title>Le Restaurant</title>
	</head>
	<body>
		<header>
			<div class="container">
				<img src="assets/images/fork.png" alt="icone">
				<h1>Le Restaurant</h1>
				<ul>
					<li>S'inscrire</li>
					<li>Se connecter
						<div class="hoverLogin">
							<form method="post">
								<fieldset>
									<p>Identifiant <br><input type="text" name="login" id="login"> <br></p>
									<p>Mot de passe <br><input type="text" name="password" id="password"><br></p>
									<p><input type="submit"value="Connexion"></p>
								</fieldset>
							</form>
						</div> 
					</li>
				</ul>
			</div>
			
		</header>
		
		<div class="background">
			
			<h2>Bienvenue sur
			<em>Le Restaurant</em></h2>
			<div class="arrowContainer">
				<a href="#suite">
					<img src="assets/images/down.png" alt="downarrow">
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
			    $bdd = new PDO('mysql:host=localhost;dbname=bd_menu', 'root', 'root');
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
			<script type="text/javascript">  
				$(document).ready(function(){ // smooth scroll function
					$('a[href^="#"]').on('click',function (e) {
						e.preventDefault();
						
						var target = this.hash,
						$target = $(target);
						
						$('html, body').stop().animate({
							'scrollTop': $target.offset().top
							}, 900, 'swing', function () {
							window.location.hash = target;
						});
					});
				});  
				
			</script>	
		</body>
	</html>	
	
