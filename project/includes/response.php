<?php
include_once '../core/init.php';

if (is_ajax()) { // on teste si la requete est de l'ajax
  if (isset($_POST["action"]) && !empty($_POST["action"])) { // on test si la valeur existe
    $action = $_POST["action"];
    $db = db::getInstance(); // nouvelle instance bd
    switch($action) { // un switch pour les differentes action possible
      case "display_users": displayUsers($db); break;
      case "update": update($db); break;
      case "delete": deleteUser($db); break;
      case "display_reservation": displayReservation($db); break;
      case "update_reservation": updateReservation($db); break;
      case "delete_reservation": deleteReservation($db); break;
      case "display_entree": displayentree($db); break;
      case "update_entree": updateentree($db); break;
      case "delete_entree": deleteentree($db); break;
      case "add_entree": addentree($db); break;
    }
  }
}

// ACTION PHP POUR LA TABLE UTILISATEUR
function displayUsers($db){
  $sth = $db->getPDO()->prepare("SELECT * FROM users ORDER BY ".$_POST['columns'][$_POST['order'][0]['column']]['name']." ".$_POST['order'][0]['dir']."");
  $sth->execute();
  $rslt = $sth->fetchAll(PDO::FETCH_NUM);
  $return = array("draw" => $_POST['draw'], "recordsTotal" => count($rslt), "recordsFiltered" => ($_POST['search']['value'] === "") ? count($rslt) : 0, "aaData" => array());
  foreach ($rslt as $key => $user) {
    $values = array_exclude_keys($user, array(2, 3));
    if($_POST['search']['value'] !== ""){
      $pattern = "/\b".escape(trim($_POST['search']['value']))."/i";
      if(is_match_in_array($pattern, $values)){
        $key =  $return["recordsFiltered"];
        $return["recordsFiltered"] += 1;
      }else{
        continue;
      }
    }
    $return['aaData'][$key] = array_merge($values, array(
      "<button class='tiny edit' ><i class='fa fa-pencil'></i></button>",
      "<button class='tiny alert remove' value=".$user[0]."><i class='fa fa-trash'></i></button>"
    ));
  }
  $return['aaData'] = array_slice($return['aaData'], $_POST['start'], $_POST['length']);
  echo json_encode($return);
}

function update($db){
  echo $db->update("users", input::get('id'), array(input::get('header') => input::get('value')));
}

function deleteUser($db){
  echo json_encode($db->delete("users", array("id", "=", input::get('id'))));
}

// FIN PHP POUR LA TABLE UTILISATEUR


// ACTION PHP POUR LA TABLE DES RESERVATION

function displayReservation($db){
  $sth = $db->getPDO()->prepare("SELECT * FROM reservation ORDER BY ".$_POST['columns'][$_POST['order'][0]['column']]['name']." ".$_POST['order'][0]['dir']."");
  $sth->execute();
  $rslt = $sth->fetchAll(PDO::FETCH_NUM);
  $return = array("draw" => $_POST['draw'], "recordsTotal" => count($rslt), "recordsFiltered" => ($_POST['search']['value'] === "") ? count($rslt) : 0, "aaData" => array());
  foreach ($rslt as $key => $reservation) {
     if($_POST['search']['value'] !== ""){
      $pattern = "/\b".escape(trim($_POST['search']['value']))."/i";
      if(is_match_in_array($pattern, $reservation)){
        $key =  $return["recordsFiltered"];
        $return["recordsFiltered"] += 1;
      }else{
        continue;
      }
    }
    $return['aaData'][$key] = array_merge($reservation, array(
      "<button class='tiny alert remove' value=".$reservation[0]."><i class='fa fa-trash'></i></button>"
    ));
  }
  $return['aaData'] = array_slice($return['aaData'], $_POST['start'], $_POST['length']);
  echo json_encode($return);
}


function updateReservation($db){
  echo $db->update("reservation", input::get('id'), array(input::get('header') => input::get('value')));
}

function deleteReservation($db){
  echo json_encode($db->delete("reservation", array("id", "=", input::get('id'))));
}
// FIN PHP POUR LA TABLE RESEVATION



// ACTION PHP POUR LA TABLE DES ENTREE

function displayentree($db){
  $sth = $db->getPDO()->prepare("SELECT * FROM entree ORDER BY ".$_POST['columns'][$_POST['order'][0]['column']]['name']." ".$_POST['order'][0]['dir']."");
  $sth->execute();
  $rslt = $sth->fetchAll(PDO::FETCH_NUM);
  $return = array("draw" => $_POST['draw'], "recordsTotal" => count($rslt), "recordsFiltered" => ($_POST['search']['value'] === "") ? count($rslt) : 0, "aaData" => array());
  foreach ($rslt as $key => $entree) {
     if($_POST['search']['value'] !== ""){
      $pattern = "/\b".escape(trim($_POST['search']['value']))."/i";
      if(is_match_in_array($pattern, $entree)){
        $key =  $return["recordsFiltered"];
        $return["recordsFiltered"] += 1;
      }else{
        continue;
      }
    }
    $return['aaData'][$key] = array(
      $entree[0],
      $entree[1],
      $entree[2],
      $entree[3],
      "<input type='checkbox' ".(($entree[4]) ? "checked" : "")."/>",
      "<button class='tiny alert remove' value=".$entree[0]."><i class='fa fa-trash'></i></button>"
    );
  }
  $return['aaData'] = array_slice($return['aaData'], $_POST['start'], $_POST['length']);
  echo json_encode($return);
}


function updateentree($db){
  echo $db->update("entree", input::get('id'), array(input::get('header') => input::get('value')));
}

function deleteentree($db){
  echo json_encode($db->delete("entree", array("id", "=", input::get('id'))));
}

function addentree($db){
  echo $db->insert("entree", array("nom" => "", "ingredient" => "", "prix" => 0, "disponible" => 0));
}
// FIN PHP POUR LA TABLE ENTREE