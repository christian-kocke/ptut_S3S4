<!DOCTYPE html>
<html id="top">
<head>
	<meta charset="utf-8">
	<meta name = "viewport" content = "width = device-width, initial-scale = 0.4, user-scalable = yes">
	<link rel="stylesheet" href="css/foundation-datepicker.css">
	<!-- INCLUDE FOUNDATION CSS -->
	<link rel="stylesheet" href="css/foundation.css">
	<!-- INCLUDE CUSTOM CSS -->
	<link rel="stylesheet" href="css/app.css">
	<!-- INCLUDE FONT AWESOME CSS -->
	<link rel="stylesheet" href="assets/font-awesome-4.2.0/css/font-awesome.min.css">
	<!-- INCLUDE DATATABLES CSS -->
	<link rel="stylesheet" type="text/css" href="assets/DataTables-1.10.4/media/css/jquery.dataTables.css">
	<!-- INCLUDE FAVICON -->
	<link rel="icon" href="assets/img/favicon.ico" />
	<!-- INCLUDE MODERNIZR.JS -->
	<script src="js/vendor/modernizr.js"></script>
	<!-- INCLUDE JQUERY -->
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
	<script>window.jQuery || document.write('<script src="js/vendor/jquery.js"><\/script>')</script>  
	<!-- INCLUDE DATATABLES JS -->
	<script type="text/javascript" charset="utf8" src="assets/DataTables-1.10.4/media/js/jquery.dataTables.min.js"></script>
	<script type="text/javascript" charset="utf8" src="js/foundation-datepicker.js"></script>
	<title>Le Restaurant</title>
</head>
<body>
	<header>
		<!-- NAVBAR -->
		<nav class="top-bar" data-topbar role="navigation">
			<ul class="title-area">
				<li class="name"><h1><a href="index.php"> Le Restaurant </a></h1></li>
			</ul><!-- class title-area -->
			<section class="top-bar-section">
				<ul class="right">
					<!-- ////////////////////////////////////////////  RESERVATION PART  ////////////////////////////////////////////////////////////////////// -->
					
					<!-- IF SOMEONE IS CONNECTED -->
					<?php
					if($user->isLoggedIn()){
						?>
						<li><a href="#" data-reveal-id="ResaModal"> Réservez </a></li>
						<?php
					} else {
						?>

						<li><a href="#" data-reveal-id="TypeResaModal"> Réservez </a></li>

						<!-- RESERVATION WITH A CLIENT ACCOUNT OR NOT ? (MODAL) -->
						<div id="TypeResaModal" class="reveal-modal medium" data-reveal>

							<!-- DIRECT RESERVATION -->
							<div class="row">
								<div class="small-12 columns">
									<div class="panel text-center">
										<h3 class="subheader"> Réservation directe </h3>
										<p> Réservez sans avoir de compte client si vous êtes pressé. </p>
										<button class="button radius" data-reveal-id="ResaModal"> Réservez </button>
									</div><!-- class panel -->
								</div><!-- class small-12 columns -->
							</div><!-- class row -->

							<div class="row" data-equalizer>

								<!-- CONNECTION BEFORE RESERVATION -->
								<div class="small-6 columns">
									<div class="panel text-center persoHeight" data-equalizer-watch>
										<h3 class="subheader"> Connexion </h3>
										<p> Connectez-vous et profitez des avantages clients (points fidelité). </p>
										<div class="row">
											<form action="" method="post" data-abide>

												<!-- LOGIN -->
												<div class="small-12 columns">
													<div class="row collapse prefix-radius">
														<div class="small-2 columns">
															<span class="prefix"><i class="fa fa-user"></i></span>
														</div><!-- class small-2 columns -->
														<div class="small-10 columns">
															<input type="text" name="login_username" placeholder="Login" />
														</div><!-- class small-10 columns -->
													</div><!-- class row collapse prefix-radius -->
												</div><!-- class small-12 columns -->

												<!-- PASSWORD -->
												<div class="small-12 columns">
													<div class="row collapse prefix-radius">
														<div class="small-2 columns">
															<span class="prefix"><i class="fa fa-lock"></i></span>
														</div><!-- class small-2 columns -->
														<div class="small-10 columns">
															<input type="password" name="login_password" placeholder="Password" />
														</div><!-- class small-10 columns -->
													</div><!-- class row collapse prefix-radius -->
													<input type="checkbox" name="remember" id="remember">
													<label for="remember"> Rester connecté </label>		
													<div class="large-12 columns center">
														<input type="hidden" name="token_login" value="<?php echo $token ?>"/>
														<button class="button"> Se connecter </button>
													</div><!-- class large-12 columns center -->
												</div><!-- class small-12 columns -->

											</form>
										</div><!-- class row for connectionForm -->
									</div><!-- class panel text-center -->
								</div><!-- class small-6 columns -->

								<!-- SUBSCRIBTION BEFORE RESERVATION -->
								<div class="small-6 columns">
									<div class="panel text-center persoHeight" data-equalizer-watch>
										<h3 class="subheader"> Inscription </h3>
										<p> Inscrivez-vous et cumulez des points de fidelités afin d'obtenir des réductions sur vos prochaines réservations. </p>
										<p> Vous aurez accès à un récapitulatif des anciennes réservations effectuées. </p>
										<button class="button radius" data-reveal-id="SubscribtionModal"> S'inscrire </button>
									</div><!-- class panel text-center -->
								</div><!-- class small-6 columns -->

							</div><!-- class row -->
							<a class="close-reveal-modal">&#215;</a>
						</div><!-- class reveal-modal of TypeResaModal -->

						<?php
					}
					?>

					<!-- RESERVATION MODAL -->
					<div id="ResaModal" class="reveal-modal small" data-reveal>
						<div class="row">
							<form id="ResaForm" action="" method="post" data-abide>
								<h2 class="subheader text-center"> Reservation </h2>

								<!-- RESERVATION NAME -->
								<div class="row">
									<div class="row collapse prefix-radius">
										<div class="small-2 columns">
											<span class="prefix"><i class="fa fa-user"></i></span>
										</div><!-- small-2 columns -->
										<div class="small-10 columns">
											<input type="text" name="customer_name" placeholder="Nom de la réservation" required pattern="alpha">
										</div><!-- class small-10 columns -->
									</div><!-- class row collapse prefix-radius -->
								</div><!-- class row -->

								<!-- RESERVATION DATE -->
								<div class="row">
									<div class="row collapse prefix-radius">
										<div class="small-2 columns">
											<span class="prefix"><i class="fa fa-calendar"></i></span>
										</div><!-- class small-2 columns -->
										<div class="small-10 columns">
											<input class="fdatepicker" name="dor" data-date-format="dd/mm/yyyy" type="text" placeholder="Date de la réservation" required />
										</div><!-- class small-10 columns -->
									</div><!-- class row collapse prefix-radius -->
								</div><!-- class row -->

								<!-- SCHEDULE -->
								<div class="row">
									<div class="row collapse prefix-radius">
										<div class="small-2 columns">
											<span class="prefix"><i class="fa fa-clock-o"></i></span>
										</div><!-- small-2 columns -->
										<div class="small-10 columns">
											<select id="time" name="schedule"></select>
										</div><!-- class small-10 columns -->
									</div><!-- class row collapse prefix-radius -->
								</div><!-- class row -->

								<!-- NB CUSTOMERS -->
								<div class="row">
									<div class="row collapse prefix-radius">
										<div class="small-2 columns">
											<span class="prefix"><i class="fa fa-users"></i></span>
										</div><!-- small-2 columns -->
										<div class="small-10 columns">
											<select name="nbpeople">
												<option value="1" selected> 1 Personne </option>
												<option value="2"> 2 Personnes </option>
												<option value="3"> 3 Personnes </option>
												<option value="4"> 4 Personnes </option>
												<option value="5"> 5 Personnes </option>
												<option value="6"> 6 Personnes </option>
												<option value="7"> 7 Personnes </option>
												<option value="8"> 8 Personnes </option>
												<option value="9"> 9 Personnes </option>
												<option value="10"> 10 Personnes </option>
												<option value="11"> 11 Personnes </option>
												<option value="12"> 12 Personnes </option>
												<option value="13"> 13 Personnes </option>
												<option value="14"> 14 Personnes </option>
												<option value="15"> 15 Personnes </option>
											</select>
										</div><!-- class small-10 columns -->
									</div><!-- class row collapse prefix-radius -->
								</div><!-- class row -->

								<!-- MENU -->
								<div class="row">
									<div class="row collapse prefix-radius">
										<div class="small-2 columns">
											<span class="prefix"><i class="fa fa-cutlery"></i></span>
										</div><!-- small-2 columns -->
										<div class="small-10 columns">
											<a href="#" id="MenuDisplay"><input type="text" placeholder="Cliquez ici ..."></a>
										</div><!-- class small-10 columns -->
									</div><!-- class row collapse prefix-radius -->
								</div><!-- class row -->

								<!-- SUBMIT -->
								<div class="row">
									<div class="large-12 columns text-center">
										<button class="button radius"> Chercher une table </button>
									</div><!-- class large-12 columns text-center -->
								</div><!-- class row -->
							</form>

							<!-- MODAL MENU -->
							<div id="MenuModal" class="text-center">
								<h2 class="subheader text-center"> Menu </h2>
								<div class="row">
									<div class="small-12 columns">
										<p> ICI LE MENU </p>
									</div><!-- class small-12 columns -->
									<div class="small-12 columns">
										<a href="#" id="MenuHide"><button class="button radius"> Valider </button></a>
									</div><!-- class small-12 columns -->
								</div><!-- class row -->
								<a class="close-reveal-modal">&#215;</a>
							</div><!-- MenuDisplay -->

						</div><!-- class row -->
						<a class="close-reveal-modal">&#215;</a>
					</div><!-- class reveal-modal of ResaModal -->

					<!-- ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////// -->

					<!-- ////////////////////////////////////////////  CONNECTION PART  ////////////////////////////////////////////////////////////////////// -->
					
					<!-- IF SOMEONE IS CONNECTED -->
					<?php
					if($user->isLoggedIn()){
						?>
						<li class="has-dropdown">
							<a href="#"><?php echo $user->data()->firstname ?> <i class="fa fa-user"></i></a>
							<ul class="dropdown">
								<?php
								if($user->hasPermission("admin")){
								?>
								<li><a href="control.php"><i class="fa fa-pencil"></i> Gestion utilisateurs</a></li>
								<?php
								}
								if($user->hasPermission("cook")){
								?>
								<li><a href="cook.php"><i class="fa fa-pencil"></i> gestion cuisine</a></li>
								<?php
								}
								if($user->hasPermission("receptionist")){
								?>
								<li><a href="profile.php"><i class="fa fa-pencil"></i> gestion reservation</a></li>
								<?php
								}
								?>
								<li><a href="profile.php"><i class="fa fa-pencil"></i> Profil </a></li>
								<li><a href="logout.php"><i class="fa fa-power-off"></i> Logout </a></li>
							</ul>
						</li>
						<?php
					} else {
						?>
						
						<li><a href="#" data-reveal-id="ConnectionModal"> Se connecter </a></li>
						
						<!-- CONNECTION MODAL -->
						<div id="ConnectionModal" class="reveal-modal tiny" data-reveal>
							<h2 class="subheader text-center"> Connection </h2>
							<div class="row">
								<form action="" method="post" data-abide>
									<div class="row">	

										<!-- LOGIN -->
										<div class="small-12 columns">
											<div class="row collapse prefix-radius">
												<div class="small-2 columns">
													<span class="prefix"><i class="fa fa-user"></i></span>
												</div><!-- class small-2 columns -->
												<div class="small-10 columns">
													<input type="text" name="login_username" placeholder="Login" required pattern="alpha"/>
													<small class="error"> Uniquement des lettres minuscules/majuscules. </small>
												</div><!-- class small-10 columns -->
											</div><!-- class row collapse prefix-radius -->
										</div><!-- class small-12 columns -->

										<!-- PASSWORD -->
										<div class="small-12 columns">
											<div class="row collapse prefix-radius">
												<div class="small-2 columns">
													<span class="prefix"><i class="fa fa-lock"></i></span>
												</div><!-- class small-2 columns -->
												<div class="small-10 columns">
													<input type="password" name="login_password" placeholder="Password" />
												</div><!-- class small-10 columns -->
											</div><!-- class row collapse prefix-radius -->
											<div class="large-12 columns text-center">
												<input type="checkbox" name="remember" id="remember">
												<label for="remember"> Rester connecté </label>
											</div><!-- class large-12 columns center -->
											<div class="large-12 columns text-center">	
												<input type="hidden" name="token_login" value="<?php echo $token ?>"/>
												<button class="button"> Se connecter </button>
											</div><!-- class large-12 columns center -->
										</div><!-- class small-12 columns -->

									</div><!-- class row -->
								</form>
							</div><!-- class row  -->
							<a class="close-reveal-modal">&#215;</a>
						</div><!-- class reveal-modal small of ConnectionModal -->

						<!-- ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////// -->
						

						<!-- ////////////////////////////////////////////  SUBSCRIBTION PART  ////////////////////////////////////////////////////////////////////// -->
						
						<li><a href="#" data-reveal-id="SubscribtionModal"> S'inscrire </a></li>

						<div id="SubscribtionModal" class="reveal-modal medium" data-reveal>
							<h2 class="subheader text-center"> Inscription </h2>
							<div class="row">
								<form action="" method="post" data-abide>
									
									<!-- LAST & FIRST NAME -->
									<div class="row">
										<div class="small-6 columns">
											<input type="text" name="lastname" placeholder="Nom" required pattern="alpha"/>
											<small class="error"> Uniquement des lettres minuscules/majuscules. </small>
										</div><!-- class small-6 columns -->
										<div class="small-6 columns">
											<input type="text" name="firstname" placeholder="Prénom" required pattern="alpha"/>
											<small class="error"> Uniquement des lettres minuscules/majuscules. </small>
										</div><!-- class small-6 columns -->
									</div><!-- class row -->

									<!-- LOGIN & EMAIL -->
									<div class="row">
										<div class="small-6 columns">
											<div class="row collapse prefix-radius">
												<div class="small-2 columns">
													<span class="prefix"><i class="fa fa-user"></i></span>
												</div><!-- class small-2 columns -->
												<div class="small-10 columns">
													<input type="text" name="username" placeholder="Pseudo" required pattern="alpha_numeric"/>
													<small class="error"> Uniquement des lettres minuscules/majuscules ou des chiffres (6 caractères min). </small>
												</div><!-- class small-2 columns -->
											</div><!-- class row collapse prefix-radius -->
										</div><!-- class small-6 columns -->
										<div class="small-6 columns">
											<div class="row collapse prefix-radius">
												<div class="small-2 columns">
													<span class="prefix"><i class="fa fa-envelope-o"></i></span>
												</div><!-- class small-2 columns -->
												<div class="small-10 columns email-field">
													<input type="email" name="email" placeholder="Email" required />
													<small class="error"> Votre email doit être de la forme: exemple@exemple.com </small>
												</div><!-- class small-10 columns email-field -->
											</div><!-- class row collapse prefix-radius -->
										</div><!-- class small-6 columns -->
									</div><!-- class row -->

									<!-- DATE OF BIRTH & PHONE NUMBER -->
									<div class="row">
										<div class="small-6 columns">
											<div class="row collapse prefix-radius">
												<div class="small-2 columns">
													<span class="prefix"><i class="fa fa-calendar"></i></span>
												</div><!-- class small-2 columns -->
												<div class="small-10 columns">
													<input class="fdatepicker" name="dob" data-date-format="dd/mm/yyyy" type="text" placeholder="Date de naissance" required />
												</div><!-- class small-10 columns -->
											</div><!-- class row collapse prefix-radius -->
										</div><!-- class small-6 columns -->
										<div class="small-6 columns">
											<div class="row collapse prefix-radius">
												<div class="small-2 columns">
													<span class="prefix"><i class="fa fa-mobile fa-lg"></i></span>
												</div><!-- class small-2 columns -->
												<div class="small-10 columns">
													<input type="text" name="phone" placeholder="Téléphone" required pattern="number" />
													<small class="error"> Votre numéro n'est pas conforme ! </small>
												</div><!-- class small-10 columns -->
											</div><!-- class row collapse prefix-radius -->
										</div><!-- class small-6 columns -->
									</div><!-- class row -->

									<!-- PASSWORD & CONFIRMATION -->
									<div class="row">
										<div class="small-6 columns">
											<div class="row collapse prefix-radius">
												<div class="small-2 columns">
													<span class="prefix"><i class="fa fa-lock"></i></span>
												</div><!-- class small-2 columns -->
												<div class="small-10 columns password-field">
													<input type="password" name="password" id="password" placeholder="Mot de passe" required pattern="alpha_numeric" />
													<small class="error"> Votre mot de passe doit contenir uniquement des chiffres et des lettres (minuscules ou majuscules). </small>
												</div><!-- class small-10 columns -->
											</div><!-- class row collapse prefix-radius -->
										</div><!-- small-6 columns -->
										<div class="small-6 columns">
											<div class="row collapse prefix-radius">
												<div class="small-2 columns">
													<span class="prefix"><i class="fa fa-check"></i></span>
												</div><!-- class small-2 columns -->
												<div class="small-10 columns password-confirmation-field">
													<input type="password" name="password2" placeholder="Confirmation" required pattern="alpha_numeric" data-equalto="password" />
													<small class="error"> Votre mot de passe n'est pas identique. </small>
												</div><!-- class small-10 columns -->
											</div><!-- class row collapse prefix-radius -->
										</div><!-- class small-6 columns -->
									</div><!-- class row -->

									<!-- SUBMIT -->
									<div class="row">
										<div class="small-12 columns text-center">
											<input type="hidden" name="token_register" value="<?php echo $token ?>"/>
											<button class="button radius"> Valider </button>
										</div><!-- class small-12 columns text-center -->
									</div><!-- class row -->

								</form>
							</div> <!-- class row -->
							<a class="close-reveal-modal">&#215;</a>
						</div><!-- class reveal-modal medium of SubscribtionModal -->
						<?php
					}
					?>
				</ul><!-- class right -->
			</section><!-- class top-bar-section -->
		</nav><!-- class top-bar -->
	</header>

	<!-- NAVBAR FOR SMALL DEVICES -->
	<div class="off-canvas-wrap" data-offcanvas>
		<div class="inner-wrap">
			<nav class="tab-bar">
				
				<section class="left tab-bar-section">
					<h1 class="title left"><a href="index.php"> Le Restaurant </h1>
				</section><!-- class left tab-bar-section -->

				<section class="right-small">
					<a class="right-off-canvas-toggle menu-icon" href="#"><span></span></a>
				</section><!-- class right-small -->

			</nav><!-- class tab-bar -->    
			<aside class="right-off-canvas-menu">
				<ul class="off-canvas-list">
					<?php
					if($user->isLoggedIn()){
						?>
						<li class="has-dropdown">
							<a href="#"><?php echo $user->data()->firstname ?> <i class="fa fa-user"></i></a>
							<ul class="dropdown">
								<li><a href="profile.php"><i class="fa fa-pencil"></i> Profil </a></li>
								<li><a href="logout.php"><i class="fa fa-power-off"></i> Logout </a></li>
							</ul><!-- class dropdown -->
						</li><!-- class has-dropdown -->
						<?php
					}else{
						?>

						<li><a href="#" data-reveal-id="ConnectionModal"> Se connecter </a></li>

						<li><a href="#" data-reveal-id="SubscribtionModal"> S'inscrire </a></li>
						<?php
					}
					?>
				</ul><!-- class off-canvas-list -->
			</aside><!-- class right-off-canvas-menu -->
			<section class="main-section">
				<!-- content goes here -->
