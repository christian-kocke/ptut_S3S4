<?php
include_once('../core/init.php');
$user = new user();
if(!$user->hasPermission("admin")){
	redirect::to("index.php");
}
include_once 'head.php';
?>
<div id="mainAlert4" data-alert class="alert-box success hide large-7 medium-6 small-5 large-centred medium-centered small-centered column text-center" tabindex="0" aria-live="assertive" role="dialogalert">
	<p class="flash"></p>
	<button href="#" tabindex="0" class="close" aria-label="Close Alert">&times;</button>
</div>
<head>
	<title> Control Panel </title>
</head>
<body>
	<div class="row">
		<h2 class="subheader text-center titletable"> Gestion des utilisateurs </h2>
		<div class="large-12 large-centered column">
			<table id="table" class="row-border hover table display" cellspacing="0" width="100%">
				<thead>
					<tr>
						<th> ID </th>
						<th> Pseudo </th>
						<th> Prénom </th>
						<th> Nom </th>
						<th> Téléphone </th>
						<th> Email </th>
						<th> Date d'enregistrement </th>
						<th> Groupe </th>
						<th> Action </th>
					</tr> 
				</thead>

				<tfoot>
					<tr>
						<th>ID</th>
						<th>Pseudo</th>
						<th>Prénom</th>
						<th>Nom</th>
						<th>Téléphone</th>
						<th>Email</th>
						<th>Date d'enregistrement</th>
						<th>Groupe</th>
						<th>Action</th>
					</tr>
				</tfoot>

				<tbody>

				</tbody>
			</table>
		</div>
	</div>
	<div id="confirmModal" class="reveal-modal small" data-reveal>
	</div>
	<footer>
		<div class="row">
			<div class="small-12 columns">
				<p class="text-center"> ©Le Restaurant 2014 </p>
			</div><!-- class small-12 columns -->
			<!-- BACK TO TOP BUTTON -->
			<div class="small-1 columns" id="back-top">
				<a href="#top" class="button info"><i class="fa fa-arrow-up fa-2x"></i></a>
			</div><!-- class small-2 columns -->
		</div><!-- class row -->
		<script src="js/index.js"></script>
		<script src="js/vendor/fastclick.js"></script>
		<script src="js/foundation.min.js"></script>
		<script>
			$(document).foundation();
			var toId;
			var table = $("#table").DataTable({
				"columnDefs": [
				{ className: "dt-body-center", "targets": "_all" },
				{ "searchable": false, "targets": [8]},
				{ "name": "id",   "targets": 0 },
				{ "name": "username",   "targets": 1 },
				{ "name": "firstname",   "targets": 2 },
				{ "name": "lastname",   "targets": 3 },
				{ "name": "phone",   "targets": 4 },
				{ "name": "email",   "targets": 5 },
				{ "name": "joined",   "targets": 6 },
				{ "name": "user_group",   "targets": 7 }
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
					"data": { action : "display", "table": "users"}
				}
			});

			$('#table tbody').on( 'click', 'td', function () {
				var id = table.row(table.cell(this).index().row).data()[0];
				var cellData = table.cell( this ).data();
				var cell = table.cell(this).node();
				var headers = ["id", "username", "firstname", "lastname", "phone", "email", "joined", "user_group"];
				if(jQuery.inArray($(cell).index(), [0, 6, 8]) === -1){
					$(cell).html("<input type='text' value='' name='update'/>");
					$(cell).children().val(cellData);
					var $input = $(cell).find('input');
					$input.focus();
					$input.on("change", function(){
						var data = {
							"action": "update",
							"table": "users",
							"id": id,
							"header": headers[$(cell).index()],
							"value": $(this).val()
						};
						data = $.param(data);
						console.log(data);
						$.ajax({
							type: "POST",
							dataType: "json",
							url: "response.php", 
							data: data,
							success: function(data) {
								if(data){
									$(".flash").html("Modification réussie !");
									type = "success"
									table.draw();
								}else{
									$(".flash").html("Erreur lors de la modification");
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
						return false;
					});
					$input.on("focusout", function(){
						$(this).parent().html($(this).val());
					});
				}
			});
var confirm;
$('#table tbody').on('click', '.remove', function () {
	confirm = $.Deferred();
	var data = {
		"action": "delete",
		"table": "users",
		"id": $(this).val()
	};
	data = $.param(data);
	confirm.done(function(){
		$.ajax({
			type: "POST",
			dataType: "json",
			url: "response.php", 
			data: data,
			success: function(data) {
				if(data){
					$(".flash").html("Utilisateur supprimé !");
					type = "success"
					table.draw();
				}else{
					$(".flash").html("Erreur lors de la suppresion");
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
		$('#confirmModal').foundation('reveal', 'close');
	});
	confirm.fail(function(){
		$('#confirmModal').foundation('reveal', 'close');
	});
	$("#confirmModal").foundation("reveal", "open", {
		url: "response.php",
		type: "POST",
		data: {action: "confirm", id: $(this).val(), table: "users", type: "delete"},
		dataFilter: function(data){
			return data.replace(/\"/g, "");
		},
		success: function(){
			var confirm = $.Deferred();
		}
	});
});
$("#confirmModal").on("click", '.confirm', function(){
	confirm.resolve();
});
$("#confirmModal").on("click", '.cancel', function(){
	confirm.reject();
});
</script>
</body>
</html>	
</footer>
<a class="exit-off-canvas"></a>
</div>
</div>
</body>
</html>