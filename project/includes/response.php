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
    }
  }
}

function displayUsers($db){
  $sth = $db->getPDO()->prepare("SELECT * FROM users");
  $sth->execute();
  $rslt = $sth->fetchAll();
  $return = array("draw" => $_POST['draw'], "recordsTotal" => count($rslt), "recordsFiltered" => count($rslt), "aaData" => array());
  foreach ($rslt as $key => $users) {
    $return['aaData'][$key] = array(
      $users['id'],
      $users['username'],
      $users['firstname'],
      $users['lastname'],
      $users['phone'],
      $users['email'],
      $users['user_group'],
      $users['joined'],
      "<button class='tiny edit' ><i class='fa fa-pencil'></i></button>",
      "<button class='tiny alert remove' value=".$users['id']."><i class='fa fa-trash'></i></button>"
    );
  }
  echo json_encode($return);
}

function update($db){
  echo $db->update("users", input::get('id'), array(input::get('header') => input::get('value')));
}

function deleteUser($db){
  echo json_encode($db->delete("users", array("id", "=", input::get('id'))));
}