<?php
  include_once(__DIR__."/../../modules/reports.php");
  include_once(__DIR__."/../../modules/accounts.php");
  include_once(__DIR__."/../../modules/common.php");
  include_once(__DIR__."/../../config.php");
  
  if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    if(isset($_GET['username']) && isset($_GET['password']) && Accounts::isLoggedIn($_GET['username'], $_GET['password'])) {
      $reports = Reports::streetSafety();

      if(count($reports) > 0)
        echo json_encode(array("result" => 200, "content" => $reports));
      else
        echo json_encode(array("result" => 201, "content" => "Report list is empty"));
    }
    else {
      echo json_encode(array("result" => 401, "message" => "Username/password pair is incorrect"));
    }
  }

?>