$(document).ready(function(){ 
	// Datepicker
	$('.fdatepicker').fdatepicker();

	// smooth scroll function
	$('a[href^="#"]').on('click',function(e) {
		e.preventDefault();
		
		var target = this.hash,
		$target = $(target);
		
		$('html, body').stop().animate({
            'scrollTop': $target.offset().top
        }, 900, 'swing', function () {
           window.location.hash = target;
       });
	});					
});  

/* SCHEDULE */
var now = new Date(),
hour = now.getUTCHours() + 2,
min = now.getUTCMinutes(),
sel = document.getElementById('time'),
opt,
j = 0,
i = 0;

for (i=12; i<=22; i++){
	for(j=0; j<60; j += 15) {
        if(j != 0) {
            opt = document.createElement('option');	
            opt.value = i + 'h' + j;
            opt.textContent = i + 'h' + j;
            sel.appendChild(opt);
            if (i == hour) {
                opt.selected = true;
            }
        }
        else {
            opt = document.createElement('option');
            opt.value = i + 'h00';
            opt.textContent = i + 'h00';
            sel.appendChild(opt);
            if (i == hour) {
                opt.selected = true;
            }
        }
    }
}
/* END SCHEDULE */

/* RESERVATION MODAL */
$("#MenuDisplay").click(function() {
    $("#ResaForm").slideUp("slow");
    $("#MenuModal").slideDown("slow");
});
$("#MenuHide").click(function() {
    $("#ResaForm").slideDown("slow");
    $("#MenuModal").slideUp("slow");
});
/* END RESERVATION MODAL */

/* BACK TO THE TOP BUTTON */
$(document).ready(function(){

    // hide #back-top first
    $("#back-top").hide();

    // fade in #back-top
    $(function () {
        $(window).scroll(function () {
            if ($(this).scrollTop() > 100) {
                $('#back-top').fadeIn();
            } else {
                $('#back-top').fadeOut();
            }
        });

        // scroll body to 0px on click
        $('#back-top').click(function () {
            $('body,html').animate({
                scrollTop: 0
            }, 800);
            return false;
        });
    });
});
/* END BACK TO THE TOP BUTTON */

/* ALERT HANDLING */

$(document).ready(function() {
    $(".flash").each(function() {
        if($(this).is(":empty")){
            $(this).parent().addClass("hide");
        }else{
            $(this).parent().removeClass("hide");
            $(this).parents(".reveal-modal").foundation('reveal','open');
        }
    });
});