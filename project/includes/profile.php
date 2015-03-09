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
include_once 'head.php';
?>
<div class="row">
	<div class="panel small-8 small-centered columns">
		<h2 class="subheader text-center t3"> Profil </h2>
		<form action="" method="post" class="t3">

			<!-- USERNAME -->
			<div class="small-12 columns">
				<div class="row">
					<div class="small-2 columns">
						<label for="username" class="right inline"> Login </label>
					</div><!-- class small-2 columns -->
					<div class="small-10 columns">
						<input type="text" name="username" id="username" value="<?php echo escape($user->data()->username); ?>"/>
					</div><!-- class small-10 columns -->
				</div><!-- class row -->
			</div><!-- class small-12 columns -->

			<!-- FIRSTNAME -->
			<div class="small-12 columns">
				<div class="row">
					<div class="small-2 columns">
						<label for="firstname" class="right inline"> Prénom : </label>
					</div><!-- class small-2 columns -->
					<div class="small-10 columns">
						<input type="text" name="firstname" id="firstname" value="<?php echo escape($user->data()->firstname); ?>"/>
					</div><!-- class small-10 columns -->
				</div><!-- class row -->
			</div><!-- class small-12 columns -->

			<!-- LASTNAME -->
			<div class="small-12 columns">
				<div class="row">
					<div class="small-2 columns">
						<label for="lastname" class="right inline"> Nom : </label>
					</div><!-- class small-2 columns -->
					<div class="small-10 columns">
						<input type="text" name="lastname" id="lastname" value="<?php echo escape($user->data()->lastname); ?>"/>
					</div><!-- class small-10 columns -->
				</div><!-- class row -->
			</div><!-- class small-12 columns -->

			<!-- PHONE -->
			<div class="small-12 columns">
				<div class="row">
					<div class="small-2 columns">
						<label for="tel" class="right inline"> Téléphone : </label>
					</div><!-- class small-2 columns -->
					<div class="small-10 columns">
						<input type="tel" name="tel" id="tel" value="0<?php echo escape($user->data()->phone); ?>"/>
					</div><!-- class small-10 columns -->
				</div><!-- class row -->
			</div><!-- class small-12 columns -->

			<!-- EMAIL -->
			<div class="small-12 columns">
				<div class="row">
					<div class="small-2 columns">
						<label for="email" class="right inline"> Email : </label>
					</div><!-- class small-2 columns -->
					<div class="small-10 columns">
						<input type="email" name="email" id="email" value="<?php echo escape($user->data()->email); ?>"/>
					</div><!-- class small-10 columns -->
				</div><!-- class row -->
			</div><!-- class small-12 columns -->

			<!-- UPDATE -->
			<div class="row">
				<div class="small-12 columns text-center">
					<input type="hidden" name="token" value="<?php echo token::generate(); ?>"/>
					<button class="button radius"> Update </button>
				</div><!-- class small-12 columns text-center -->
			</div><!-- class row -->

		</form>
	</div><!-- class panel -->
</div><!-- class row -->
<?php
include_once 'footer.php';
?>