<?php
include_once "../core/init.php";
$user = new user();

include_once "head.php";
$db = db::getInstance();
$bdd = $db->getPDO();
?>



<a href="#" data-reveal-id="modal"> Réservez </a>
<input type="text" class="datepicker" />


<div id="modal" class="reveal-modal medium" data-reveal> </div>

<div id="container"></div>




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
     $('.datepicker').pickadate();

</script>

</body>
</html>