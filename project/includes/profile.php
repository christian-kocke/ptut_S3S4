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
<div id="mainAlert4" data-alert class="alert-box success hide large-7 medium-6 small-5 large-centred medium-centered small-centered column text-center" tabindex="0" aria-live="assertive" role="dialogalert">
	<p class="flash"></p>
	<button href="#" tabindex="0" class="close" aria-label="Close Alert">&times;</button>
</div>
<div class="row">
	<ul class="tabs vertical" data-tab>
		<li class="tab-title active"><a href="#panel11">Information du profil</a></li>
		<li class="tab-title"><a href="#panel21">Changer sont mot de passe</a></li>
	</ul>
	<div class="tabs-content">
		<div class="content active" id="panel11">
			<div class="row"></div>
			<div class="small-8 small-centered column panel">
				<form action="" method="post" class="passwordForm" id="passwordForm">
					<!-- ANCIEN PASSWORD -->
					<div class="small-12 columns">
						<div class="row">
							<div class="small-6 columns">
								<label for="password" class="right inline"> Ancien mot de passe : </label>
							</div><!-- class small-2 columns -->
							<div class="small-6 columns">
								<input type="password" name="password" id="password" />
							</div><!-- class small-10 columns -->
						</div><!-- class row -->
					</div><!-- class small-12 columns -->

					<!-- NOUVEAU PASSWORD -->
					<div class="small-12 columns">
						<div class="row">
							<div class="small-6 columns">
								<label for="newpassword" class="right inline"> Nouveau mot de passe : </label>
							</div><!-- class small-2 columns -->
							<div class="small-6 columns">
								<input type="password" name="newpassword" id="newpassword" />
							</div><!-- class small-10 columns -->
						</div><!-- class row -->
					</div><!-- class small-12 columns -->

					<!-- RETAPE NOUVEAU PASSWORD -->
					<div class="small-12 columns">
						<div class="row">
							<div class="small-6 columns">
								<label for="renewpassword" class="right inline"> Retaper mot de passe : </label>
							</div><!-- class small-2 columns -->
							<div class="small-6 columns">
								<input type="password" name="renewpassword" id="renewpassword" />
							</div><!-- class small-10 columns -->
						</div><!-- class row -->
					</div><!-- class small-12 columns -->

					<!-- UPDATE -->
					<div class="row">
						<div class="small-12 columns text-center">
							<input type="hidden" name="token" value="<?php echo token::generate(); ?>"/>
							<button class="button radius" type="submit" value="<?php echo $user->data()->id; ?>" > Update </button>
						</div><!-- class small-12 columns text-center -->
					</div><!-- class row -->
				</form>
			</div>
		</div>
		<div class="content" id="panel21">
			<div class="row">
				<div class="panel small-8 columns">
					<h2 class="subheader text-center t3"> Profil </h2>
					<form action="" method="post" class="t3">
						<!-- USERNAME -->
						<div class="small-12 columns small-centered columns">
							<div class="row">
								<div class="small-6 columns ">
									<label for="username" class="right inline"> Login : </label>
								</div><!-- class small-2 columns -->
								<div class="small-6 columns">
									<input type="text" name="username" id="username" value="<?php echo escape($user->data()->username); ?>"/>
								</div><!-- class small-10 columns -->
							</div><!-- class row -->
						</div><!-- class small-12 columns -->

						<!-- FIRSTNAME -->
						<div class="small-12 columns">
							<div class="row">
								<div class="small-6 columns">
									<label for="firstname" class="right inline"> Prénom : </label>
								</div><!-- class small-2 columns -->
								<div class="small-6 columns">
									<input type="text" name="firstname" id="firstname" value="<?php echo escape($user->data()->firstname); ?>"/>
								</div><!-- class small-10 columns -->
							</div><!-- class row -->
						</div><!-- class small-12 columns -->

						<!-- LASTNAME -->
						<div class="small-12 columns">
							<div class="row">
								<div class="small-6 columns">
									<label for="lastname" class="right inline"> Nom : </label>
								</div><!-- class small-2 columns -->
								<div class="small-6 columns">
									<input type="text" name="lastname" id="lastname" value="<?php echo escape($user->data()->lastname); ?>"/>
								</div><!-- class small-10 columns -->
							</div><!-- class row -->
						</div><!-- class small-12 columns -->

						<!-- PHONE -->
						<div class="small-12 columns">
							<div class="row">
								<div class="small-6 columns">
									<label for="tel" class="right inline"> Téléphone : </label>
								</div><!-- class small-2 columns -->
								<div class="small-6 columns">
									<input type="tel" name="tel" id="tel" value="0<?php echo escape($user->data()->phone); ?>"/>
								</div><!-- class small-10 columns -->
							</div><!-- class row -->
						</div><!-- class small-12 columns -->

						<!-- EMAIL -->
						<div class="small-12 columns">
							<div class="row">
								<div class="small-6 columns">
									<label for="email" class="right inline"> Email : </label>
								</div><!-- class small-2 columns -->
								<div class="small-6 columns">
									<input type="email" name="email" id="email" value="<?php echo escape($user->data()->email); ?>"/>
								</div><!-- class small-10 columns -->
							</div><!-- class row -->
						</div><!-- class small-12 columns -->

						<!-- UPDATE -->
						<div class="row">
							<div class="small-12 columns text-center">
								<input type="hidden" name="token" value="<?php echo token::generate(); ?>"/>
								<button class="button radius" type="submit" value="<?php echo $user->data()->id; ?>"> Update </button>
							</div><!-- class small-12 columns text-center -->
						</div><!-- class row -->

					</form>
				</div><!-- class panel -->
			</div>
		</div><!-- class tab content -->
	</div>
</div><!-- class row -->
<!-- FOOTER -->

<footer>	


	<!-- SOCIAL NETWORKS -->
	<div class="small-12 medium-12 large-12 footerBis columns" data-equalizer>
		
		

		<div class="small-12 medium-12 large-4 columns" data-equalizer-watch>	
			<div class="row collapse prefix-radius">
				<div class="small-2 medium-2 large-2 columns">
					<span class="prefix"><i class="fa fa-envelope-o"></i></span>
				</div><!-- class small-2 medium-2 large-2 columns -->
				<div class="small-8 medium-8 large-8 columns">
					<input type="text" name="email-newsletter" placeholder="Email" />
				</div><!-- class small-8 medium-8 large-8 columns -->
				<div class="small-2 medium-2 large-2 columns">
					<a href="#" class="button postfix"> Go </a>
				</div><!-- class small-2 medium-2 large-2 columns -->
			</div><!-- class row collapse prefix-radius -->
		</div><!-- class small-12 medium-12 large-8 columns -->

		<div class="small-12 medium-12 large-4 columns t2">
			<p class="text-center"> ©Le Restaurant 2014 </p>
		</div><!-- class small-12 medium-12 large-12 columns -->

		<div class="small-12 medium-12 large-4 columns" data-equalizer-watch>
			<!-- FACEBOOK -->
			<div class="small-3 columns">
				<a href=""><span class="fa-stack fa-lg">
					<i class="fa fa-square-o fa-stack-2x"></i>
					<i class="fa fa-facebook fa-stack-1x"></i>
				</span></a>
			</div><!-- class small-3 columns -->

			<!-- TWITTER -->
			<div class="small-3 columns">
				<a href=""><span class="fa-stack fa-lg">
					<i class="fa fa-square-o fa-stack-2x"></i>
					<i class="fa fa-twitter fa-stack-1x"></i>
				</span></a>
			</div><!-- class small-3 columns -->

			<!-- GOOGLE PLUS -->
			<div class="small-3 columns">
				<a href=""><span class="fa-stack fa-lg">
					<i class="fa fa-square-o fa-stack-2x"></i>
					<i class="fa fa-google-plus fa-stack-1x"></i>
				</span></a>
			</div><!-- class small-3 columns -->

			<!-- LINKEDIN -->
			<div class="small-3 columns">
				<a href=""><span class="fa-stack fa-lg">
					<i class="fa fa-square-o fa-stack-2x"></i>
					<i class="fa fa-linkedin fa-stack-1x"></i>
				</span></a>
			</div><!-- class small-3 columns -->
		</div><!-- class small-12 medium-12 large-4 footer Bis columns -->

	</div><!-- small-12 medium-12 large-12 footerBis columns -->
	
</footer>

<!-- BACK TO TOP BUTTON -->
<div class="small-1 columns" id="back-top">
	<a href="#top" class="button info"><i class="fa fa-arrow-up fa-2x"></i></a>
</div><!-- class small-2 columns -->

<script src="js/index.js"></script>
<script src="js/vendor/fastclick.js"></script>
<script src="js/foundation.min.js"></script>
<script>
	$(document).foundation();
	$(document).foundation({
		offcanvas : {
		    // Sets method in which offcanvas opens.
		    // [ move | overlap_single | overlap ]
		    open_method: 'move', 
		    // Should the menu close when a menu link is clicked?
		    // [ true | false ]
		    close_on_click : true
		}
	});
	var toId;
	$(".passwordForm").on("submit", function(){
		if($(".passwordForm :input[name=newpassword]").val() === $(".passwordForm :input[name=renewpassword]").val()){
			var data = {
				"action": "changePassword",
				"table": "users",
				"id": $(".passwordForm :button[type=submit]").val(),
				"old": $(".passwordForm :input[name=password]").val(),
				"new": $(".passwordForm :input[name=newpassword]").val()
			};
			data = $.param(data);
			$.ajax({
				type: "POST",
				dataType: "json",
				url: "response.php", 
				data: data,
				success: function(data) {
					console.log("ok");
					if(data[0]){
						$(".flash").html("Le mot de passe a été modifier !");
						type = "success"
						document.getElementById("passwordForm").reset();
					}else{
						$(".flash").html("");
						for(i = 0; i < data[1].length; i++){
							$(".flash").append(data[1][i]+"</br>");
						}
						type = "alert"
					}
					$("#mainAlert4").toggleClass("hide success alert", false);
					$("#mainAlert4").toggleClass(type, true)
					clearTimeout(toId);
					toId = setTimeout(function() {
						$("#mainAlert4").toggleClass("hide", true)
					}, 2000);
				}
			});
		}
		return false;
	});
</script>
</section><!-- class main-section -->
<a class="exit-off-canvas"></a>
</div><!-- class inner-wrap -->
</div><!-- class off-canvas-wrap -->
</body>
</html>