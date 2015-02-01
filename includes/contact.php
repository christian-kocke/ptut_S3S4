<?php
require_once '../core/init.php';
$user = new user();
require_once 'head.php';
?>
<div class="row alert-container">
	<div id="mainAlert4" data-alert class="alert-box large-6 large-centered column hide text-center" tabindex="0" aria-live="assertive" role="dialogalert">
		<p class="flash"></p>
	  <button href="#" tabindex="0" class="close" id="close" aria-label="Close Alert">&times;</button>
	</div>
</div>
<div class="row">
	<div class="large-12 column text-center">
		<div class="panel">
			<h4>Send us an email</h4>
			<form action="" method="post" class="emailForm" id="emailForm">
				<div class="row">
					<div class="large-6 column mailInfo">
						<div class="large-3 column">
							<label for="subject" class="right inline">Subject :</label>
						</div>
						<div class="large-9 column">
							<input type="text" id="subject" name="subject" required>
						</div>
						<textarea name="message" id="message" cols="30" rows="10" placeholder="Write yout message here..."></textarea>
					</div>
					<div class="large-6 column mailInfo">
						<div class="large-10 large-centered column">
							<label for="firstname" >Firstname :</label>
							<input type="text" id="firstname" name="firstname" required>
						</div>
						<div class="large-10 large-centered column">
							<label for="lastname">Lastname :</label>
							<input type="text" id="lastname" name="lastname" required>
						</div>
						<div class="large-10 large-centered column">
							<label for="email">Email :</label>
							<input type="email" name="email" id="email" required>
						</div>
						<div class="large-12 column text-center">
							<button class="button" type="submit">send <i class="fa fa-paper-plane-o"></i></button>
						</div>
					</div>
				</div>
			</form>
		</div>
	</div>
	<div class="large-12 column text-center">
		<div class="panel">
		<h4>Other contact information</h4>
			<div class="row">
				<div class="large-12 column">
					<p><strong>Adress : </strong> 19 rue château Gaillard, 69100 Villeurbanne, France</p>
				</div>
				<div class="large-12 column">
					<p><strong>Tel : </strong> 06 34 48 46 67</p>
				</div>
				<div class="large-12 column">
					<div class="fluid_wrapper">
						<iframe src="https://mapsengine.google.com/map/embed?mid=zYBsu2h46u7w.kKobWK1TdmZo" width="100%" height="340"></iframe>
					</div>
				</div>
			</div>
		</div>
	</div>		
</div>
<footer>
		<script src="js/vendor/fastclick.js"></script>
		<script src="js/foundation.min.js"></script>
		<script>
			$(document).foundation();
			$(document).ready(function() {
				var toId;
				$(".emailForm").submit(function() {
				    var data = {
				      "action": "email"
				    };
				    data = $(this).serialize() + "&" + $.param(data);
				    $.ajax({
				      type: "POST",
				      dataType: "json",
				      url: "response.php",
				      data: data,
				      success: function(data) {
				      	var type;
				      	if(data == true){
				      		$(".flash").html("Your email has been sent");
				      		type = "success"
				      	}else{
				      		$(".flash").html("An error occured while sending your email");
				      		type = "alert"
				      	}
				      	$("#mainAlert4").toggleClass("hide success alert", false);
				      	$("#mainAlert4").toggleClass(type, true)
				      	clearTimeout(toId);
					  	toId = setTimeout(function() {
					  		$("#mainAlert4").toggleClass("hide", true)
					  	}, 3000);
					  	document.getElementById("emailForm").reset();
				      }
				    });
				    return false;
				});
			});
		</script>
	</footer>
</body>
</html>