<?php
include_once '../core/init.php';

if (is_ajax()) { // on teste si la requete est de l'ajax
  if (isset($_POST["action"]) && !empty($_POST["action"])) { // on test si la valeur existe
    $action = $_POST["action"];
    $db = db::getInstance(); // nouvelle instance bd
    switch($action) { // un switch pour les differentes action possible
      case "display": displayItems($db); break;
      case "update": updateItem($db); break;
      case "delete": deleteItem($db); break;
      case "insert": insertItem($db); break;
      case "email": sendEmail(); break;
      case "confirm": confirm($db); break;
    }
  }
}

function displayItems($db){
  if(input::get("table") === "history"){
    $client_id = input::get("id");
    $select = "SELECT reservation.id, users.lastname, reservation.nbPerson, reservation.dateResa, reservation.schedule FROM reservation INNER JOIN users ON reservation.client_id = users.id WHERE client_id = ?";
  }else{
    switch(input::get("table")){
      case "users": $table = "users"; break;
      case "reservation": $table = "reservation"; break;
      case "entree": $table = "entree"; break;
      case "plat": $table = "plat"; break;
      case "dessert": $table = "dessert"; break;
    }
    $select = "SELECT * FROM ".$table." ";
  }
  $sth = $db->getPDO()->prepare($select."ORDER BY ".$_POST['columns'][$_POST['order'][0]['column']]['name']." ".$_POST['order'][0]['dir']."");
  $sth->bindParam(1, $client_id);
  $sth->execute();
  $rslt = $sth->fetchAll(PDO::FETCH_NUM);
  $return = array("draw" => $_POST['draw'], "recordsTotal" => count($rslt), "recordsFiltered" => ($_POST['search']['value'] === "") ? count($rslt) : 0, "aaData" => array());
  foreach ($rslt as $key => $item) {
    $actions = array();
    if(!(isset($client_id))){
      switch($table){
        case "users":
          $item = array_exclude_keys($item, array(2, 3));
          break;
        case "entree":
        case "plat":
        case "dessert":
          array_push($actions,"<input type='checkbox' ".(($item[4]) ? "checked" : "")."/>");
          array_pop($item);
          break;
        default: $actions = array();
      }
      array_push($actions, "<button class='tiny alert remove' value=".$item[0]."><i class='fa fa-trash'></i></button>");
    }
    if($_POST['search']['value'] !== ""){
      $pattern = "/\b".escape(trim($_POST['search']['value']))."/i";
      if(is_match_in_array($pattern, $item)){
        $key =  $return["recordsFiltered"];
        $return["recordsFiltered"] += 1;
      }else{
        continue;
      }
    }
    $return['aaData'][$key] = array_merge($item, $actions); 
  }
  $return['aaData'] = array_slice($return['aaData'], $_POST['start'], $_POST['length']);
  echo json_encode($return);
}

function updateItem($db){
  echo $db->update(input::get("table"), input::get('id'), array(input::get('header') => input::get('value')));
}

function deleteItem($db){
  echo json_encode($db->delete(input::get("table"), array("id", "=", input::get('id'))));
}

function insertItem($db){
  echo $db->insert(input::get("table"), array("nom" => "", "ingredient" => "", "prix" => 0, "disponible" => 0));
}

// envoie d'un email
function sendEmail(){
  $sent = false; // on initialie la valeur a false
  $from = filter_var(escape(trim($_POST['email'])), FILTER_VALIDATE_EMAIL); // on valide la valeur email (test si elle est conforme au format requis)
  $to = "yann.verneau@hotmail.fr"; // on définie l'adresse a la quelle on veut envoyer l'email
  $subject = escape(trim($_POST['subject'])); // on valide le sujet de l'email
  $msg = str_replace("\n", "\r\n", str_replace("\n.", "\n..", escape(trim($_POST['message'])))); // on valide le message
  if($from){ // si l'adresse de l'expediteur est conforme
    $headers = 'From: '. $from . "\r\n";
    $sent = mail($to, $subject, $msg, $headers); // on envoie l'email
  }
  echo json_encode($sent); // on retoure le boolean $sent (si l'email a bien été envoyer ou non)
}

function confirm($db){
  switch(input::get('type')){
    case "delete":
      $user = $db->get(input::get("table"), array("id", "=", input::get("id")));
      $return = "<div class='row'><div class='large-12 medium-12 small-12 small-centered medium-centered large-centered text-center column'><h2>Confirmation</h2><p>Etes vous sur de vouloir supprimer l'utilisateur ".$user->first()->firstname." ".$user->first()->lastname."</p></div><div class='large-12 medium-12 small-12 small-centered medium-centered large-centered large-centered text-center column'><ul class='button-group even-2'><li><a href='#' class='button secondary cancel'>Annuler</a></li><li><a href='#' class='button confirm'>Supprimer</a></li></ul></div></div><a class='close-reveal-modal'>&#215;</a>";
      break;
  }
  echo json_encode($return, 64 | 256);
}