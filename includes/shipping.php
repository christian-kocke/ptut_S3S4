<?php
include_once '../core/init.php';
$user = new user();
include_once 'head.php';
?>
<div class="row uncollapse">
	<div class="large-6 column">
	<div class="panel">
		<h4 class="text-center">Shipping details</h4>
			<form action="">
			<div class="large-12 column">
				<div class="large-2 column">
					<label for="mr">Mr.</label>
					<input type="radio" name="gender" id="mr">
				</div>
				<div class="large-2 column end">
					<label for="ms">Ms.</label>
					<input type="radio" name="gender" id="ms">
				</div>
			</div>
			<label for="firstname">Firstname</label>
			<input type="text" name="firstanme" id="firstname">
			<label for="lastname">Lastname</label>
			<input type="text" name="lastname" id="lastname">
			<label for="phone">Phone number</label>
			<input type="tel" name="phone">
			<label for="email">Email adress</label>
			<input type="email" name="email">
			<label for="adress">Adress</label>
			<input type="text" name="adresse">
			<label for="country">Choose your country</label>
			<select name="country" id="country">
			  <option value="france">France</option>
			  <option value="germany">Germany</option>
			  <option value="italy">Italy</option>
			  <option value="spain">Spain</option>
			</select>
		</form>
	</div>
	</div>
	<div class="large-6 column">
		<div class="panel">
			<h4 class="text-center">Payement details</h4>
			<form action="">
				<div class="large-4 column">
					<div class="large-2 column">
						<label for="visa" class="right inline"><i class="fa fa-cc-visa fa-3x"></i> </label>
					</div>
					<div class="large-6 column">
						<input type="radio" id="visa" name="card" value="visa">
					</div>
				</div>
				<div class="large-4 column">
					<div class="large-2 column">
						<label for="master" class="right inline"><i class="fa fa-cc-mastercard fa-3x"></i></label>
					</div>
					<div class="large-6 column">
						<input type="radio" id="master" name="card" value="master">
					</div>
				</div>
				<div class="large-4 column">
					<div class="large-2 column">
						<label for="american" class="right inline"><i class="fa fa-cc-amex fa-3x"></i></label>
					</div>
					<div class="large-6 column">
						<input type="radio" id="american" name="card" value="america">
					</div>
				</div>
				<label for="">Name</label>
				<input type="text">
				<label for="">Card number</label>
				<input type="text">
				<label for="">Expiration date</label>
				<input type="date">
			</form>
		</div>
	</div>
	<div class="large-12 column text-center"><button data-reveal-id="myModal">Validate</button></div>
</div>

<div id="myModal" class="reveal-modal" data-reveal>
  <h2>This service is currently under maintenance. Please come back later</h2>
  <a class="close-reveal-modal">&#215;</a>
</div>
<footer>
		<script src="js/vendor/fastclick.js"></script>
		<script src="js/foundation.min.js"></script>
		<script>
			$(document).foundation();
		</script>
	</footer>
</body>
</html>