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