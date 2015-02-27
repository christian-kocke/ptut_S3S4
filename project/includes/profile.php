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
				<div class="small-12 columns">
					<div class="panel text-center">
						<form action="" method="post" data-abide>
						
						<!-- USERNAME -->
						fa fa-user
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
						<div class="large-12 column">
							<div class="large-2 column">
								<label class="left inline" for="username">Username : </label>
							</div>
							<div class="large-8 column">
								<input type="text" name="username" id="username" value="<?php echo escape($user->data()->username); ?>"/>
							</div>
						</div>
						<div class="large-12 column">
							<div class="large-2 column">
								<label class="left inline" for="firstname">Prénom : </label>
							</div>
							<div class="large-8 column">
								<input type="text" name="firstname" id="firstname" value="<?php echo escape($user->data()->firstname); ?>"/>
							</div>
						</div>
						<div class="large-12 column">
							<div class="large-2 column">
								<label class="left inline" for="lastname">Nom : </label>
							</div>
							<div class="large-8 column">
								<input type="text" name="lastname" id="lastname" value="<?php echo escape($user->data()->lastname); ?>"/>
							</div>
						</div>
						<div class="large-12 column">
							<div class="large-2 column">
								<label class="left inline" for="tel">Téléphone : </label>
							</div>
							<div class="large-8 column">
								<input type="tel" name="tel" id="tel" value="0<?php echo escape($user->data()->phone); ?>"/>
							</div>
						</div>
						<div class="large-12 column">
							<div class="large-2 column">
								<label class="left inline" for="email">Email : </label>
							</div>
							<div class="large-8 column">
								<input type="email" name="email" id="email" value="<?php echo escape($user->data()->email); ?>"/>
							</div>
						</div>

						<div class="large-2 column end">
							<input type="hidden" name="token" value="<?php echo token::generate(); ?>"/>
							<input type="submit" class="button postfix" value="update"/>
						</div>
					</form>
				
			</div>
<?php
include_once 'footer.php';
?>