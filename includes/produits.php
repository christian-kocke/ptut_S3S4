<?php
require_once '../core/init.php';

$user = new user();

// Création d'un nouveau produit par l'adminisatrateur

if(input::exists()){ // test si $_POST est set
	if(token::check(input::get('token')) === true){ // vérifiaction du token pour la 'cross site forgerie'
		$validate = new validation(); // nouvelle instance de validation
		$validation = $validate->check($_POST, array( // validation des champs du formulaire
			'name' => array( // critères de validation du champ name
				'required' => true,
				'error' => 'the product name',
				'min' => 5,
				'max' => 50
			),
			'description' => array( // critères de validation du champ description
				'required' => true,
				'error' => 'the product description',
				'max' => 255
			),
			'price' => array( // critères de validation du champ price
				'required' => true,
				'error' => 'the price',
				'numeric' => true
			)
		));
		if(file::exists('product_image')){ // on vérifie que l'admin a un bien séléction un fichier image du produit
			$file = new file('product_image'); // nouvlle instance de file
			$file->check(); // on vérifie si le fichier correspond au type/format souhaiter
				if($validation->passed() && $file->passed()){ // si tous les champs sont valider
					$db = db::getInstance(); // nouvelle instance de db
					try{
						$file->upload(); // on upload l'image
						$db->insert('products', array( // on crée le produit dans la base de données
							'name' => input::get('name'),
							'price' => input::get('price'),
							'description' => input::get('description'),
							'image' => basename($_FILES["product_image"]["name"])
						));
						redirect::to('produits.php'); // on recharge la page
					}catch(Exception $e){
						die($e->getMessage()); // on affiche les erreurs sql eventuelles
					}
				}else{
					foreach ($file->errors() as $error) { // on affiche les erreur si la validation du fichier a échouer
						echo $error. '</br>';
					}
				}
		}else{
			foreach($validation->errors() as $error) { // on affiche les erreur éventuelles si la validation à échoué
				echo $error.'</br>';
			}
		}
	}					
}


include_once 'head.php';
?>
<div class="row alert-container">
	<div id="mainAlert1" data-alert class="alert-box large-6 large-centered column hide text-center" tabindex="0" aria-live="assertive" role="dialogalert">
		<p class="flash"></p>
	  <button href="#" tabindex="0" class="close" id="close" aria-label="Close Alert">&times;</button>
	</div>
</div>
<?php
if($user->hasPermission("admin")){ // si l'utilisateur est administrateur on lui affiche un formulaire pour crée de nouveau produit
?>
<div class="row">
	<div class="panel large-8 large-centered column">
		<h4 class="text-center">Add a product</h4>
		<div class="row">
			<div class="large-12 column">
				<form action="" method="post" enctype="multipart/form-data" name="create-product">
					<div class="large-12 column">
						<label  for="name">Product name</label>
						<input type="text" name="name" id="name" required/>
					</div>
					<div class="large-12 column">
						<label for="product_image">Product image</label>
						<input type="file" name="product_image"/>
					</div>
					<div class="large-12 column">
						<label for="description">Product description</label>
						<textarea type="text" name="description" required></textarea>
					</div>
					<div class="large-12 column">
						<label for="price">Price</label>
						<input type="number" name="price" required/>
					</div>
				   	<div class="large-12 column text-center"> 
				   		<input type="hidden" name="token" value="<?php echo token::generate(); ?>"/>
						<button class='button' type='submit' value='create'>create</button>	
					</div>
				</form>
			</div>
		</div>
	</div>
</div>
<?php
}
?>
<div class="row">
	<div class="large-10 large-centered column">
		<form action="" method="post" class="searchForm" name="searchForm">
		<div class="large-12 columns">
	      <div class="row collapse">
	        <div class="small-10 columns">
	          <input type="search" name="pattern" id="search" placeholder="search for your product here"/>
	        </div>
	        <div class="small-2 columns">
	          <a href="#" class="button postfix">Search <i class="fa fa-search"></i></a>
	        </div>
	      </div>
	    </div>
	    <div class="large-12 column count">
	    	
	    </div>
		</form>
	</div>
</div>
<div class="row products">

</div>

<footer>
		<script src="js/vendor/jquery.js"></script>
		<script src="js/vendor/fastclick.js"></script>
		<script src="js/foundation.min.js"></script>
		<script>
			$(document).foundation();
			$(document).ready(function(){
				function loadProducts() {
					$.ajax({
					  type: "POST",
					  dataType: "json",
					  url: "response.php", 
					  data: {"action" : "product_display"},
					  success: function(data) {
					  	$(".products").html(data['display'].replace(/\"/g, ""));
					  }
					});
				}

				loadProducts();

				var toId;
				$(".products").on("submit", ".productForm", function() {
						$(this).find("input[type=number]").prop("disabled", false);
						var action = $(this).find("button").attr("value");
						var data = {
						  "action": action
						};
						data = $(this).serialize() + "&" + $.param(data);
						$.ajax({
						  type: "POST",
						  dataType: "json",
						  url: "response.php", 
						  data: data,
						  success: function(data) {
						  	if(data != "deleted"){
							  	$("input[value="+data['id']+"]").siblings("button").attr("value", data['action']);
							  	$("input[value="+data['id']+"]").siblings("button").html(data['action']);
							  	if(data['action'] == 'add'){
							  		$("input[value="+data['id']+"]").parent().siblings(".quantity").children().val("1");
							  		$("input[value="+data['id']+"]").parent().siblings(".quantity").children().prop("disabled", true);
							  	}else{
							  		$("input[value="+data['id']+"]").parent().siblings(".quantity").children().prop("disabled", false);
							  	}
							  	var type = (data['action'] == 'add') ? "alert" : "success";
							  	
							  	$(".flash").html(data['msg']);
							  	$(".basket-display").html(data['basket']);
							}else{
								loadProducts();
								type = "alert";
								$(".flash").html("Product deleted successfuly");
							}
							$("#mainAlert1").toggleClass("hide success alert", false);
						  	$("#mainAlert1").toggleClass(type, true);
						  	clearTimeout(toId);
						  	toId = setTimeout(function() {
						  		$("#mainAlert1").toggleClass("hide", true)
						  	}, 3000);
						  }
						});
						return false;
					});

				$(".products").on("change", ".productForm", function() {
				    var data = {
				      "action": "update"
				    };
				    data = $(this).serialize() + "&" + $.param(data);
				    $.ajax({
				      type: "POST",
				      dataType: "json",
				      url: "response.php",
				      data: data
				    });
				    return false;
				});

				$(".searchForm").bind("input", function() {
					var data = {
						"action": "product_display"
					};
					data = $(this).serialize() + "&" + $.param(data);
					$.ajax({
						  type: "POST",
						  dataType: "json",
						  url: "response.php", 
						  data: data,
						  success: function(data) {
						  	if(data['display']){
						  		$(".products").html(data['display'].replace(/\"/g, ""));
						  		$(".count").html(data['count']+" product(s) match your search");
						  	}else{
						  		$(".products").html("<div class='large-10 large-centered column text-center'><h5>No products were found</h2></div>");
						  		$(".count").empty();
						  	}
						  }
						});
					return false;
				});

			    $('.close').bind("click", function(){
			    	var c = confirm("If you proceed you will no longer recieve any notification concerning your actions on this page unless you refresh your browser");
			        if(!c){
			            return false;
			        }
			    });
			});

			$(document).ajaxSend(function(e, jqXHR){
		  		
			});
			$(document).ajaxComplete(function(e, jqXHR){
			  
			});
		</script>
	</footer>
</body>
</html>

	
