<?php
require_once '../core/init.php';
$user = new user();
require_once 'head.php';
?>
<div class="row">
	<div class="large-12 large-centered column text-center">
		<h1>Our team</h1>
		<p>Our shop has an efficient team that is always ready to answer your every need. You can look at the profiles of our team members below</p>
	</div>
	<div class="large-6 large-centered column text-center">
		<div class="large-6 column">
			<a href="#" class="staff" data-reveal-id="modalChristian"><img src="assets/staff/christian.png" alt="chrisian"/></a>
			<div id="modalChristian" class="reveal-modal large" data-reveal>
				<div class="row">
					<div class="large-3 column">
						<img src="assets/staff/christian.png" alt="chrisian" class="left"/>
					</div>
				  	<div class="large-9 column">
				  		<h2>Christian Köcke</h2>
				  		<p>I am the founder and CEO of The Wooden Pipe Store®, My hobbies are basketball and going to the movies.</p>
				  	</div>
				</div>
				<a class="close-reveal-modal">&#215;</a>
			</div>
		</div>
		<div class="large-6 column"><a href="#" class="staff" data-reveal-id="modalTheo"><img src="assets/staff/photo_theo.jpg" alt="theo"/></a>
			<div id="modalTheo" class="reveal-modal" data-reveal>
			  <div class="row">
					<div class="large-3 column">
						<img src="assets/staff/photo_theo.jpg" alt="chrisian" class="left"/>
					</div>
				  	<div class="large-9 column">
				  		<h2>Théo Foucher</h2>
				  		<p>I am the co-founder and manager at the The Wooden Pipe Store®, My hobbies are playing badmington and watching TV.</p>
				  	</div>
				</div>
				<a class="close-reveal-modal">&#215;</a>
			</div>
		</div>
	</div>
</div>

<?php
include_once 'footer.php';
?>
