<?php
  include_once("../../modules/reports.php");
  include_once("../../modules/accounts.php");
  include_once("../../config.php");
  
  if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    if(isset($_GET['username']) && isset($_GET['password']) && Accounts::isLoggedIn($_GET['username'], $_GET['password'])) {
      echo json_encode(array("result" => 200, "content" => Reports::userPastReports($_GET['username'])));
    }
    else {
      echo json_encode(array("result" => 503, "message" => "Missing/invalid credentials"));
    }
  }
?>