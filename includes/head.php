<!DOCTYPE html>
<html>
<head>
	<title>The Wooden Pipe Store</title>
	<meta charset="utf-8" />
	<meta name = "viewport" content = "width = device-width, initial-scale = 0.4, user-scalable = yes">
	<link rel="stylesheet" href="css/foundation.css">
  	<link rel="stylesheet" href="css/app.css">
	<link rel="stylesheet" href="assets/font-awesome-4.2.0/css/font-awesome.min.css">
	<link rel="stylesheet" type="text/css" href="DataTables-1.10.4/media/css/jquery.dataTables.css">
	
  	<script src="js/vendor/modernizr.js"></script>
  	<script src="js/vendor/jquery.js"></script>
  	<script type="text/javascript" charset="utf8" src="DataTables-1.10.4/media/js/jquery.dataTables.min.js"></script>
  	
</head>
<body>
	<header>
		<nav class="top-bar" data-topbar role="navigation">
			<ul class="title-area">
				<li class="name">
					<h1><a href="index.php">The Wooden Pipe Store</a></h1>
				</li>
			</ul>
			<section class="top-bar-section">
				<ul class="left">
					<li><a href="produits.php">The Shop</a></li>
					<li><a href="cv.php">The Team</a></li>
					<li><a href="contact.php">Contact Us</a></li>
				</ul>
				<ul class="right">
					<li class="nav-item"><a href="basket.php" class="basket-display"><?php if(count(session::get('basket')) >= 1) echo count(session::get('basket')) ." item(s) <i class='fa fa-shopping-cart'></i>"; ?></a></li>
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
					<li><a href="login.php">Login & Register</a></li>
					<?php
					}
					?>
				</ul>
			</section>
		</nav>
	</header>