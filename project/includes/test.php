<!DOCTYPE html>
<html>
<head>
	<title>test</title>
	<meta charset="utf-8">
	<meta name = "viewport" content = "width = device-width, initial-scale = 1, user-scalable = yes">
	<link rel="stylesheet" href="css/foundation-datepicker.css">
	<!-- INCLUDE FOUNDATION CSS -->
	<link rel="stylesheet" href="css/foundation.css">
	<!-- INCLUDE PICKADATE CSS -->
	<link rel="stylesheet" href="js/pickadate.js-3.5.5/lib/themes/default.css">
	<link rel="stylesheet" href="js/pickadate.js-3.5.5/lib/themes/default.date.css">
	<!-- INCLUDE CUSTOM CSS -->
	<!-- INCLUDE FONT AWESOME CSS -->
	<link rel="stylesheet" href="assets/font-awesome-4.2.0/css/font-awesome.min.css">
	<!-- INCLUDE DATATABLES CSS -->
	<link rel="stylesheet" type="text/css" href="assets/DataTables-1.10.4/media/css/jquery.dataTables.css">
	<!-- INCLUDE FAVICON -->
	<link rel="icon" href="assets/img/favicon.ico" />
	<!-- INCLUDE MODERNIZR.JS -->
	<script src="js/vendor/modernizr.js"></script>
	<!-- INCLUDE JQUERY -->
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
	<script>window.jQuery || document.write('<script src="js/vendor/jquery.js"><\/script>')</script>  
	<!-- INCLUDE DATATABLES JS -->
	<script type="text/javascript" charset="utf8" src="assets/DataTables-1.10.4/media/js/jquery.dataTables.min.js"></script>
	<script type="text/javascript" charset="utf8" src="js/foundation-datepicker.js"></script>
</head>
<body>







<a href="#" data-reveal-id="modal">Ouvrir</a>
<div id="modal" class="reveal-modal medium" data-reveal>
	<div class="row">
	<button class="button datepicker">open</button>
</div>
</div>




<script src="js/pickadate.js-3.5.5/lib/picker.js"></script>
<script src="js/pickadate.js-3.5.5/lib/picker.date.js"></script>
<script src="js/pickadate.js-3.5.5/lib/legacy.js"></script>
<script src="js/pickadate.js-3.5.5/lib/picker.time.js"></script>
<script src="js/index.js"></script>
<script src="js/vendor/fastclick.js"></script>
<script src="js/foundation.min.js"></script>

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
	// Pickadate
     var $input = $('.datepicker').pickadate({
     	container: "#modal",
     	klass:{

     	}
     })

// Use the picker object directly.
var picker = $input.pickadate('picker')
$("#modal").on("open", function(){

});


</script>

</body>
</html>
