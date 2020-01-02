<?php
  include_once(__DIR__."/../../modules/accounts.php");
  include_once(__DIR__."/../../modules/common.php");
  include_once(__DIR__."/../../config.php");
  $accounts = new Accounts;
  
  if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    if(isset($_GET['username']) && isset($_GET['password']) && Accounts::isLoggedIn($_GET['username'], $_GET['password']))
    {
      if(!Accounts::isAdministrator($_GET['username'])) {
        echo json_encode(array("result" => 403, "message" => "User not authorized"));
        return;
      }

      if(isset($_GET['userFiscalCode'])) {
        $userData = Accounts::userData($_GET['userFiscalCode']);
        if($userData != NULL)
          echo json_encode(array("result" => 200, "content" => $userData));
        else
          echo json_encode(array("result" => 400, "message" => "User not found"));
      }
      else {
        $usersData = Accounts::userList();
        if($usersData != NULL)
          echo json_encode(array("result" => 200, "content" => $usersData));
        else
          echo json_encode(array("result" => 400, "message" => "No users found in system"));
      }
    }
    else
    {
      echo json_encode(array("result" => 401, "message" => "Username and/or password not found"));
    }
  }

  if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if(isset($_POST['username']) && isset($_POST['password']) && Accounts::isLoggedIn($_POST['username'], $_POST['password']))
    {
      if(!Accounts::isAdministrator($_POST['username'])) {
        echo json_encode(array("result" => 403, "message" => "User not authorized"));
        return;
      }
      
      if(!checkParameter($_POST["newusername"], "string"))
      {
        echo json_encode(array("result" => 404, "message" => "Missing or invalid parameter username"));
        return;
      }
      if(!checkParameter($_POST["newpassword"], "string"))
      {
        echo json_encode(array("result" => 404, "message" => "Missing or invalid parameter password"));
        return;
      }
      if(!checkParameter($_POST["firstName"], "string"))
      {
        echo json_encode(array("result" => 404, "message" => "Missing or invalid parameter firstName"));
        return;
      }
      if(!checkParameter($_POST["lastName"], "string"))
      {
        echo json_encode(array("result" => 404, "message" => "Missing or invalid parameter lastName"));
        return;
      }
      if(!checkParameter($_POST["email"], "string"))
      {
        echo json_encode(array("result" => 404, "message" => "Missing or invalid parameter email"));
        return;
      }
      if(!checkParameter($_POST["fiscalCode"], "string"))
      {
        echo json_encode(array("result" => 404, "message" => "Missing or invalid parameter fiscalCode"));
        return;
      }
      if(!checkParameter($_POST["documentPhoto"], "string"))
        {
          echo json_encode(array("result" => 404, "message" => "Missing or invalid parameter documentPhoto"));
          return;
        }

      $documentPhoto = str_replace(" ","+" , json_decode($_POST['documentPhoto'], true));
      $fiscalCode = $_POST["fiscalCode"];
      $username = $_POST["newusername"];

      if(Accounts::userData($fiscalCode) != NULL) {
        echo json_encode(array("result" => 405, "message" => "Fiscal code already registered"));
        return;
      }
      if(Accounts::userFiscalCode($username) != NULL) {
        echo json_encode(array("result" => 406, "message" => "Username already in use"));
        return;
      }

      $creationCheck = Accounts::signup($username, $_POST["newpassword"], $_POST["firstName"], $_POST["lastName"], $fiscalCode, $documentPhoto);

      if($creationCheck == 200) {
        echo json_encode(array("result" => 200));
        return;
      }
      if($creationCheck == 404) {
        echo json_encode(array("result" => 404, "message" => "Invalid parameters"));
        return;
      }
      if($creationCheck == 407) {
        echo json_encode(array("result" => 407, "message" => "Error loading picture"));
        return;
      }

      echo json_encode(array("result" => 400, "message" => "Generic error in insertion, retry"));
    }
    else
    {
      echo json_encode(array("result" => 401, "message" => "Username and/or password not found"));
    }
  }
?>