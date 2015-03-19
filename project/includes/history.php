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
	<h2 class="subheader text-center titletable"> Historique des réservations </h2>
	<div class="large-12 large-centered column">
		<table id="tablehistorique" class="row-border hover table" cellspacing="0" width="100%">
			<thead>
				<tr>
					<th> ID </th>
					<th> Nom de la réservation </th>
					<th> Nombre de personnes </th>
					<th> Date </th>
					<th> Heure </th>
				</tr>
			</thead>

			<tfoot>
				<tr>
					<th> ID </th>
					<th> Nom de la réservation </th>
					<th> Nombre de personnes </th>
					<th> Date </th>
					<th> Heure </th>
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
<script src="js/pickadate.js-3.5.5/lib/picker.js"></script>
<script src="js/pickadate.js-3.5.5/lib/picker.date.js"></script>
<script src="js/pickadate.js-3.5.5/lib/legacy.js"></script>
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
</script>
</section><!-- class main-section -->
<a class="exit-off-canvas"></a>
</div><!-- class inner-wrap -->
</div><!-- class off-canvas-wrap -->
</body>
</html>