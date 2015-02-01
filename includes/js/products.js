$(document).ready(function(){


	$(".quantity").change(function(){
	    var data = {
	      "action": "update"
	    };
	    data = $(this).serialize() + "&" + $.param(data);
	    $.ajax({
	      type: "POST",
	      dataType: "json",
	      url: "response.php", //Relative or absolute path to response.php file
	      data: data
	    });
	});


	$(".productForm").submit(function(){
		var action = $(this).find("button").attr("value");
		var data = {
		  "action": action
		};
		data = $(this).serialize() + "&" + $.param(data);
		$.ajax({
		  type: "POST",
		  dataType: "json",
		  url: "response.php", //Relative or absolute path to response.php file
		  data: data,
		  success: function(data) {
		  	$("input[value="+data['id']+"]").siblings("button").attr("value", data['action']);
		  	$("input[value="+data['id']+"]").siblings("button").html(data['action']);
		  	if(data['action'] == 'add'){
		  		$("input[value="+data['id']+"]").siblings("input[name=quantity]").attr("value", "1");
		  	}
		  	$(".flash").html(data['msg']);
		  	$(".basket-display").html(data['basket']);
		  }
		});
	});
});