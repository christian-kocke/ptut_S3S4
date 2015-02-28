<?php
include_once('../core/init.php');
$user = new user();
if(!$user->hasPermission("admin")){
	redirect::to("index.php");
}
include_once 'head.php';
?>
<!DOCTYPE html>
<html>
<head>
	<title>Control Panel</title>
</head>
<body>
	<div class="row">
		<h2 class="subheader text-center"> Gestion des utilisateurs </h2>
		<div class="large-12 large-centered column">
			<table id="table" class="row-border hover table" cellspacing="0" width="100%">
		        <thead>
		            <tr>
		            	<th>ID</th>
		                <th>Pseudo</th>
	   					<th>Prénom</th>
	   					<th>Nom</th>
	   					<th>Téléphone</th>
	   					<th>Email</th>
	   					<th>Groupe</th>
	   					<th>Date enregistrement</th>
	   					<th>Mot de passe</th>
	   					<th>Action</th>
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
	   					<th>Groupe</th>
	   					<th>Date enregistrement</th>
	   					<th>Mot de passe</th>
	   					<th>Action</th>
		            </tr>
		        </tfoot>
		 
		        <tbody>

		        </tbody>
			</table>
		</div>
	</div>
		<footer>
			<div class="row">
				<div class="large-4 large-centered text-center columns">Back to <a href="#top">top</a> ©Le Restaurant 2014</div>
			</div>
			<script src="js/index.js"></script>
			<script src="js/vendor/fastclick.js"></script>
			<script src="js/foundation.min.js"></script>
			<script>
				$(document).foundation();

				var table = $("#table").DataTable({
		        "columnDefs": [
			    	{ className: "dt-body-center", "targets": "_all" }
			  	],
			  	"oLanguage": {
					"sEmptyTable": "Aucun utilisateur enregistrer",
			    	"sInfo": "_TOTAL_ utilisateurs enregistrer (de _START_ à _END_)",
			    	"sLengthMenu": 'Afficher <select>'+
			        '<option value="5">5</option>'+
			        '<option value="10">10</option>'+
			        '<option value="20">20</option>'+
			        '<option value="-1">All</option>'+
			        '</select> '
				},
				"bFilter": false,
				"iDisplayLength": 5,
				"bLengthChange": true,
				"bPaginate": true,
				"serverSide": true,
		        "processing": true,
		        "ajax" : {
		            "type": "POST",
		            "dataType": "json",
		            "url": "response.php",
		            "data": { action : "display_users" }
		        }
			});

			$('#table tbody').on( 'click', 'td', function () {
				var id = table.row(table.cell(this).index().row).data()[0];
				var cellData = table.cell( this ).data();
				var cell = table.cell(this).node();
				var headers = ["id", "username", "firstname", "lastname", "phone", "email", "user_group"];
			  	if(jQuery.inArray($(cell).index(), [0, 7, 8, 9]) === -1){
				  	$(cell).html("<input type='text' value="+cellData+" name='test'/>");
				  	var $input = $(cell).find('input');
				  	$input.focus();
				  	$input.on("change", function(){
				  		var data = {
				      		"action": "update",
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
					      			table.draw();
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

			$('#table tbody').on('click', '.remove', function () {
				var data = {
		      		"action": "delete",
		      		"id": $(this).val()
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
			      			table.draw();
			      		}else{
			      			alert("error");
			      		}
			      	}
		    	});
		    return false;
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