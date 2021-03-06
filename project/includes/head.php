<!DOCTYPE html>
<html id="top">
<head>
	<meta charset="utf-8">
	<meta name = "viewport" content = "width = device-width, initial-scale = 1, user-scalable = yes">
	<link rel="stylesheet" href="css/foundation-datepicker.css">
	<!-- INCLUDE FOUNDATION CSS -->
	<link rel="stylesheet" href="css/foundation.css">
	<!-- INCLUDE PICKADATE & PICKATIME CSS -->
	<link rel="stylesheet" href="js/pickadate.js-3.5.5/lib/themes/default.css">
	<link rel="stylesheet" href="js/pickadate.js-3.5.5/lib/themes/default.date.css">
	<link rel="stylesheet" href="js/pickadate.js-3.5.5/lib/themes/default.time.css">
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
	<title> Le Restaurant </title>
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
						<li><a href="#" data-reveal-id="ResaModal"> Réserver </a></li>
						<?php
					} else {
						?>

						<li><a href="#" data-reveal-id="TypeResaModal"> Réserver </a></li>

						<!-- RESERVATION WITH A CLIENT ACCOUNT OR NOT ? (MODAL) -->
						<div id="TypeResaModal" class="reveal-modal medium" data-reveal>
							
							<!-- DIRECT RESERVATION -->
							<div class="row">
								<div class="small-12 medium-12 large-12 columns">
									<div class="panel text-center">
										<h3 class="subheader"> Réservation directe </h3>
										<p> Réservez sans avoir de compte client si vous êtes pressé. </p>
										<button class="button radius" data-reveal-id="ResaModal"> Réserver </button>
									</div><!-- class panel -->
								</div><!-- class small-12 medium-12 large-12 columns -->
							</div><!-- class row -->

							<div class="row" data-equalizer>

								<!-- CONNECTION BEFORE RESERVATION -->
								<div class="small-12 medium-12 large-6 columns">
									<div class="panel text-center persoHeight" data-equalizer-watch>
										<h3 class="subheader"> Connexion </h3>
										<p> Connectez-vous et profitez des avantages client (points de fidelité). </p>
										<div class="row">
											<form action="" method="post" data-abide>
												<!-- LOGIN -->
												<div class="small-12 medium-12 large-12 columns">
													<div class="row collapse prefix-radius">
														<div class="small-2 columns">
															<span class="prefix"><i class="fa fa-user"></i></span>
														</div><!-- class small-2 columns -->
														<div class="small-10 medium-10 large-10 columns">
															<input type="text" name="login_username" placeholder="Login" />
														</div><!-- class small-10 medium-10 large-10 columns -->
													</div><!-- class row collapse prefix-radius -->
												</div><!-- class small-12 medium-12 large-12 columns -->

												<!-- PASSWORD -->
												<div class="small-12 medium-12 large-12 columns">
													<div class="row collapse prefix-radius">
														<div class="small-2 medium-2 large-2 columns">
															<span class="prefix"><i class="fa fa-lock"></i></span>
														</div><!-- class small-2 medium-2 large-2 columns -->
														<div class="small-10 medium-10 large-10 columns">
															<input type="password" name="login_password" placeholder="Password" />
														</div><!-- class small-10 medium-10 large-10 columns -->
													</div><!-- class row collapse prefix-radius -->
													<input type="checkbox" name="remember" id="remember">
													<label for="remember"> Rester connecté </label>		
													<div class="small-12 medium-12 large-12 columns center">
														<input type="hidden" name="token_login" value="<?php echo $token ?>"/>
														<button class="button"> Se connecter </button>
													</div><!-- class small-12 medium-12 large-12 columns center -->
												</div><!-- class small-12 medium-12 large-12 columns -->

											</form>
										</div><!-- class row for connectionForm -->
									</div><!-- class panel text-center -->
								</div><!-- class small-12 medium-12 large-6 columns -->

								<!-- SUBSCRIBTION BEFORE RESERVATION -->
								<div class="small-12 medium-12 large-6 columns">
									<div class="panel text-center persoHeight" data-equalizer-watch>
										<h3 class="subheader"> Inscription </h3>
										<p> Inscrivez-vous et cumulez des points de fidelité afin d'obtenir des réductions sur vos prochaines réservations. </p>
										<p> Vous aurez accès à un récapitulatif de vos anciennes réservations. </p>
										<button class="button radius" data-reveal-id="SubscribtionModal"> S'inscrire </button>
									</div><!-- class panel text-center -->
								</div><!-- class small-12 medium-12 large-6 columns -->

							</div><!-- class row -->
							<a class="close-reveal-modal">&#215;</a>
						</div><!-- class reveal-modal of TypeResaModal -->

						<?php
					}
					?>
					<!-- RESERVATION MODAL -->
					<div id="ResaModal" class="reveal-modal medium" data-reveal>
						<div class="row">
							<h2 class="subheader text-center"> Réservation </h2>
							<ul class="tabs small-11 small-centered column text-center" data-tab>
								<li class="tab-title active"><a href="#panel11"><i class="fa fa-calendar"></i> Date </a></li>
								<li class="tab-title"><a href="#panel12"><i class="fa fa-clock-o"></i> Créneaux </a></li>
								<li class="tab-title"><a href="#panel13"><i class="fa fa-users"></i> Personnes </a></li>
								<li class="tab-title"><a href="#panel14"> Validation </a></li>
							</ul>
							<div class="tabs-content">
								<div class="content active" id="panel11">
									<div class="row">
										<!-- PICKADATE -->
										<div class="small-8 small-centered text-center column">
											<input type="hidden" class="datepicker hide"/>
										</div>
									</div>
								</div>
								<div class="content" id="panel12">
									<div class="row">
										<div class="small-8 small-centered text-center column time-display"></div>
									</div>
								</div>
								<div class="content" id="panel13">
									<div class="small-8 small-centered text-center column seat-display"></div>
								</div>
								<div class="content" id="panel14">
									<form id="ResaForm" action="" method="post" data-abide>
										<div class="small-10 small-centered column"><!-- RESERVATION NAME -->
											<div class="row">
												<div class="row collapse prefix-radius">
													<div class="small-2 columns">
														<span class="prefix"><i class="fa fa-user"></i></span>
													</div><!-- small-2 columns -->
													<div class="small-10 columns">
														<input type="text" name="name" placeholder="Nom" value="<?php echo ($user->isLoggedIn()) ? $user->data()->lastname : ""; ?>" required pattern="alpha" <?php echo ($user->isLoggedIn()) ? "disabled" : ""; ?> >

														<small class="error"> Le nom doit contenir uniquement de minuscules/majuscules. </small>

													</div><!-- class small-10 columns -->
												</div><!-- class row collapse prefix-radius -->
											</div><!-- class row -->

											<div class="row">
												<div class="row collapse prefix-radius">
													<div class="small-2 columns">
														<span class="prefix"><i class="fa fa-envelope-o"></i></span>
													</div><!-- small-2 columns -->
													<div class="small-10 columns">

														<input type="text" name="email" placeholder="Email" value="<?php echo ($user->isLoggedIn()) ? $user->data()->email : ""; ?>" required pattern="email" <?php echo ($user->isLoggedIn()) ? "disabled" : ""; ?> >
														<small class="error"> L'email doit être valide (exemple@exemple.fr). </small>

													</div><!-- class small-10 columns -->
												</div><!-- class row collapse prefix-radius -->
											</div><!-- class row -->

											<div class="row">
												<div class="row collapse prefix-radius">
													<div class="small-2 columns">
														<span class="prefix"><i class="fa fa-phone"></i></span>
													</div><!-- small-2 columns -->
													<div class="small-10 columns">

														<input type="text" name="phone" placeholder="Téléphone" max="9" value="<?php echo ($user->isLoggedIn()) ? '0'.$user->data()->phone : ""; ?>" required pattern="number" <?php echo ($user->isLoggedIn()) ? "disabled" : ""; ?> >
														<small class="error"> Le numéro doit être composé uniquement de chiffres. </small>

													</div><!-- class small-10 columns -->
												</div><!-- class row collapse prefix-radius -->
											</div><!-- class row -->

											<!-- SUBMIT -->
											<div class="row">
												<div class="large-12 columns text-center">
													<input type="checkbox" name="conditions" id="conditions">
													<label for="conditions"> J'accepte les conditions d'utilisation de "Le Restaurant" </label>
												</div><!-- class large-12 columns text-center -->
												<div class="large-12 columns text-center">
													<button class="button radius"> Réserver </button>
												</div><!-- class large-12 columns text-center -->
											</div><!-- class row --></div>
										</form>
									</div>
								</div>
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
										<li><a href="control.php"><i class="fa fa-users"></i> Gestion des utilisateurs </a></li>
										<?php
									}
									if($user->hasPermission("cook")){
										?>
										<li><a href="cook.php"><i class="fa fa-cutlery"></i> Gestion du menu </a></li>
										<?php
									}
									if($user->hasPermission("receptionist")){
										?>
										<li><a href="receptionist.php"><i class="fa fa-laptop"></i> Gestion des réservations </a></li>
										<?php
									}
									?>
									<li><a href="history.php"><i class="fa fa-history"></i> Historique des reservations </a></li>
									<li><a href="profile.php"><i class="fa fa-pencil"></i> Profil </a></li>
									<li><a href="logout.php"><i class="fa fa-power-off"></i> Déconnexion </a></li>
								</ul>
							</li>
							<?php
						} else {
							?>

							<li><a href="#" data-reveal-id="ConnectionModal"> Se connecter </a></li>

							<!-- CONNECTION MODAL -->
							<div id="ConnectionModal" class="reveal-modal tiny" data-reveal>
								<h2 class="subheader text-center"> Connexion </h2>
								<div class="row">
									<div id="mainAlert2" data-alert class="alert-box alert hide" tabindex="0" aria-live="assertive" role="dialogalert">
										<p class="flash"><?php
											if(session::exists('login')){
												foreach(session::flash('login') as $error){
													echo $error.'</br>';
												}
											}
											?></p>
											<button href="#" tabindex="0" class="close" aria-label="Close Alert">&times;</button>
										</div>
										<form action="" method="post" data-abide>
											<div class="row">	
												<!-- LOGIN -->
												<div class="small-12 medium-12 large-12 columns">
													<div class="row collapse prefix-radius">
														<div class="small-2 medium-2 large-2 columns">
															<span class="prefix"><i class="fa fa-user"></i></span>
														</div><!-- class small-2 medium-2 large-2 columns -->
														<div class="small-10 medium-10 large-10 columns">
															<input type="text" name="login_username" placeholder="Login" required pattern="alpha"/>
															<small class="error"> Uniquement des lettres minuscules/majuscules. </small>
														</div><!-- class small-10 medium-10 large-10 columns -->
													</div><!-- class row collapse prefix-radius -->
												</div><!-- class small-12 medium-12 large-12 columns -->

												<!-- PASSWORD -->
												<div class="small-12 medium-12 large-12 columns">
													<div class="row collapse prefix-radius">
														<div class="small-2 medium-2 large-2 columns">
															<span class="prefix"><i class="fa fa-lock"></i></span>
														</div><!-- class small-2 medium-2 large-2 columns -->
														<div class="small-10 medium-10 large-10 columns">
															<input type="password" name="login_password" placeholder="Password" />
														</div><!-- class small-10 medium-10 large-10 columns -->
													</div><!-- class row collapse prefix-radius -->
													<div class="small-12 medium-12 large-12 columns text-center">
														<input type="checkbox" name="remember" id="remember">
														<label for="remember"> Rester connecté </label>
													</div><!-- class small-12 medium-12 large-12 columns center -->
													<div class="small-12 medium-12 large-12 columns text-center">	
														<input type="hidden" name="token_login" value="<?php echo $token ?>"/>
														<button class="button"> Se connecter </button>
													</div><!-- class small-12 medium-12 large-12 columns center -->
												</div><!-- class small-12 medium-12 large-12 columns -->

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
									<div id="mainAlert3" data-alert class="alert-box alert hide" tabindex="0" aria-live="assertive" role="dialogalert">
										<p class="flash"><?php
											if(session::exists('register')){
												foreach(session::flash('register') as $error){
													echo $error.'</br>';
												}
											}
											?></p>
											<button href="#" tabindex="0" class="close" aria-label="Close Alert">&times;</button>
										</div>
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
																<input class="fdatepicker" name="dob" type="text" placeholder="Date de naissance" required />
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
											<?php
											if($user->hasPermission("admin")){
												?>
												<li><a href="control.php"><i class="fa fa-users"></i> Gestion des utilisateurs </a></li>
												<?php
											}
											if($user->hasPermission("cook")){
												?>
												<li><a href="cook.php"><i class="fa fa-cutlery"></i> Gestion du menu </a></li>
												<?php
											}
											if($user->hasPermission("receptionist")){
												?>
												<li><a href="receptionist.php"><i class="fa fa-laptop"></i> Gestion des réservations </a></li>
												<?php
											}
											?>
											<li><a href="history.php"><i class="fa fa-history"></i> Historique des réservations</a></li>
											<li><a href="profile.php"><i class="fa fa-pencil"></i> Profil </a></li>
											<li><a href="logout.php"><i class="fa fa-power-off"></i> Déconnexion </a></li>
										</ul>
									</li><!-- class has-dropdown -->
									<li><a href="#" data-reveal-id="ResaModal"> Réserver </a></li>
									<?php
								}else{
									?>
									<li><a href="#" data-reveal-id="TypeResaModal"> Réserver </a></li>

									<li><a href="#" data-reveal-id="ConnectionModal"> Se connecter </a></li>

									<li><a href="#" data-reveal-id="SubscribtionModal"> S'inscrire </a></li>
									<?php
								}
								?>
							</ul><!-- class off-canvas-list -->
						</aside><!-- class right-off-canvas-menu -->
						<section class="main-section">
							<!-- content goes here -->
