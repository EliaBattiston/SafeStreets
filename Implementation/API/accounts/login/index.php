<?php
  include_once(__DIR__."/../../modules/accounts.php");
  include_once(__DIR__."/../../modules/common.php");
  include_once(__DIR__."/../../config.php");
  
  if(isset($_POST['username']) && isset($_POST['password'])) {
    $loggedData = Accounts::login($_POST['username'], $_POST['password']);

    if($loggedData == NULL)
      echo json_encode(array("result" => 401, "message" => "Username and/or password not found"));
    
    else {
      if($loggedData["suspended"] == true)
        echo json_encode(array("result" => 402, "message" => "User suspended"));
      else if($loggedData['acceptedTimestamp'] == NULL)
        echo json_encode(array("result" => 403, "message" => "User not yet validated by administrator"));
      else
        echo json_encode(array("result" => 200, "content" => $loggedData));
    }
  }
  else {
    echo json_encode(array("result" => 404, "message" => "Missing parameters"));
  }
?>