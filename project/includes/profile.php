<?php
include_once('../core/init.php');

$user = new user();

if(!$user->isLoggedIn()){
	redirect::to('index.php');
}

include_once 'head.php';
?>
<div class="loading hide"></div>
<div id="mainAlert4" data-alert class="alert-box success hide large-7 medium-6 small-5 large-centred medium-centered small-centered column text-center" tabindex="0" aria-live="assertive" role="dialogalert">
	<p class="flash"></p>
	<button href="#" tabindex="0" class="close" aria-label="Close Alert">&times;</button>
</div>

<div class="row t3">
	<ul class="tabs vertical" data-tab>
		<li class="tab-title active"><a href="#panel2"> Informations du profil </a></li>
		<li class="tab-title "><a href="#panel1"> Changer son mot de passe </a></li>
	</ul>



	<div class="tabs-content">
		<div class="content " id="panel1">
			<div class="row">
				<div class="small-6 small-centered column panel">
					<h2 class="subheader text-center t3"> Mot de passe </h2>
					<form action="" method="post" class="passwordForm t3" id="passwordForm">
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
									<label for="renewpassword" class="right inline"> Retaper le mot de passe : </label>
								</div><!-- class small-2 columns -->
								<div class="small-6 columns">
									<input type="password" name="renewpassword" id="renewpassword" />
								</div><!-- class small-10 columns -->
							</div><!-- class row -->
						</div><!-- class small-12 columns -->

						<!-- UPDATE -->
						<div class="row">
							<div class="small-12 columns text-center">
								<button class="button radius" type="submit" value="<?php echo $user->data()->id; ?>" > Update </button>
							</div><!-- class small-12 columns text-center -->
						</div><!-- class row -->
					</form>
				</div>
			</div>
		</div>


		<div class="content active" id="panel2">
			<div class="row">
				<div class="small-6 small-centered columns panel">
					<h2 class="subheader text-center t3"> Profil </h2>
					<form action="" method="post" class="t3 infoForm">
						<!-- USERNAME -->
						<div class="small-12 columns">
							<div class="row">
								<div class="small-4 columns ">
									<label for="username" class="right inline"> Login : </label>
								</div><!-- class small-2 columns -->
								<div class="small-8 columns">
									<input type="text" name="username" id="username" value=<?php echo escape($user->data()->username); ?> />
								</div><!-- class small-10 columns -->
							</div><!-- class row -->
						</div><!-- class small-12 columns -->

						<!-- FIRSTNAME -->
						<div class="small-12 columns">
							<div class="row">
								<div class="small-4 columns">
									<label for="firstname" class="right inline"> Prénom : </label>
								</div><!-- class small-2 columns -->
								<div class="small-8 columns">
									<input type="text" name="firstname" id="firstname" value="<?php echo escape($user->data()->firstname); ?>"/>
								</div><!-- class small-10 columns -->
							</div><!-- class row -->
						</div><!-- class small-12 columns -->

						<!-- LASTNAME -->
						<div class="small-12 columns">
							<div class="row">
								<div class="small-4 columns">
									<label for="lastname" class="right inline"> Nom : </label>
								</div><!-- class small-2 columns -->
								<div class="small-8 columns">
									<input type="text" name="lastname" id="lastname" value="<?php echo escape($user->data()->lastname); ?>"/>
								</div><!-- class small-10 columns -->
							</div><!-- class row -->
						</div><!-- class small-12 columns -->

						<!-- PHONE -->
						<div class="small-12 columns">
							<div class="row">
								<div class="small-4 columns">
									<label for="tel" class="right inline"> Téléphone : </label>
								</div><!-- class small-2 columns -->
								<div class="small-8 columns">
									<input type="tel" name="tel" id="tel" value="0<?php echo escape($user->data()->phone); ?>"/>
								</div><!-- class small-10 columns -->
							</div><!-- class row -->
						</div><!-- class small-12 columns -->

						<!-- EMAIL -->
						<div class="small-12 columns">
							<div class="row">
								<div class="small-4 columns">
									<label for="email" class="right inline"> Email : </label>
								</div><!-- class small-2 columns -->
								<div class="small-8 columns">
									<input type="email" name="email" id="email" value="<?php echo escape($user->data()->email); ?>"/>
								</div><!-- class small-10 columns -->
							</div><!-- class row -->
						</div><!-- class small-12 columns -->

						<!-- UPDATE -->
						<div class="row">
							<div class="small-12 columns text-center">
								<button class="button radius" type="submit" value="<?php echo $user->data()->id; ?>" > Update </button>
							</div><!-- class small-12 columns text-center -->
						</div><!-- class row -->

					</form>
				</div><!-- class panel -->
			</div>
		</div><!-- class tab content -->
	</div>
</div>

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
<script src="js/pickadate.js-3.5.5/lib/picker.js"></script>
<script src="js/pickadate.js-3.5.5/lib/picker.date.js"></script>
<script src="js/pickadate.js-3.5.5/lib/legacy.js"></script>
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
	var token;
	$(".passwordForm").on("submit", function(){
		var jqxhr = generateToken();
		jqxhr.done(function(){
			$.post("response.php", {action: "tokenCheck", token: token}, function(data){
				if(data){
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
								if(data[0]){
									$(".flash").html("Le mot de passe a été modifié !");
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
				}
			});
});
return false;
});

$(".infoForm").on("submit", function(){
	var jqxhr = generateToken();
	jqxhr.done(function(){
		$.post("response.php", {action: "tokenCheck", token: token}, function(data){
			if(data){
				var $fields = $(".infoForm input");
				var isValid;
				$fields.each(function() {
					if (!$.trim($(this).val())) {
						isValid = false;
					}
				});
				if(isValid != false){
					var data = {
						"action": "changeInfo",
						"table": "users",
						"id": $(".infoForm :button[type=submit]").val()
					};
					data = $(".infoForm").serialize() + "&" + $.param(data);
					$.post("response.php", data, function(data){
						if(data[0]){
							$(".flash").html("Vos informations on été modifiés !");
							type = "success"
						}else{
							$(".flash").html("");
							for(i = 0; i < data[1].length; i++){
								$(".flash").append(data[1][i]+"</br>");
							}
							type = "alert";
						}
						$("#mainAlert4").toggleClass("hide success alert", false);
						$("#mainAlert4").toggleClass(type, true)
						clearTimeout(toId);
						toId = setTimeout(function() {
							$("#mainAlert4").toggleClass("hide", true)
						}, 2000);
					}, "json");
				}
			}
		}, "json");
});
return false;
});

function generateToken(){
	return $.post("response.php", {action: "tokenGenerate"}, function(data){setToken(data);}, "json");
}
function setToken(data){
	token = data;
}
// Pickadate
var $input = $('.datepicker').pickadate({
	formatSubmit: 'dd/mm/yyyy',
	format: 'dd/mm/yyyy',
	min: true,
	max: +60,
	monthsFull: ['Janvier', 'Février', 'Mars', 'Avril', 'Mai', 'Juin', 'Juillet', 'Août', 'Septembre', 'Octobre', 'Novembre', 'Décembre'],
	weekdaysShort: ['Dim', 'Lun', 'Mar', 'Mer', 'Jeu', 'Ven', 'Sam'],
	today: 'aujourd\'hui',
	clear: 'effacer',
});

	// Use the picker object directly.
	var picker = $input.pickadate('picker');
	

	picker.on({
		open: function(){
			$.post("response.php", {action: "reservation", type: "date"}, function(data){
				picker.set('disable', data);
			}, "json");
			
		}
	});
	var step;
	$(".datepicker").on("change", function(){
		$.post("response.php", {action: "reservation", type: "hours", date: picker.get()}, function(data){
			$("#panel11").removeClass("active");
			$("a[href='#panel11']").parent(".tab-title").removeClass("active");
			$("a[href='#panel11']").html("<i class='fa fa-calendar'></i> Date</br>"+picker.get());
			$("#panel12").addClass("active");
			$("a[href='#panel12']").parent(".tab-title").addClass("active");
			$(".time-display").html("");
			for(i = 0; i < data.length; i++){
				$(".time-display").append("<button class='time button' value="+data[i][0]+">"+data[i][2]+"H"+data[i][3]+"</button> ");
			}
		}, "json");
	});

	$("a[href=#panel11]").on("click", function(){
		$("#panel11").trigger("active");
	});

	$(document).on('open.fndtn.reveal', '#ResaModal', function () {
		picker.open();
	});

	$("#panel11").on("active", function(){
		picker.open();
	});
	var time;
	$(".time-display").on("click", '.time', function(){
		$("#panel12").removeClass("active");
		$("a[href='#panel12']").parent(".tab-title").removeClass("active");
		$("a[href='#panel12']").html("<i class='fa fa-clock-o'></i> Créneaux </br>"+$(this).html());
		$("#panel13").addClass("active");
		$("a[href='#panel13']").parent(".tab-title").addClass("active");
		time = $(this).val();
		$.post("response.php", {action: "reservation", type: "seats", date: picker.get(), time: $(this).val()}, function(data){
			$(".seat-display").html("");
			for(i = 1; i <= data && i <= 8; i++){
				$(".seat-display").append("<button class='seat button' value="+i+">"+i+" <i class='fa fa-user' ></i></button> ");
			}
		}, "json");
	});
	var seats;
	$(".seat-display").on("click", '.seat', function(){
		$("#panel13").removeClass("active");
		$("a[href='#panel13']").parent(".tab-title").removeClass("active");
		$("a[href='#panel13']").html("<i class='fa fa-users'></i> Personnes </br>"+$(this).val());
		$("#panel14").addClass("active");
		$("a[href='#panel14']").parent(".tab-title").addClass("active");
		seats = $(this).val();
	});
	var toId;
	$("#ResaForm").on("submit", function(){
		if($("#ResaForm input[name=conditions]").is(":checked")){
			var data = {action: "reservation", type: "validation", date: picker.get(), time: time, seats: seats, client_id: <?php echo ($user->isLoggedIn()) ? $user->data()->id : "undefined"; ?>}
			data = $(this).serialize() + "&" + $.param(data);
			console.log(data);
			$.ajax({
				type: "POST",
				dataType: "json",
				url: "response.php",
				data: data,
				success: function(data) {
					if(data){
						$(".flash").html("Votre réservation a été enregistrée !");
						type = "success"
						location.reload();
					}else{
						$(".flash").html("Il y a eu une erreur lors de la réservation !");
						type = "alert"
					}
				}
			});
		}else{
			$(".flash").html("Vous devez accepter les conditions d'utilisation !");
			type = "alert"
		}
		$("#mainAlert4").toggleClass("hide success alert", false);
		$("#mainAlert4").toggleClass(type, true)
		clearTimeout(toId);
		toId = setTimeout(function() {
			$("#mainAlert4").toggleClass("hide", true)
		}, 3000);
		return false;
	});
$( document ).ajaxSend(function(){
	$(".loading").addClass("hide");
})
$( document ).ajaxComplete(function(){
	$(".loading").removeClass("hide");
})
</script>
</section><!-- class main-section -->
<a class="exit-off-canvas"></a>
</div><!-- class inner-wrap -->
</div><!-- class off-canvas-wrap -->
</body>
</html>