<?php
include_once "../core/init.php";
$user = new user();
if(!$user->isLoggedIn()){
	redirect::to('index.php');
}
include_once "head.php";
$db = db::getInstance();
$bdd = $db->getPDO();
?>

<!-- Table historique -->
<div class="row">
	<h2 class="subheader text-center"> Historique des reservations </h2>
	<div class="large-12 large-centered column">
		<table id="tablehistorique" class="row-border hover table" cellspacing="0" width="100%">
			<thead>
				<tr>
					<th>ID</th>
					<th>Nom de la réservation</th>
					<th>Nombre de personne</th>
					<th>Date</th>
					<th>Heure</th>
				</tr>
			</thead>

			<tfoot>
				<tr>
					<th>ID</th>
					<th>Nom de la réservation</th>
					<th>Nombre de personne</th>
					<th>Date</th>
					<th>Heure</th>
				</tr>
			</tfoot>
			<tbody>

			</tbody>
		</table>
	</div>
</div>
<!-- Fin tables historique -->

<div class="row">
	<div class="small-12 columns">
		<p class="text-center"> ©Le Restaurant 2014 </p>
	</div><!-- class small-12 columns -->
</div><!-- class row -->
<!-- BACK TO TOP BUTTON -->
<div class="small-1 columns" id="back-top">
	<a href="#top" class="button info"><i class="fa fa-arrow-up fa-2x"></i></a>
</div><!-- class small-2 columns -->
<script src="js/index.js"></script>
<script src="js/vendor/fastclick.js"></script>
<script src="js/foundation.min.js"></script>
<script>
$(document).foundation();
// Script pour table historique
var tablehistorique = $("#tablehistorique").DataTable({
	"columnDefs": [
	{ className: "dt-body-center", "targets": "_all" },
	{ "name": "reservation.id",   "targets": 0 },
	{ "name": "users.lastname",   "targets": 1 },
	{ "name": "reservation.nbPerson",   "targets": 2 },
	{ "name": "reservation.dateResa",   "targets": 3 },
	{ "name": "reservation.schedule",   "targets": 4 }
	],
	"language": {
		"url": "assets/lang/french.json"
	},
	"bFilter": true,
	"iDisplayLength": 5,
	"bLengthChange": true,
	"bPaginate": true,
	"serverSide": true,
	"processing": true,
	"ajax" : {
		"type": "POST",
		"dataType": "json",
		"url": "response.php",
		"data": { action: "display", table: "history", id: <?php echo $user->data()->id; ?>}
	}
});
function decodeHtml(html) {
	var txt = document.createElement("textarea");
	txt.innerHTML = html;
	return txt.value;
}

 // fin script table historique

		</script>
	</section><!-- class main-section -->
	<a class="exit-off-canvas"></a>
</div><!-- class inner-wrap -->
</div><!-- class off-canvas-wrap -->
</body>
</html>