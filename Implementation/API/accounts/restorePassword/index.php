<?php
  include_once(__DIR__."/../../modules/accounts.php");
  include_once(__DIR__."/../../modules/common.php");
  include_once(__DIR__."/../../config.php");
  
  if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    if(checkParameter($_GET['username'], "string")) {

      $username = $_GET['username'];
      $userEmail = Accounts::userEmail($username);

      if($userEmail == NULL)
        echo json_encode(array("result" => 401, "message" => "Username not found"));
      
      else {
        $newPassword = Accounts::userAssignRandomPassword($username);
        $subject = "SafeStreets - password retrieval";
        $msg = "Good morning,\nAs required, here you can find your new access password to Safestreets system:\n\n".$newPassword."\n\n\nBest regards,\nSafeStreets team";
        //$msg = wordwrap($msg,70);
        $headers = "From: \"SafeStreets System\" <safestreets@altervista.org>";

        $mailSend = mail($userEmail,$subject,$msg,$headers);
        if($mailSend)
          echo json_encode(array("result" => 200));
        else
          echo json_encode(array("result" => 400, "message" => "Error in sending mail"));
      }
    }
    else {
      echo json_encode(array("result" => 404, "message" => "Missing parameters"));
    }
  }


  if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if(isset($_POST['username']) && isset($_POST['password'])) {
      $loggedData = Accounts::login($_POST['username'], $_POST['password']);

      if($loggedData == NULL)
        echo json_encode(array("result" => 401, "message" => "Username and/or password not found"));
      
      else {
        if(checkParameter($_POST['newPassword'], "string")) {
          Accounts::userUpdatePassword($_POST['username'], $_POST['newPassword']);
          echo json_encode(array("result" => 200));
        }
        else
          echo json_encode(array("result" => 404, "message" => "Missing parameter newPassword"));
      }
    }
    else {
      echo json_encode(array("result" => 404, "message" => "Missing parameters"));
    }
  }
?>