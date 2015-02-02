<!DOCTYPE html>
<html id="top">
	<head>
		<meta charset="utf-8">
		<meta name = "viewport" content = "width = device-width, initial-scale = 0.4, user-scalable = yes">

		<!-- include foundation css -->
		<link rel="stylesheet" href="css/foundation.css">
		<!-- include costum css -->
	  	<link rel="stylesheet" href="css/app.css">
	  	<!-- include font awesome css -->
		<link rel="stylesheet" href="assets/font-awesome-4.2.0/css/font-awesome.min.css">
		<!-- include dataTables css -->
		<link rel="stylesheet" type="text/css" href="assets/DataTables-1.10.4/media/css/jquery.dataTables.css">
		<!-- include favicon -->
		<link rel="icon" href="assets/img/favicon.ico" />
		<!-- include modernizr.js -->
	  	<script src="js/vendor/modernizr.js"></script>
	  	<!-- include jquery -->
	  	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
		<script>window.jQuery || document.write('<script src="js/vendor/jquery.js"><\/script>')</script>  
		<!-- include dataTables js -->
	  	<script type="text/javascript" charset="utf8" src="assets/DataTables-1.10.4/media/js/jquery.dataTables.min.js"></script>

		<title>Le Restaurant</title>
	</head>
	<body>
		<header>
		<nav class="top-bar" data-topbar role="navigation">
			<ul class="title-area">
				<li class="name">
					<h1><a href="index.php">Le Restaurant</a></h1>
				</li>
			</ul>
			<section class="top-bar-section">
				<ul class="right">
					<?php
					if($user->isLoggedIn()){
					?>
					<li class="has-dropdown">
						<a href="#"><?php echo $user->data()->name ?> <i class="fa fa-user"></i></a>
						<ul class="dropdown">
							<li><a href="profile.php"><i class="fa fa-pencil"></i> Profil</a></li>
							<li><a href="logout.php"><i class="fa fa-power-off"></i> Logout</a></li>
						</ul>
					</li>
					<?php
					}else{
					?>
					<li>
						<a href="#" data-dropdown="login" data-options="is_hover:true;">Se connecter</a>
					</li>
					<ul id="login" class="content f-dropdown" data-dropdown-content>
						<form action="" method="post">
					  	<li>
					  	
					  		<input type="text" name="username" id="username" placeholder="Identifiant">
					  	</li>
					  	<li>
					  		<input type="password" placeholder="mot de passe">
					  	</li>
					  	<li>
					  		<button>Connexion</button>
					  	</li>
					  	</form>
					</ul>
					<li><a href="#">S'inscrire</a></li>
					
					<?php
					}
					?>
				</ul>
			</section>
		</nav>
	</header>