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