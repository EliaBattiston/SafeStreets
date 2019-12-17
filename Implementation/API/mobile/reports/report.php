<?php
  include_once("../../modules/reports.php");
  include_once("../../modules/accounts.php");
  include_once("../../config.php");
  
  if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    if(isset($_GET['username']) && isset($_GET['password']) && Accounts::isLoggedIn($_GET['username'], $_GET['password'])) {
      if(isset($_GET['reportID']) && intval($_GET['reportID']) > 0) {
        $reportData = Reports::userPastReportDetails($_GET['username'], intval($_GET['reportID']));
        if($reportData != NULL)
          echo json_encode(array("result" => 200, "content" => $reportData));
        else
          echo json_encode(array("result" => 401, "message" => "Report not found"));
      }
      else {
        echo json_encode(array("result" => 402, "message" => "Missing\invalid report ID"));
      } 
    }
    else {
      echo json_encode(array("result" => 503, "message" => "Missing\invalid credentials"));
    }
  }
?>