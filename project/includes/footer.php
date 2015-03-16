
<footer>	


	<!-- SOCIAL NETWORKS -->
	<div class="small-12 medium-12 large-12 footerBis columns" data-equalizer>
		
		

		<div class="small-12 medium-12 large-4 columns" data-equalizer-watch>	
			<div class="row collapse prefix-radius">
				<div class="small-2 medium-2 large-2 columns">
					<span class="prefix"><i class="fa fa-envelope-o"></i></span>
				</div><!-- class small-2 medium-2 large-2 columns -->
				<div class="small-8 medium-8 large-8 columns">
					<input type="text" name="email-newsletter" placeholder="Email" />
				</div><!-- class small-8 medium-8 large-8 columns -->
				<div class="small-2 medium-2 large-2 columns">
					<a href="#" class="button postfix"> Go </a>
				</div><!-- class small-2 medium-2 large-2 columns -->
			</div><!-- class row collapse prefix-radius -->
		</div><!-- class small-12 medium-12 large-8 columns -->

		<div class="small-12 medium-12 large-4 columns t2">
			<p class="text-center"> ©Le Restaurant 2014 </p>
		</div><!-- class small-12 medium-12 large-12 columns -->

		<div class="small-12 medium-12 large-4 columns" data-equalizer-watch>
			<!-- FACEBOOK -->
			<div class="small-3 columns">
				<a href=""><span class="fa-stack fa-lg">
					<i class="fa fa-square-o fa-stack-2x"></i>
					<i class="fa fa-facebook fa-stack-1x"></i>
				</span></a>
			</div><!-- class small-3 columns -->

			<!-- TWITTER -->
			<div class="small-3 columns">
				<a href=""><span class="fa-stack fa-lg">
					<i class="fa fa-square-o fa-stack-2x"></i>
					<i class="fa fa-twitter fa-stack-1x"></i>
				</span></a>
			</div><!-- class small-3 columns -->

			<!-- GOOGLE PLUS -->
			<div class="small-3 columns">
				<a href=""><span class="fa-stack fa-lg">
					<i class="fa fa-square-o fa-stack-2x"></i>
					<i class="fa fa-google-plus fa-stack-1x"></i>
				</span></a>
			</div><!-- class small-3 columns -->

			<!-- LINKEDIN -->
			<div class="small-3 columns">
				<a href=""><span class="fa-stack fa-lg">
					<i class="fa fa-square-o fa-stack-2x"></i>
					<i class="fa fa-linkedin fa-stack-1x"></i>
				</span></a>
			</div><!-- class small-3 columns -->
		</div><!-- class small-12 medium-12 large-4 footer Bis columns -->

	</div><!-- small-12 medium-12 large-12 footerBis columns -->
	
</footer>

<!-- BACK TO TOP BUTTON -->
<div class="small-1 columns" id="back-top">
	<a href="#top" class="button info"><i class="fa fa-arrow-up fa-2x"></i></a>
</div><!-- class small-2 columns -->

<script src="js/pickadate.js-3.5.5/lib/picker.js"></script>
<script src="js/pickadate.js-3.5.5/lib/picker.date.js"></script>
<script src="js/pickadate.js-3.5.5/lib/legacy.js"></script>
<script src="js/pickadate.js-3.5.5/lib/picker.time.js"></script>
<script src="//code.jquery.com/ui/1.11.2/jquery-ui.js"></script>
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
	
	// Pickatime
	var $inputTime = $('.timepicker').pickatime({
		interval: 30,
		clear: 'Effacer',
		formatLabel: "H : i"
	});

	picker.on({
		open: function(){
			$.post("response.php", {action: "reservation", type: "date"}, function(data){
				picker.set('disable', data);
			}, "json");
			
		}
	});

	$(".datepicker").on("change", function(){
		$.post("response.php", {action: "reservation", type: "hours", date: picker.get()}, function(data){
			$("#panel1").removeClass("active");
			$("a[href='#panel1']").parent(".tab-title").removeClass("active");
			$("a[href='#panel1']").html("Date</br>"+picker.get());
			$("#panel2").addClass("active");
			$("a[href='#panel2']").parent(".tab-title").addClass("active");
			$(".time-display").html("");
			console.log(data);
			for(i = 0; i < data.length; i++){
				console.log(data[i][0]);
				$(".time-display").append("<button class='time button' value="+data[i][0]+">"+data[i][1]+"</button>");
			}
		}, "json");
	});

	$("a[href=#panel1]").on("click", function(){
		$("#panel1").trigger("active");
	});

	$(document).on('open.fndtn.reveal', '#ResaModal', function () {
		picker.open();
	});

	$("#panel1").on("active", function(){
		picker.open();
	});

	$(".time-display").on("click", '.time', function(){
		$("#panel2").removeClass("active");
		$("a[href='#panel2']").parent(".tab-title").removeClass("active");
		$("a[href='#panel2']").html("Créneaux</br>"+$(this).html());
		$("#panel3").addClass("active");
		$("a[href='#panel3']").parent(".tab-title").addClass("active");
		$.post("response.php", {action: "reservation", type: "seats", date: picker.get(), time: $(this).val()}, function(data){
			$(".seat-display").html("");
			for(i = 1; i <= data && i <= 9; i++){
				$(".seat-display").append("<button class='seat button' value="+i+">"+i+" <i class='fa fa-user' ></i></button>");
			}
		}, "json");
	});
	
	
</script>
</section><!-- class main-section -->
<a class="exit-off-canvas"></a>
</div><!-- class inner-wrap -->
</div><!-- class off-canvas-wrap -->
</body>
</html>