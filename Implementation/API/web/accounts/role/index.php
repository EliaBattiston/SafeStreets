<?php
  include_once(__DIR__."/../../../modules/accounts.php");
  include_once(__DIR__."/../../../modules/common.php");
  include_once(__DIR__."/../../../config.php");
  
  if(isset($_POST['username']) && isset($_POST['password']) && Accounts::isLoggedIn($_POST['username'], $_POST['password'])) {
    if(!Accounts::isAdministrator($_POST['username'])) {
      echo json_encode(array("result" => 403, "message" => "User not authorized"));
      return;
    }

    if(!checkParameter($_POST['roleUsername'], "string")) {
      echo json_encode(array("result" => 404, "message" => "Missing or invalid parameter roleUsername"));
      return;
    }

    if(!checkParameter($_POST['roleLevel'], "string")) {
      echo json_encode(array("result" => 404, "message" => "Missing or invalid parameter roleLevel"));
      return;
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

      if(Accounts::modifyUserRole($_POST['roleUsername'], $_POST['roleLevel'])) {
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