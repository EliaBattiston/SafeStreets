<?php
  include_once(__DIR__."/../../modules/accounts.php");
  include_once(__DIR__."/../../modules/common.php");
  include_once(__DIR__."/../../config.php");
  $accounts = new Accounts;
  
  if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if(!checkParameter($_POST["username"], "string"))
    {
      echo json_encode(array("result" => 404, "message" => "Missing or invalid parameter username"));
      die();
    }
    if(!checkParameter($_POST["password"], "string"))
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
    $username = $_POST["username"];

    if(Accounts::userData($fiscalCode) != NULL) {
      echo json_encode(array("result" => 405, "message" => "Fiscal code already registered"));
      die();
    }
    if(Accounts::userFiscalCode($username) != NULL) {
      echo json_encode(array("result" => 406, "message" => "Username already in use"));
      die();
    }

    $creationCheck = Accounts::signup($username, $_POST["password"], $_POST["firstName"], $_POST["lastName"], $fiscalCode, $documentPhoto);

    if($creationCheck == 200) {
      echo json_encode(array("result" => 200));
      die();
    }
    if($creationCheck == 404) {
      echo json_encode(array("result" => 404, "message" => "Invalid parameters"));
      die();
    }
    if($creationCheck == 407) {
      echo json_encode(array("result" => 407, "message" => "Error loading pictures"));
      die();
    }

    echo json_encode(array("result" => 400, "message" => "Generic error in insertion, retry"));

  }
?>