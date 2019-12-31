<?php
  include_once(__DIR__."/../../../modules/accounts.php");
  include_once(__DIR__."/../../../modules/common.php");
  include_once(__DIR__."/../../../config.php");
  
  if(isset($_POST['username']) && isset($_POST['password']) && Accounts::isLoggedIn($_POST['username'], $_POST['password'])) {
    if(!Accounts::isAdministrator($_POST['username'])) {
      echo json_encode(array("result" => 403, "message" => "User not authorized"));
      return;
    }

    if(!checkParameter($_POST['suspendedUser'], "string")) {
      echo json_encode(array("result" => 404, "message" => "Missing or invalid parameter suspendedUser"));
      return;
    }

    if(!checkParameter($_POST['action'], "string") || ($_POST['action'] != "suspend" && $_POST['action'] != "restore")) {
      echo json_encode(array("result" => 404, "message" => "Missing or invalid parameter action"));
      return;
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      $suspend = $_POST['action'] == "suspend" ? true : false;

      if($suspend) {
        if(Accounts::suspendUser($_POST['suspendedUser'])) {
          echo json_encode(array("result" => 200, "content" => NULL));
        }
        else {
          echo json_encode(array("result" => 400, "message" => "Username not found in system"));
        }
      }
      else {
        if(Accounts::restoreUser($_POST['suspendedUser'])) {
          echo json_encode(array("result" => 200, "content" => NULL));
        }
        else {
          echo json_encode(array("result" => 400, "message" => "Username not found in system"));
        }
      }
    }
  }
  else
  {
    echo json_encode(array("result" => 401, "message" => "Username and/or password not found"));
  }
?>