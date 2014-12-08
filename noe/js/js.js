/* POP-UP WINDOW FORM */
function openPopup() {
    var divPopup = document.getElementById("popup");
    var button = document.getElementById("popup_button");
    divPopup.style.display = "block";
    button.style.display = "none";
    document.getElementsByTagName("html")[0].style.backgroundColor = 'rgba(0,0,0,0.4)';
}
/* END POP-UP WINDOW FORM */

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
