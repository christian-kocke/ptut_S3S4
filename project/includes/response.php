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
      case "changePassword": changePassword($db); break;
      case "changeInfo": changeInfo($db); break;
      case "tokenCheck": tokenCheck(); break;
      case "tokenGenerate": tokenGenerate(); break;
      case "reservation": reservation($db); break;
    }
  }
}

function displayItems($db){
  switch(input::get("table")){
    case "users": 
      $table = "users"; 
      break;
    case "reservation": 
      $select = "SELECT reservation.id, reservation.name, reservation.nbPerson, reservation.dateResa, creneaux.beginning FROM reservation INNER JOIN creneaux ON reservation.id_creneaux = creneaux.id ";
      break;
    case "entree": 
      $table = "entree"; 
      break;
    case "plat": 
      $table = "plat"; 
      break;
    case "dessert": 
      $table = "dessert"; 
      break;
    case "history":
      $client_id = input::get("id");
      $select = "SELECT reservation.id, reservation.name, reservation.nbPerson, reservation.dateResa, reservation.id_creneaux FROM reservation WHERE client_id = ?";
      break;
  }
  if(isset($table)) $select = "SELECT * FROM ".$table." ";
  error_log($select);
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
  $values = $db->get(input::get("table"), array("id", "=", input::get("id")));
  switch(input::get('type')){
    case "delete":
    switch(input::get("table")){
      case "users":
      $msg = "<p>Etes vous sur de vouloir supprimer l'utilisateur <strong>".$values->first()->firstname." ".$values->first()->lastname."</strong></p>";
      break;
      case "entree":
      $msg = "<p>Etes vous sur de vouloir supprimer l'entrée <strong>".$values->first()->nom."</strong></p>";
      break;
      case "plat":
      $msg = "<p>Etes vous sur de vouloir supprimer le plat <strong>".$values->first()->nom."</strong></p>";
      break;
      case "dessert":
      $msg = "<p>Etes vous sur de vouloir supprimer le dessert <strong>".$values->first()->nom."</strong></p>";
      break;
    }
  }
  $return = "<div class='row'><div class='large-12 medium-12 small-12 small-centered medium-centered large-centered text-center column'><h2>Confirmation</h2>".$msg."</div><div class='large-12 medium-12 small-12 small-centered medium-centered large-centered large-centered text-center column'><ul class='button-group even-2'><li><a href='#' class='button secondary cancel'>Annuler</a></li><li><a href='#' class='button confirm'>Supprimer</a></li></ul></div></div><a class='close-reveal-modal'>&#215;</a>";
  echo json_encode($return, 64 | 256);
}

function changePassword($db){
  $user = $db->get(input::get("table"), array("id", "=", input::get("id")));
  if(count($user) === 1){
    if($user->first()->password == hash::generate(input::get("old"), $user->first()->salt)){
      $validate = new validation();
      $validation = $validate->check($_POST, array( // validation des champs
        'new' => array('required' => true, 'error' => "le nouveau mot de passe", "min" => 8, "max" => 100)
        ));
      if($validation->passed()) { 
        $salt = hash::salt(32);
        $password = hash::generate(input::get("new"), $salt);
        $rslt = $db->update(input::get("table"), input::get('id'), array("password" => $password, "salt" => $salt));
        echo json_encode(array($rslt, "Echec de la modification !"));
        return 0;
      }
      echo json_encode(array(false, $validation->errors()));
      return 0;
    }
    echo json_encode(array(false, array("Le mot de passe est incorrect")));
    return 0;
  }
  echo json_encode(array(false, array("Echec de la modification")));
}

function changeInfo($db){
  $user = $db->get(input::get("table"), array("id", "=", input::get("id")));
  if(count($user) === 1){
    $validate = new validation();
    $validation = $validate->check('$_POST', array(
      'username' => array(
        'error' => 'Le pseudo',
        'required' => true,
        'max' => 50
        ),
      'firstname' => array(
        'error' => 'Le prénom',
        'required' => true,
        'max' => 50
        ),
      'lastname' => array(
        'error' => 'Le nom',
        'required' => true,
        'max' => 50
        ),
      'tel' => array(
        'error' => 'Le numéro de téléphone',
        'required' => true,
        'max' => 50
        ),
      'email' => array(
        'error' => "l'adresse email",
        'required' => true,
        'max' => 50
        )
      ));
    if($validation->passed()){
      $rslt = $db->update(input::get("table"), input::get('id'), array(
        "username" => input::get('username'),
        "firstname" => input::get('firstname'),
        "lastname" => input::get('lastname'),
        "phone" => input::get('tel'),
        "email" => input::get('email')
        ));
      echo json_encode(array($rslt, "Echec de la modification !"));
      return 0;
    }
    echo json_encode(array(false, $validation->errors()));
    return 0;
  }
  echo json_encode(array(false, array("Echec de la modification")));
  return 0;
}

function tokenCheck(){
  echo token::check(input::get("token"));
}

function tokenGenerate(){
  echo json_encode(token::generate());
}

function reservation($db){
  switch (input::get("type")) {
    case "date":
      $sth = $db->getPDO()->prepare("SELECT dateResa FROM reservation GROUP BY dateResa HAVING COUNT(dateResa) = ((SELECT COUNT(id) FROM creneaux) * (SELECT COUNT(id) FROM tables)) AND dateResa >= (SELECT NOW())");
      $sth->execute();
      $rslt = $sth->fetchAll(PDO::FETCH_NUM);
      foreach ($rslt as $key => $value) {
        $rslt[$key] = explode("-", $value[0]);
      }
      array_walk_recursive($rslt, "parseInt");
      for($i = 0;$i < count($rslt);$i++){
        $rslt[$i][1]--;
      }
      echo json_encode($rslt);
      break;
    case "hours":
      $date = DateTime::createFromFormat('j/m/Y', (string) input::get("date"), new DateTimeZone('Europe/Paris'));
      $d = $date->format('Y-m-d');
      $sth = $db->getPDO()->prepare("SELECT id, beginning FROM creneaux WHERE id NOT IN (SELECT id_creneaux FROM reservation WHERE dateResa = :date GROUP BY id_creneaux HAVING COUNT(id_creneaux) = (SELECT COUNT(id) FROM tables))");
      $sth->bindParam(":date", $d, PDO::PARAM_STR);
      $sth->execute();
      $rslt = $sth->fetchAll(PDO::FETCH_NUM);
      foreach ($rslt as $key => $value) {
        $rslt[$key] = array_merge($rslt[$key], explode(":", $value[1], -1));
      }
      echo json_encode($rslt);
      break;
    case "seats":
      $t = input::get("time");
      $date = DateTime::createFromFormat('j/m/Y', (string) input::get("date"), new DateTimeZone('Europe/Paris'));
      $d = $date->format('Y-m-d');
      $sth = $db->getPDO()->prepare("SELECT seats FROM tables WHERE id NOT IN (SELECT id_table FROM reservation WHERE dateResa = :date AND id_creneaux = :time)");
      $sth->bindParam(":date", $d, PDO::PARAM_STR);
      $sth->bindParam(":time", $t);
      $sth->execute();
      $rslt = $sth->fetchAll(PDO::FETCH_NUM);
      $total = 0;
      foreach($rslt as $key => $value){
        $total += $value[0];
      }
      echo $total;
      break;
    case "validation":
      $date = DateTime::createFromFormat('j/m/Y', (string) input::get("date"), new DateTimeZone('Europe/Paris'));
      $d = $date->format('Y-m-d');
      $t = input::get("time");
      if(input::get("client_id") !== "undefined"){
        $user = new user();
        $user->find(input::get("client_id"));
        $client_id = $user->data()->id;
        $name = $user->data()->lastname;
        $email = $user->data()->email;
        $phone = $user->data()->phone;
      }else{
        $client_id = null;
        $name = input::get("name");
        $email = input::get("email");
        $phone = input::get("phone");
      }
      $seats = input::get("seats");
      $tables = array();
      $sth = $db->getPDO()->prepare("SELECT * FROM tables WHERE id NOT IN (:list) AND id NOT IN (SELECT id_table FROM reservation WHERE dateResa = :date AND id_creneaux = :time) HAVING MIN(seats) AND seats >= :seats");
      while($seats > 0){
        $sth->bindParam(":seats", $seats);
        $list = implode(",", $tables);
        $sth->bindParam(":list", $list);
        $sth->bindParam(":date", $d, PDO::PARAM_STR);
        $sth->bindParam(":time", $t);
        $sth->execute();
        $rslt = $sth->fetchAll(PDO::FETCH_NUM);
        if($rslt == null && $seats > 0){
          $seats++;
        }else{
          foreach ($rslt as $key => $value) {
            $tables[] = $value[0];
            $seats -= $value[1];
          }
        }
      }
      error_log(print_r($tables, true));
      $insert = true;
      for($i = 0; $i < count($tables) && $insert == true; $i++){
        $insert = $db->insert("reservation", array(
          "client_id" => $client_id,
          "id_table" => $tables[$i],
          "nbPerson" => input::get("seats"),
          "dateResa" => $d,
          "id_creneaux" => input::get("time"),
          "name" => $name,
          "email" => $email,
          "phone" => $phone
        ));
      }
      if($insert) session::flash('home', "Votre reservation à été enregistrer");
      echo $insert;
      break;
  }
}