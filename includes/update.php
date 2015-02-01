<?php
include_once('../core/init.php');

$user = new user();

if(!$user->isLoggedIn()){
	redirect::to('index.php');
}

if(input::exists()){
	if(token::check(input::get('token'))){
		$validate = new validation();
		$validation = $validate->check('$_POST', array(
			'name' => array(
				'error' => 'new name',
				'required' => true,
				'min' => 2,
				'max' => 50
			)
		));

		if($validation->passed()){
			try{
				$user->update(array(
					'name' => input::get('name')
				));
				session::flash('home', 'Your name has been updated successfuly');
				redirect::to('index.php');

			}catch(Exception $e){
				die($e->getMessage());
			}
			
		}else{
			foreach ($validation->errors() as $error) {
				echo $error, '</br>';
			}
		}
	}
}
require_once 'head.php';
?>
		<article>
			<form action="" method="post">
				<div class="field">
					<label for="name">Name</label>
					<input type="text" name="name" id="name" value="<?php echo escape($user->data()->name); ?>"/>
					<input type="hidden" name="token" value="<?php echo token::generate(); ?>"/>
					<input type="submit" value="Update"/>
				</div>
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