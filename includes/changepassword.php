<?php
include_once("../core/init.php");


$user = new user();

if(!$user->isLoggedIn()){
	redirect::to("index.php");
}

if(input::exists()){
	if(token::check(input::get('token'))){
		$validate = new validation();
		$validation = $validate->check($_POST, array(
			'current_password' => array(
				'error' => 'current password',
				'required' => true,
				'min' => 6
			),
			'new_password' => array(
				'error' => 'new password',
				'required' => true,
				'min' => 6
			),
			'new_password_again' => array(
				'error' => 'the second new password',
				'required' => true,
				'min' => 6,
				'matches' => 'new_password'
			)
		));

		if($validation->passed()){
			if(hash::generate(input::get('current_password'), $user->data()->salt) !== $user->data()->password){
				echo "The current password is wrong </br>";
			}else{
			
				$salt = hash::salt(32);
				$user->update(array(
					'password' => hash::generate(input::get('new_password'), $salt),
					'salt' => $salt
				));

				session::flash('home', "You're password has been changed successfuly");
				redirect::to("index.php");
			}

		}else{
			foreach ($validation->errors() as $error) {
				echo $error, '</br>';
			}
		}
	}
}

?>
<!DOCTYPE html>
<html>
	<head>
	<title>The Wooden Pipe Store</title>
	<meta charset="utf-8" />
	<meta name = "viewport" content = "width = device-width, initial-scale = 0.4, user-scalable = yes">
	<link rel="shortcut icon" href="assets/icons/tree.ico"/>
	<link rel="stylesheet" media="screen" type="text/css" href="assets/styleCore.css"/>
	</head>
	<body>
		<header>
			<a href="index.php"><img src="assets/title_small.jpg" alt="oak_tree_title"/></a>
			<nav>
				<ul class="nav">
					<li class="nav-item" id="title"><a href="index.php">The Wooden Pipe Store</a></li>
					<div class="primary-nav">
						<li class="nav-item"><a href="produits.php">Boutique</a></li>
						<li class="nav-item"><a href="cv.php">L'equipe</a>
							<ul class="nav sub-nav">
								<li class="sub-nav-item"><a href="cvkocke.php">Christian Kocke</a></li>
								<li class="sub-nav-item"><a href="cvfoucher.php">Theo Foucher</a></li>
							</ul>
						</li>
						<li class="nav-item"><a href="contact.php">Contact</a></li>
					</div>
					<div class="account-nav">	
					<?php if(session::exists('basket')){
								if(count(session::get('basket')) >= 1){
								?>
									<li class="nav-item"><a href="basket.php"><img src="assets/icons/kart2.png" alt="shopping kart"/>  <?php echo count(session::get('basket')); ?> item(s)</a></li>
								<?php
								}
							}				 
					if(!$user->isLoggedIn()){	
					?>
						<li class="nav-item"><a href="register.php">Register</a></li>																			
						<li class="nav-item"><a href="login.php">Login</a></li>
					<?php
					}else{
					?>
						<li class="nav-item"><a href="logout.php">Logout</a></li>
					<?php
					}
					?>
					</div>
				</ul>
			</nav>
		</header>
		<article>
			<form action="" method="post">
			    <div class="field">
			        <label for="current_password">Current password</label>
			        <input type="password" name="current_password" id="current_password"/>
			    </div>
			    <div class="field">
			        <label for="new_password">New password</label>
			        <input type="password" name="new_password" id="new_password"/>
			    </div>
			       <div class="field">
			        <label for="new_password_again">Verify new password</label>
			        <input type="password" name="new_password_again" id="new_password_again"/>
			    </div>
			    <input type="hidden" name="token" value="<?php echo token::generate(); ?>"/>
			    <input type="submit" value="Register"/>
			</form>
		</article>
		<footer>
			<ul>
				<li>Copyright 2013 by Christian Kocke</li>
				<li><img src="assets/icons/html5-32-black.png" alt="html5"/><img src="assets/icons/css3.png" alt="css3"/><img src="assets/icons/w3c.png" alt="w3c"/></li>
			</ul>
		</footer>
	</body>
</html>
