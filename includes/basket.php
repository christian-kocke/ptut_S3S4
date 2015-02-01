<?php
include_once '../core/init.php';
$user = new user();


include_once 'head.php';
?>
		<div class="row alert-container">
			<div id="mainAlert1" data-alert class="alert-box large-6 large-centered column hide text-center alert" tabindex="0" aria-live="assertive" role="dialogalert">
				<p class="flash"></p>
			  <button href="#" tabindex="0" class="close" id="close" aria-label="Close Alert">&times;</button>
			</div>
		</div>		
		<div class="row">
			<div class="large-12 large-centered column">
				<table id="table" class="row-border hover table" cellspacing="0" width="100%">
			        <thead>
			            <tr>
			                <th>Product Name</th>
		   					<th>Price (Euro)</th>
		   					<th>Quantity</th>
		   					<th></th>
		            	</tr>
			        </thead>
			 
			        <tfoot>
			            <tr>
			                <th>Product Name</th>
		   					<th>Price (Euro)</th>
		   					<th>Quantity</th>
		   					<th></th>
			            </tr>
			        </tfoot>
			 
			        <tbody>
	
			        </tbody>
				</table>
			</div>
		</div>
		<div class="row order">
			<div class="large-12 large-centered column text-center">
				<div class="total"></div>
				<a href="shipping.php"><button class='button'>Order</button></a>
			</div>
		</div>
		<footer>
		<script src="js/vendor/fastclick.js"></script>
		<script src="js/foundation.min.js"></script>
		<script>
		$(document).ready(function(){

			$(document).foundation();

			var table = $("#table").DataTable({
		        "columnDefs": [
			    	{ className: "dt-body-center", "targets": [ 2, 3 ] }
			  	],
			  	"oLanguage": {
					"sEmptyTable": "Your basket is empty",
			    	"sInfo": "You have _TOTAL_ item(s) in your basket (from _START_ to _END_)",
			    	"sLengthMenu": 'Show <select>'+
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
		            "data": { action : "basket_display" }
		        }
			});

			$("#table tbody").on("change", ".quantity", function(){
			    var data = {
			      "action": "update"
			    };
			    data = $(this).serialize() + "&" + $.param(data);
			    $.ajax({
			      type: "POST",
			      dataType: "json",
			      url: "response.php", 
			      data: data,
			      success: function() {
			      	$(".total").load("response.php", {"action" : "bill"}, function(responseText){
						$(this).html(responseText.replace(/\"/g, ""));
					});
			      }
			    });
			    return false;
			});
			var toId;
			$("#table tbody").on("submit", ".removeForm", function(){
				$(this).parent().parent().hide();
			    var data = {
			      "action": "display"
			    };
			    data = $(this).serialize() + "&" + $.param(data);
			    $.ajax({
			      type: "POST",
			      dataType: "json",
			      url: "response.php", //Relative or absolute path to response.php file
			      data: data,
			      success: function(data) {
			      	table.ajax.reload();
				  	$("#mainAlert1").toggleClass("hide", false);
				  	clearTimeout(toId);
				  	toId = setTimeout(function() {
				  		$("#mainAlert1").toggleClass("hide", true)
				  	}, 3000);
				  	$(".flash").html(data['msg']);
				  	$(".basket-display").html(data['basket']);
			      	$(".total").load("response.php", {"action" : "bill"}, function(responseText){
						$(this).html(responseText.replace(/\"/g, ""));
					});
			      }
			    });
			    return false;
			});

			$(".total").load("response.php", {"action" : "bill"}, function(responseText){
				$(this).html(responseText.replace(/\"/g, ""));
			});

			$('.close').bind("click", function(){
		    	var c = confirm("If you proceed you will no longer recieve any notification concerning your actions on this page unless you refresh your browser");
		        if(!c){
		            return false;
		        }
		    });
		});
		</script>
	</footer>
</body>
</html>