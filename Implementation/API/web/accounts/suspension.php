<?php
  include_once(__DIR__."/../../modules/accounts.php");
  include_once(__DIR__."/../../modules/common.php");
  include_once(__DIR__."/../../config.php");
  $accounts = new Accounts;
  
  if(isset($_GET['username']) && isset($_GET['password']) && Accounts::isLoggedIn($_GET['username'], $_GET['password'])) {
    if(!(Accounts::isOfficer($_GET['username']) || Accounts::isAdministrator($_GET['username']))) {
      echo json_encode(array("result" => 403, "message" => "User not authorized"));
      die();
    }

    if(!checkParameter($_GET['suspenderUser'], "string")) {
      echo json_encode(array("result" => 404, "message" => "Missing or invalid parameter suspenderUser"));
      die();
    }

    if(!checkParameter($_GET['action'], "string") || ($_GET['action'] != "suspend" && $_GET['action'] != "restore")) {
      echo json_encode(array("result" => 404, "message" => "Missing or invalid parameter action"));
      die();
    }

    if ($_SERVER['REQUEST_METHOD'] === 'GET') {
      $suspend = $_GET['action'] == "suspend" ? true : false;

      if($suspend) {
        if(Accounts::suspendUser($_GET['suspenderUser'])) {
          echo json_encode(array("result" => 200, "content" => NULL));
        }
        else {
          echo json_encode(array("result" => 400, "message" => "Username not found in system"));
        }
      }
      else {
        if(Accounts::restoreUser($_GET['suspenderUser'])) {
          echo json_encode(array("result" => 200, "content" => NULL));
        }
        else {
          echo json_encode(array("result" => 400, "message" => "Username not found in system"));
        }
      }
    }
  }
?>