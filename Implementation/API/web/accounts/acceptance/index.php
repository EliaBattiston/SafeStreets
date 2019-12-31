<?php
  include_once(__DIR__."/../../../modules/accounts.php");
  include_once(__DIR__."/../../../modules/common.php");
  include_once(__DIR__."/../../../config.php");
  
  if(isset($_POST['username']) && isset($_POST['password']) && Accounts::isLoggedIn($_POST['username'], $_POST['password'])) {
    if(!Accounts::isAdministrator($_POST['username'])) {
      echo json_encode(array("result" => 403, "message" => "User not authorized"));
      return;
    }

    if(!checkParameter($_POST['acceptedUser'], "string")) {
      echo json_encode(array("result" => 404, "message" => "Missing or invalid parameter suspendedUser"));
      return;
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      if(Accounts::acceptUser($_POST['acceptedUser'], $_POST['username'])) {
        echo json_encode(array("result" => 200, "content" => NULL));
      }
      else {
        echo json_encode(array("result" => 400, "message" => "Username not found in system"));
      }
    }
  }
  else
  {
    echo json_encode(array("result" => 401, "message" => "Username and/or password not found"));
  }
?>