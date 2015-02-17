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
			<div class="row">
				
					<form action="" method="post">
						<div class="large-12 column">
							<div class="large-2 column">
								<label class="left inline" for="name">Username : </label>
							</div>
							<div class="large-8 column">
								<input type="text" name="name" id="name" value="<?php echo escape($user->data()->username); ?>"/>
							</div>
						</div>
						<div class="large-12 column">
							<div class="large-2 column">
								<label class="left inline" for="name">Prénom : </label>
							</div>
							<div class="large-8 column">
								<input type="text" name="name" id="name" value="<?php echo escape($user->data()->firstname); ?>"/>
							</div>
						</div>
						<div class="large-12 column">
							<div class="large-2 column">
								<label class="left inline" for="name">Nom : </label>
							</div>
							<div class="large-8 column">
								<input type="text" name="name" id="name" value="<?php echo escape($user->data()->lastname); ?>"/>
							</div>
						</div>
						<div class="large-12 column">
							<div class="large-2 column">
								<label class="left inline" for="name">Téléphone : </label>
							</div>
							<div class="large-8 column">
								<input type="text" name="name" id="name" value="0<?php echo escape($user->data()->phone); ?>"/>
							</div>
						</div>
						<div class="large-12 column">
							<div class="large-2 column">
								<label class="left inline" for="name">Email : </label>
							</div>
							<div class="large-8 column">
								<input type="text" name="name" id="name" value="<?php echo escape($user->data()->email); ?>"/>
							</div>
						</div>
						<div class="large-12 column">
							<div class="large-2 column">
								<label class="left inline" for="name">Mot de passe : </label>
							</div>
							<div class="large-8 column">
								<input type="text" name="name" id="name" value="<?php echo escape($user->data()->password); ?>"/>
							</div>
						</div>



						<div class="large-2 column end">
							<input type="hidden" name="token" value="<?php echo token::generate(); ?>"/>
							<input type="submit" class="button postfix" value="Update"/>
						</div>
					</form>
				
			</div>
<?php
include_once 'footer.php';
?>