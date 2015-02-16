<!DOCTYPE html>
<html id="top">
<head>
	<meta charset="utf-8">
	<meta name = "viewport" content = "width = device-width, initial-scale = 0.4, user-scalable = yes">
	


	<link rel="stylesheet" href="css/foundation-datepicker.css">
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
	<script type="text/javascript" charset="utf8" src="js/foundation-datepicker.js"></script>
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
							<a href="#"><?php echo $user->data()->firstname ?> <i class="fa fa-user"></i></a>
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
							<form action="" method="post" >
								<!-- Login form -->
								<div class="row">	
									
										<div class="row collapse prefix-radius">
												<div class="small-2 columns">
													<span class="prefix"><i class="fa fa-user"></i></span>
												</div>
												<div class="small-10 columns">
													<input type="text" name="login_username" placeholder="Login" />
												</div>
											
									</div>
							
							</div>
								<div class="row">
									
										<div class="row collapse prefix-radius">
												<div class="small-2 columns">
													<span class="prefix"><i class="fa fa-lock"></i></span>
												</div>
												<div class="small-10 columns">
													<input type="password" name="login_password" placeholder="Password" />
												</div>
											</div>
										
									
								
										<input type="checkbox" name="remember" id="remember">
										<label for="remember">Rester connecté</label>
									
									<div class="large-12 columns center">
										<input type="hidden" name="token_login" value="<?php echo $token ?>"/>
										<button class="button"> Connexion </button>
									</div>
								</div>
							</form>
						</ul>
						<li><a href="#" data-reveal-id="myModal">S'inscrire</a></li>

						<div id="myModal" class="reveal-modal" data-reveal>
							<h2 class="subheader text-center">Inscription</h2>
							<div class="row">
								<form action="" method="post" data-abide>
									<!-- Last & First name -->
									<div class="row">
										<div class="large-6 columns">
											<input type="text" name="lastname" placeholder="Nom" required pattern="alpha"/>
											<small class="error">Uniquement des lettres minuscules/majuscules.</small>
										</div>
										<div class="large-6 columns">
											<input type="text" name="firstname" placeholder="Prénom" required pattern="alpha"/>
											<small class="error">Uniquement des lettres minuscules/majuscules.</small>
										</div>
									</div>
									<!-- Login & Email -->
									<div class="row">
										<div class="large-6 columns">
											<div class="row collapse prefix-radius">
												<div class="small-2 columns">
													<span class="prefix"><i class="fa fa-user"></i></span>
												</div>
												<div class="small-10 columns">
													<input type="text" name="username" placeholder="Pseudo" required pattern="alpha_numeric"/>
													<small class="error">Uniquement des lettres minuscules/majuscules ou des chiffres (6 caractères min).</small>
												</div>
											</div>
										</div>
										<div class="large-6 columns">
											<div class="row collapse prefix-radius">
												<div class="small-2 columns">
													<span class="prefix"><i class="fa fa-envelope-o"></i></span>
												</div>
												<div class="small-10 columns email-field">
													<input type="email" name="email" placeholder="Email" required pattern="email"/>
													<small class="error">Votre email doit être de la forme: exemple@exemple.com</small>
												</div>
											</div>
										</div>
									</div>
									<!-- Date Of Birth & Phone -->
									<div class="row">
										<div class="large-6 columns">
											<div class="row collapse prefix-radius">
												<div class="small-2 columns">
													<span class="prefix"><i class="fa fa-calendar"></i></span>
												</div>
												<div class="small-10 columns">
													<input class="fdatepicker" name="dob" data-date-format="dd/mm/yyyy" type="text" placeholder="Date de naissance" required />
												</div>
											</div>
										</div>
										<div class="large-6 columns">
											<div class="row collapse prefix-radius">
												<div class="small-2 columns">
													<span class="prefix"><i class="fa fa-mobile fa-lg"></i></span>
												</div>
												<div class="small-10 columns">
													<input type="text" name="phone" placeholder="Téléphone" required />
												</div>
											</div>
										</div>
									</div>
									<!-- Password & Confirmation -->
									<div class="row">
										<div class="large-6 columns">
											<div class="row collapse prefix-radius">
												<div class="small-2 columns">
													<span class="prefix"><i class="fa fa-lock"></i></span>
												</div>
												<div class="small-10 columns">
													<input type="password" name="password" placeholder="Mot de passe" required />
												</div>
											</div>
										</div>
										<div class="large-6 columns">
											<div class="row collapse prefix-radius">
												<div class="small-2 columns">
													<span class="prefix"><i class="fa fa-check"></i></span>
												</div>
												<div class="small-10 columns">
													<input type="password" name="password2" placeholder="Confirmation" required />
												</div>
											</div>
										</div>
									</div>	
									<div class="row">
										<div class="large-12 columns text-center">
											<input type="hidden" name="token_register" value="<?php echo $token ?>"/>
											<button class="button radius">Valider</button>
										</div>
									</div>
								</form>
							</div> <!-- End of Row -->
							<a class="close-reveal-modal">&#215;</a>
						</div>
						<?php
					}
					?>
				</ul>
			</section>
		</nav>
	</header>
		<div class="off-canvas-wrap" data-offcanvas>
			<div class="inner-wrap">
				<nav class="tab-bar">
					<section class="left tab-bar-section">
						<h1 class="title">Le restaurant</h1>
					</section>

					<section class="right-small">
						<a class="right-off-canvas-toggle menu-icon" href="#"><span></span></a>
					</section>
				</nav>		    
				<aside class="right-off-canvas-menu">
					<ul class="off-canvas-list">
						<li><label>Foundation</label></li>
						<li><a href="#">The Traders</a></li>
						<li><a href="#">The Merchant Princes</a></li>
					</ul>
				</aside>
				<section class="main-section">
      			<!-- content goes here -->
	    