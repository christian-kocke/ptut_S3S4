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
    }
  }
}

function displayItems($db){
  switch(input::get("table")){
    case "users": $table = "users"; break;
    case "reservation": $table = "reservation"; break;
    case "entree": $table = "entree"; break;
    case "plat": $table = "plat"; break;
    case "dessert": $table = "dessert"; break;
  }
  $client_id = input::get("id");
  $sth = $db->getPDO()->prepare("SELECT * FROM ".$table." ".(($client_id) ? "WHERE client_id = ?" : "")." ORDER BY ".$_POST['columns'][$_POST['order'][0]['column']]['name']." ".$_POST['order'][0]['dir']."");
  $sth->bindParam(1, $client_id);
  $sth->execute();
  $rslt = $sth->fetchAll(PDO::FETCH_NUM);
  $return = array("draw" => $_POST['draw'], "recordsTotal" => count($rslt), "recordsFiltered" => ($_POST['search']['value'] === "") ? count($rslt) : 0, "aaData" => array());
  foreach ($rslt as $key => $item) {
    switch($table){
      case "users":
        $item = array_exclude_keys($item, array(2, 3));
        $actions = array(
          "<button class='tiny edit' ><i class='fa fa-pencil'></i></button>",
        );
        break;
      case "entree":
      case "plat":
      case "dessert":
        $actions = array(
          "<input type='checkbox' ".(($item[4]) ? "checked" : "")."/>",
        );
        array_pop($item);
        break;
      default: $actions = array();
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
    $return['aaData'][$key] = array_merge($item, $actions, array("<button class='tiny alert remove' value=".$item[0]."><i class='fa fa-trash'></i></button>")); 
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
