<?php
  include_once(__DIR__."/../../modules/reports.php");
  include_once(__DIR__."/../../modules/accounts.php");
  include_once(__DIR__."/../../config.php");
  
  if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    if(isset($_GET['username']) && isset($_GET['password']) && Accounts::isLoggedIn($_GET['username'], $_GET['password'])) {
      if(Accounts::isOfficer($_GET['username'])) {
        if(isset($_GET['reportID']) && intval($_GET['reportID']) > 0) {
          $reportData = Reports::pastReportDetails(intval($_GET['reportID']));
          if($reportData != NULL)
            echo json_encode(array("result" => 200, "content" => $reportData));
          else
            echo json_encode(array("result" => 400, "message" => "Report not found"));
        }
        else {
          echo json_encode(array("result" => 200, "content" => Reports::pastReports()));
        }
      }
      else {
        echo json_encode(array("result" => 403, "message" => "User not authorized"));
      }
    }
    else {
      echo json_encode(array("result" => 401, "message" => "Username/password pair is incorrect"));
    }
  }
?>