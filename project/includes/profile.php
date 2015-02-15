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
				<div class="large-12 column">
					<form action="" method="post">
						<div class="large-2 column">
							<label class="right inline" for="name">Name : </label>
						</div>
						<div class="large-8 column">
							<input type="text" name="name" id="name" value="<?php echo escape($user->data()->name); ?>"/>
						</div>
						<div class="large-2 column end">
							<input type="hidden" name="token" value="<?php echo token::generate(); ?>"/>
							<input type="submit" class="button postfix" value="Update"/>
						</div>
					</form>
				</div>
			</div>
<?php
include_once 'footer.php';
?>