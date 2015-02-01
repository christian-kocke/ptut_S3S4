<?php
include_once '../core/init.php';

if (is_ajax()) { // on teste si la requete est de l'ajax
  if (isset($_POST["action"]) && !empty($_POST["action"])) { // on test si la valeur existe
    $action = $_POST["action"];
    $db = db::getInstance(); // nouvelle instance bd
    switch($action) { // un switch pour les differentes action possible
      case "update": update_function(); break;
      case "add": add_function(); break;
      case "delete": delete_function($db); break;
      case "remove": remove_function(); break;
      case "display": display_function(); break;
      case "product_display": product_display_function($db); break;
      case "basket_display": display_basket_function($db); break;
      case "bill": bill_function($db); break;
      case "email": send_email_function(); break;
    }
  }
}

// envoie d'un email
function send_email_function(){
  $sent = false; // on initialie la valeur a false
  $from = filter_var(escape(trim($_POST['email'])), FILTER_VALIDATE_EMAIL); // on valide la valeur email (test si elle est conforme au format requis)
  $to = "christian.kocke@gmail.com"; // on définie l'adresse a la quelle on veut envoyer l'email
  $subject = escape(trim($_POST['subject'])); // on valide le sujet de l'email
  $msg = str_replace("\n", "\r\n", str_replace("\n.", "\n..", escape(trim($_POST['message'])))); // on valide le message
  if($from){ // si l'adresse de l'expediteur est conforme
    $headers = 'From: '. $from . "\r\n";
    $sent = mail($to, $subject, $msg, $headers); // on envoie l'email
  }
  echo json_encode($sent); // on retoure le boolean $sent (si l'email a bien été envoyer ou non)
}

// calcule du montant total du panier
function bill_function($db){ 
  $total = 0; // on initialise le total 0
  if(session::exists('basket')){ // si le panier existe
    foreach(session::get('basket') as $id => $values){ // pour chaque produits dans le panier
      $product = $db->get('products', array('id', '=', $id)); // on fait un requete a la base de donner pour recuperrer les informations sur le produits
      $total += $product->first()->price * $values['quantity']; // on additionne le prix de chaque produits
    }
  }
  echo json_encode("Total : ".$total." &#8364;"); // on retourne le prix total du panier 
}

// affichage du panier dans un tableau
function display_basket_function($db){
  if(session::exists('basket')){ // si le panier existe
    if(count(session::get('basket')) > 0){ // si le nombre de produits dans le panier est superieur a 0
      $i = 0; // on initialise le compteur $i a 0
      $return = array("draw" => $_POST['draw'], "recordsTotal" => count(session::get('basket')), "recordsFiltered" => count(session::get('basket')), "aaData" => array()); // on initialse le tableau $return pour le tableau
      foreach (session::get('basket') as $id => $values) { // pour chaque produit dans le panier
        $product = $db->get('products', array('id', '=', $id)); // on recupère tout les informations sur chaque produits dans le panier de la base de donnée
        if(!$product->count()){ // si la requete ne retourne rien (le produit n'est plus dans la base de donnée)
          session::delete('basket', $id); // on supprime le produit du panier (il n'est plus a jour)
        }else{ // sinon
          // on insère pour chaque produits les informations nécessaire avec l'html qui sera plus tard dans le tableau panier
          $return['aaData'][$i] = array("<img src='". config::get('files/product_image/path') .$product->first()->image."'' alt='{$values['name']}' class='product-image'/>".$values['name'], 
            $product->first()->price." &#8364;", 
            "<form class='quantity' id='quantity'><input type='hidden' value=".$product->first()->price." name='price'/><input type='number' name='quantity' value={$values['quantity']} maxlength='2' min='1' max='99'/><input type='hidden' value='{$id}' name='id'/></form>", 
            "<form method='post' class='removeForm'><input type='hidden' value='{$id}' name='id'/><input type='hidden' value='".htmlspecialchars($product->first()->name, ENT_QUOTES)."' name='name'/><button type='submit' value='remove' class='button'>Remove</button></form>");
          $i++; // on incrémente le compteur $i pour les indexes du tableau 'aaData'
        }
      }
      $return['aaData'] = array_slice($return['aaData'], $_POST['start'], $_POST['length']); // on coupe la partie du panier que l'on veut afficher en fonction de la pages du tableau dans la quelle on se trouve
    }else{
    $return = array("draw" => $_POST['draw'], "recordsTotal" => 0, "recordsFiltered" => 0, "aaData" => []); // si le panier est vide on retourne le tableau 'aaData' vide et les autres données a 0
    }
    echo json_encode($return); // on retourne le tableau $return
  }
}

// actualisation de la quantité d'un produit
function update_function(){
  if(session::exists("basket", $_POST['id'])){ // si le produit existe dans le panier
    $_SESSION['basket'][input::get("id")]['quantity'] = input::get("quantity"); // on actualise ça quantité 
    echo json_encode("succes"); // on retourne succes pour signaler que la quantité a bien été mise a jour
  }
}

// suppression d'un produit
function delete_function($db){
  $db->delete('products', array('id', '=', input::get('delete_id'))); // on supprime le produit de la base de donnée
  if(session::exists('basket')){ // si le panier existe
    session::delete('basket', input::get('delete_id')); // on supprime ce produit du panier
  }
  echo json_encode("deleted"); // on retourne 'deleted' pour siganler que le produit a bien été suppriler
}

// ajout d'un produit au panier
function add_function(){
  if(!session::exists('basket', input::get('id'))) { // si le produit n'existe pas dans le panier
    if(session::setArray('basket', input::get('id'), array('name' => input::get('name'), 'quantity' => input::get('quantity')))){ // on place le produit dans le panier
      $return['msg'] = 'The product <strong>' . input::get('name') . '</strong> has been <strong>added</strong> to your basket'; // on initialise le message que l'on va retourner a l'utilisateur
      $return['action'] = "remove"; // on initialise l'action qui sera disponnible pour l'utilisateur (la suppression du produit de sont panier)
    }else{ // si l'ajout à échoué
      $return['msg'] = 'There has been a problem adding the product ' . input::get('name') . ' to your basket'; // on signal a l'utilisateur qu'il y a eu un problème lors de l'ajout du produit
      $return['action'] = "add"; // on initialise l'action qui sera disponnible pour l'utilisateur (inchanger car il a eu erreur)
    }  
  }else{ // si le produit est déjà dans le panier
    $return['msg'] = 'The product ' . input::get('name') . ' is already in your basket'; // on le signal a l'utilisateur
    $return['action'] = "remove"; // on intialise l'action qui sera disponnible pour l'utilisateur
  }
  $return['id'] = input::get('id'); // on retourne l'identifiant du produits
  $return['basket'] = (count(session::get('basket')) >= 1) ? count(session::get('basket')) ." item(s) <i class='fa fa-shopping-cart'></i>" : ""; // on actualise l'affichage du panier
  echo json_encode($return); // on retroune toutes les données

}

// supression d'un produit du pannier
function remove_function(){
  session::delete('basket', input::get('id')); // on supprime le produit du panier (pas besoin de vérification car si le produit n'est pas dans le panier ça ne change rien)
  $return['msg'] = 'The product <strong>' . input::get('name') . '</strong> has been <strong>removed</strong> from your basket'; // on affiche a l'utilisateur que sont produit a bien été supprimer du panier
  $return['action'] = "add"; // on initialise l'action a 'ajouter au panier'
  $return['id'] = input::get('id'); // on retourne l'identifiant du produit
  $return['basket'] = (count(session::get('basket')) >= 1) ? count(session::get('basket')) ." item(s) <i class='fa fa-shopping-cart'></i>" : ""; // on actualise l'affichage du produit
  echo json_encode($return); // on retourne toutes les données
}


// supression d'un produit est reaffichage du panier
function display_function(){
  if(session::exists('basket')){ //
    session::delete('basket', input::get('id')); // on supprime le produit du panier
    $return['msg'] = 'The product <strong>' . input::get('name') . '</strong> has been <strong>removed</strong> from your basket'; // on initialise le message pour l'utilisateur
  }
  $return['basket'] = (count(session::get('basket')) >= 1) ? count(session::get('basket')) ." item(s) <i class='fa fa-shopping-cart'></i>" : ""; // on actualise l'affichage du panier
  echo json_encode($return); // on retourne les données
}

// affichage des produits
function product_display_function($db){
  $user = new user(); // nouvelle instance utilisateur
  // on séléctionne tous les produits de la base de donnée
  $sth = $db->getPDO()->prepare('SELECT * FROM products'); 
  $sth->execute();

  $return['count'] = 0; // on initialise de le compteur de produit a 0 (compter le nombre de produit qui respectent le pattern de recherche si il y en a un)
  $return['display'] = ""; // on intialise la chaine de caractère d'affichage des produits
  foreach ($sth->fetchAll() as $value) { // on boucle sur chaque produit de la base de donnée
    $delete = false; // on initialse $delete a false 
    if(isset($_POST['pattern'])){ // si un pattern de recherche existe (que l'utilisateur fait une recherche)
      $pattern = "/\b".escape(trim($_POST['pattern']))."/i"; // on fait en sorte que le pattern soit appliquer sur chaque nouveau mot dans le nom du produit
      if(preg_match_all($pattern, $value['name'], $matches, PREG_PATTERN_ORDER)){ // on regarde si le pattern est dans le nom du produit
        $return['count'] += 1; // si oui on incrémente le compteur de produits
      }else{ 
        // si le produits ne resprecte pas le pattern on passe les étapes suivante et on passe au produit suivant
        continue;
      }
    }
    $submit = (session::exists('basket', $value['id'])) ? 'remove' : 'add'; // on determine si l'action disponnible pour l'utilisateur (si le produit est dans le panier ou non pour soit supprimer ou ajouter)
    // si l'utilisateur a les permission administrateur on lui affiche la possibilité de supprimer le produit de la base de donnée
    $delete = ($user->hasPermission("admin")) ? "<li class='cta-button'><form method='post' action='' name='delete-product' class='productForm'><input type='hidden' name='delete_id' value='{$value['id']}'/><input type='hidden' value='delete' name='delete'/><button class='button delete' type='submit' value='delete'>delete</button></form><li>" : false;
    $delete = ($delete == false) ? "<form method='post' name='add-basket' class='productForm'><li class='bullet-item quantity'><input type='number' name='quantity' value=".((isset($_SESSION['basket'][$value['id']]['quantity'])) ? $_SESSION['basket'][$value['id']]['quantity'] : 1)." maxlength='2' min='1' max='99' ".((isset($_SESSION['basket'][$value['id']])) ? "" : "disabled")."/></li><li class='cta-button'><input type='hidden' value='{$value['price']}' name='price' /><input type='hidden' value='{$value['id']}' name='id' /><input type='hidden' value='".htmlspecialchars($value['name'], ENT_QUOTES)."' name='name' /><button class='button' type='submit' value='{$submit}'>{$submit}</button></li></form>" : $delete;
    $return['display'] .= "<div class='large-3 column end'><ul class='pricing-table'><li class='bullet-item'><img src='". config::get('files/product_image/path') . $value['image']."'' alt='{$value['name']}'/></li><li class='title'>{$value['name']}</li><li class='price'>{$value['price']} &#8364;</li><li class='description'>{$value['description']}</li>".$delete."</ul></div>";
  }
  $return['display'] = utf8_encode($return['display']); // on encode la chaine de caractère en utf-8 pour quel soit compatible au format json
  echo json_encode($return, 64 | 256); // on json_encode n'echapent pas les slash et les caractères unicode
}
?>

