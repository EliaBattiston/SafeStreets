<?php
  include_once("../../modules/accounts.php");
  include_once("../../modules/common.php");
  include_once("../../config.php");
  $accounts = new Accounts;
  
  if(isset($_POST['username']) && isset($_POST['password'])) {
    $loggedData = $accounts->login($_POST['username'], $_POST['password']);

    if($loggedData == NULL)
      echo json_encode(array("result" => 401, "message" => "Username and/or password not found"));
    
    else {
      if($loggedData["suspended"] == true)
        echo json_encode(array("result" => 402, "message" => "User suspended"));
      else
        echo json_encode(array("result" => 200, "content" => $loggedData));
    }
  }
  else {
    echo json_encode(array("result" => 404, "message" => "Missing parameters"));
  }
?>