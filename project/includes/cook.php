<?php
include_once "../core/init.php";
$user = new user();
if(!$user->hasPermission("cook")){
	redirect::to('index.php');
}
include_once "head.php";
$db = db::getInstance();
$bdd = $db->getPDO();
?>
<div class="row">
	<div class="large-5 large-centered column">
		<ul class="tabs t3" data-tab>
			<li class="tab-title active"><a href="#panel1">Entrée</a></li>
			<li class="tab-title"><a href="#panel2">Plat</a></li>
			<li class="tab-title"><a href="#panel3">Dessert</a></li>
		</ul>
	</div>
</div>	
<div class="tabs-content">
	<div class="content active" id="panel1">
		<!-- Table entré -->
		<div class="row">
			<h2 class="subheader text-center titletable"> Entrée </h2>
			<div class="large-12 large-centered column">
				<table id="tableentree" class="row-border hover table" cellspacing="0" width="100%" name="entree">
					<thead>
						<tr>
							<th>ID</th>
							<th>Nom</th>
							<th>Ingrédients</th>
							<th>Prix</th>
							<th>Disponible</th>
							<th>Action</th>
						</tr>
					</thead>

					<tfoot>
						<tr>
							<th>ID</th>
							<th>Nom</th>
							<th>Ingrédients</th>
							<th>Prix</th>
							<th>Disponible</th>
							<th>Action</th>
						</tr>
					</tfoot>
					<tbody>

					</tbody>
				</table>
				<button class="button success tiny" id="buttonentree" type=submit name=add1 ><i class='fa fa-plus fa-lg'></i></button>
			</div>
		</div>
		<!-- Fin tables entréé -->
	</div>
	<div class="content" id="panel2">
		<!-- Table plat -->
		<div class="row">
			<h2 class="subheader text-center titletable"> Plat </h2>
			<div class="large-12 large-centered column">
				<table id="tableplat" class="row-border hover table" cellspacing="0" width="100%" name="plat">
					<thead>
						<tr>
							<th>ID</th>
							<th>Nom</th>
							<th>Ingrédients</th>
							<th>Prix</th>
							<th>Disponible</th>
							<th>Action</th>
						</tr>
					</thead>

					<tfoot>
						<tr>
							<th>ID</th>
							<th>Nom</th>
							<th>Ingrédients</th>
							<th>Prix</th>
							<th>Disponible</th>
							<th>Action</th>
						</tr>
					</tfoot>
					<tbody>

					</tbody>
				</table>
				<button class="button success tiny" id="buttonplat" type=submit name=add1 ><i class='fa fa-plus fa-lg'></i></button>
			</div>
		</div>

		<!-- fin table plat-->
	</div>
	<div class="content" id="panel3">
		<!-- Table dessert -->
		<div class="row">
			<h2 class="subheader text-center titletable"> Dessert </h2>
			<div class="large-12 large-centered column">
				<table id="tabledessert" class="row-border hover table" cellspacing="0" width="100%" name="dessert">
					<thead>
						<tr>
							<th>ID</th>
							<th>Nom</th>
							<th>Ingrédients</th>
							<th>Prix</th>
							<th>Disponible</th>
							<th>Action</th>
						</tr>
					</thead>

					<tfoot>
						<tr>
							<th>ID</th>
							<th>Nom</th>
							<th>Ingrédients</th>
							<th>Prix</th>
							<th>Disponible</th>
							<th>Action</th>
						</tr>
					</tfoot>
					<tbody>

					</tbody>
				</table>
				<button class="button success tiny" id="buttondessert" type=submit name=add1 ><i class='fa fa-plus fa-lg'></i></button>
			</div>
		</div>

		<!-- fin table dessert-->
	</div>

</div>
<!-- notification alert -->
<div id="confirmModal" class="reveal-modal small" data-reveal></div>
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

// Script pour table entrée
var tableentree = $("#tableentree").DataTable({
	"columnDefs": [
	{ className: "dt-body-center", "targets": "_all" },
	{ "name": "id",   "targets": 0 },
	{ "name": "nom",   "targets": 1 },
	{ "name": "ingredient",   "targets": 2 },
	{ "name": "prix",   "targets": 3 },
	{ "name": "disponible",   "targets": 4 }
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
		"data": { action : "display", table :"entree" }
	}
});
function decodeHtml(html) {
	var txt = document.createElement("textarea");
	txt.innerHTML = html;
	return txt.value;
}
$('#tableentree tbody').on( 'click', 'td', function () {
	var id = tableentree.row(tableentree.cell(this).index().row).data()[0];
	var cellData = tableentree.cell(this).data();
	var cell = tableentree.cell(this).node();
	var headers = ["id", "nom", "ingredient", "prix", "disponible"];
	if($(cell).children().val()=='on'){
		$val = (($(cell).children().is(":checked")) ? 1 : 0); 
		var data = {
			"action": "update",
			"table": "entree",
			"id": id,
			"header": headers[$(cell).index()],
			"value": $val
		};
		data = $.param(data);
		$.ajax({
			type: "POST",
			dataType: "json",
			url: "response.php", 
			data: data,
			success: function(data) {
				if(data){
					tableentree.draw();
				}else{
					alert("error");
				}
			}
		});
	}
	if(jQuery.inArray($(cell).index(), [0,4,5]) === -1){
		$(cell).html("<input type='text' value='' name='test'/>");
		$(cell).children().val(decodeHtml(cellData));
		var $input = $(cell).find('input');
		$input.focus();
		$input.on("change", function(){
			var data = {
				"action": "update",
				"table": "entree",
				"id": id,
				"header": headers[$(cell).index()],
				"value": $(this).val()
			};
			data = $.param(data);
			$.ajax({
				type: "POST",
				dataType: "json",
				url: "response.php", 
				data: data,
				success: function(data) {
					if(data){
						tableentree.draw();
					}else{
						alert("error");
					}
				}
			});
			return false;
		});
		$input.on("focusout", function(){
			$(this).parent().html($(this).val());
		});
	}
});


$('#buttonentree').on('click', function () {
	var data = {
		"action": "insert",
		"table": "entree"
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
				tableentree.draw();
			}else{
				alert("error");
			}
		}
	});
	return false;
});
 // fin script table entrée

 //script table plat 

 var tableplat = $("#tableplat").DataTable({
 	"columnDefs": [
 	{ className: "dt-body-center", "targets": "_all" },
 	{ "name": "id",   "targets": 0 },
 	{ "name": "nom",   "targets": 1 },
 	{ "name": "ingredient",   "targets": 2 },
 	{ "name": "prix",   "targets": 3 },
 	{ "name": "disponible",   "targets": 4 }
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
 		"data": { action : "display", table :"plat" }
 	}
 });
 function decodeHtml(html) {
 	var txt = document.createElement("textarea");
 	txt.innerHTML = html;
 	return txt.value;
 }
 $('#tableplat tbody').on( 'click', 'td', function () {
 	var id = tableplat.row(tableplat.cell(this).index().row).data()[0];
 	var cellData = tableplat.cell(this).data();
 	var cell = tableplat.cell(this).node();
 	var headers = ["id", "nom", "ingredient", "prix", "disponible"];
 	if($(cell).children().val()=='on'){
 		$val = (($(cell).children().is(":checked")) ? 1 : 0); 
 		var data = {
 			"action": "update",
 			"table": "plat",
 			"id": id,
 			"header": headers[$(cell).index()],
 			"value": $val
 		};
 		data = $.param(data);
 		$.ajax({
 			type: "POST",
 			dataType: "json",
 			url: "response.php", 
 			data: data,
 			success: function(data) {
 				if(data){
 					tableplat.draw();
 				}else{
 					alert("error");
 				}
 			}
 		});
 	}
 	if(jQuery.inArray($(cell).index(), [0,4,5]) === -1){
 		$(cell).html("<input type='text' value='' name='test'/>");
 		$(cell).children().val(decodeHtml(cellData));
 		var $input = $(cell).find('input');
 		$input.focus();
 		$input.on("change", function(){
 			var data = {
 				"action": "update",
 				"table": "plat",
 				"id": id,
 				"header": headers[$(cell).index()],
 				"value": $(this).val()
 			};
 			data = $.param(data);
 			$.ajax({
 				type: "POST",
 				dataType: "json",
 				url: "response.php", 
 				data: data,
 				success: function(data) {
 					if(data){
 						tableplat.draw();
 					}else{
 						alert("error");
 					}
 				}
 			});
 			return false;
 		});
 		$input.on("focusout", function(){
 			$(this).parent().html($(this).val());
 		});
 	}
 });

$('#buttonplat').on('click', function () {
	var data = {
		"action": "insert",
		"table": "plat"
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
				tableplat.draw();
			}else{
				alert("error");
			}
		}
	});
	return false;
});

// fin script table plat

 //script table desert 

 var tabledessert = $("#tabledessert").DataTable({
 	"columnDefs": [
 	{ className: "dt-body-center", "targets": "_all" },
 	{ "name": "id",   "targets": 0 },
 	{ "name": "nom",   "targets": 1 },
 	{ "name": "ingredient",   "targets": 2 },
 	{ "name": "prix",   "targets": 3 },
 	{ "name": "disponible",   "targets": 4 }
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
 		"data": { action : "display", table :"dessert" }
 	}
 });
 function decodeHtml(html) {
 	var txt = document.createElement("textarea");
 	txt.innerHTML = html;
 	return txt.value;
 }
 $('#tabledessert tbody').on( 'click', 'td', function () {
 	var id = tabledessert.row(tabledessert.cell(this).index().row).data()[0];
 	var cellData = tabledessert.cell(this).data();
 	var cell = tabledessert.cell(this).node();
 	var headers = ["id", "nom", "ingredient", "prix", "disponible"];
 	if($(cell).children().val()=='on'){
 		$val = (($(cell).children().is(":checked")) ? 1 : 0); 
 		var data = {
 			"action": "update",
 			"table": "dessert",
 			"id": id,
 			"header": headers[$(cell).index()],
 			"value": $val
 		};
 		data = $.param(data);
 		$.ajax({
 			type: "POST",
 			dataType: "json",
 			url: "response.php", 
 			data: data,
 			success: function(data) {
 				if(data){
 					tabledessert.draw();
 				}else{
 					alert("error");
 				}
 			}
 		});
 	}
 	if(jQuery.inArray($(cell).index(), [0,4,5]) === -1){
 		$(cell).html("<input type='text' value='' name='test'/>");
 		$(cell).children().val(decodeHtml(cellData));
 		var $input = $(cell).find('input');
 		$input.focus();
 		$input.on("change", function(){
 			var data = {
 				"action": "update",
 				"table": "dessert",
 				"id": id,
 				"header": headers[$(cell).index()],
 				"value": $(this).val()
 			};
 			data = $.param(data);
 			$.ajax({
 				type: "POST",
 				dataType: "json",
 				url: "response.php", 
 				data: data,
 				success: function(data) {
 					if(data){
 						tabledessert.draw();
 					}else{
 						alert("error");
 					}
 				}
 			});
 			return false;
 		});
 		$input.on("focusout", function(){
 			$(this).parent().html($(this).val());
 		});
 	}
 });


$('#buttondessert').on('click', function () {
	var data = {
		"action": "insert",
		"table": "dessert"
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
				tabledessert.draw();
			}else{
				alert("error");
			}
		}
	});
	return false;
});

// fin script table desert

// confirm 
var confirm;
$('table tbody').on('click', '.remove', function () {
	console.log($(this).parents("table").attr("name"));
	confirm = $.Deferred();
	var table = $(this).parents("table").DataTable();
	var tableName = $(this).parents("table").attr("name");
	var data = {
		"action": "delete",
		"table": tableName,
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
					
					table.draw();
				}else{
					alert("error");
				}
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
		data: {action: "confirm", id: $(this).val(), table: tableName, type: "delete"},
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
// fin confirm
</script>
</section><!-- class main-section -->
<a class="exit-off-canvas"></a>
</div><!-- class inner-wrap -->
</div><!-- class off-canvas-wrap -->
</body>
</html>
