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


    if ($_SERVER['REQUEST_METHOD'] === 'GET') {
      $usersData = Accounts::userList();
        if($usersData != NULL)
          echo json_encode(array("result" => 200, "content" => $usersData));
        else
          echo json_encode(array("result" => 400, "message" => "No users found in system"));
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      if(!checkParameter($_POST["newusername"], "string"))
      {
        echo json_encode(array("result" => 404, "message" => "Missing or invalid parameter username"));
        die();
      }
      if(!checkParameter($_POST["newpassword"], "string"))
      {
        echo json_encode(array("result" => 404, "message" => "Missing or invalid parameter password"));
        die();
      }
      if(!checkParameter($_POST["firstName"], "string"))
      {
        echo json_encode(array("result" => 404, "message" => "Missing or invalid parameter firstName"));
        die();
      }
      if(!checkParameter($_POST["lastName"], "string"))
      {
        echo json_encode(array("result" => 404, "message" => "Missing or invalid parameter lastName"));
        die();
      }
      if(!checkParameter($_POST["email"], "string"))
      {
        echo json_encode(array("result" => 404, "message" => "Missing or invalid parameter email"));
        die();
      }
      if(!checkParameter($_POST["fiscalCode"], "string"))
      {
        echo json_encode(array("result" => 404, "message" => "Missing or invalid parameter fiscalCode"));
        die();
      }
      if(!checkParameter($_POST["documentPhoto"], "string"))
        {
          echo json_encode(array("result" => 404, "message" => "Missing or invalid parameter documentPhoto"));
          die();
        }

      $documentPhoto = str_replace(" ","+" , json_decode($_POST['documentPhoto'], true));
      $fiscalCode = $_POST["fiscalCode"];
      $username = $_POST["newusername"];

      if(Accounts::userData($fiscalCode) != NULL) {
        echo json_encode(array("result" => 405, "message" => "Fiscal code already registered"));
        die();
      }
      if(Accounts::userFiscalCode($username) != NULL) {
        echo json_encode(array("result" => 406, "message" => "Username already in use"));
        die();
      }

      $creationCheck = Accounts::signup($username, $_POST["newpassword"], $_POST["firstName"], $_POST["lastName"], $fiscalCode, $documentPhoto);

      if($creationCheck == 200) {
        echo json_encode(array("result" => 200));
        die();
      }
      if($creationCheck == 404) {
        echo json_encode(array("result" => 404, "message" => "Invalid parameters"));
        die();
      }
      if($creationCheck == 407) {
        echo json_encode(array("result" => 407, "message" => "Error loading picture"));
        die();
      }

      echo json_encode(array("result" => 400, "message" => "Generic error in insertion, retry"));

    }
  }
?>