<?php
  include_once("../../modules/reports.php");
  include_once("../../modules/accounts.php");
  include_once("../../modules/common.php");
  include_once("../../config.php");
  
  if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    if(isset($_GET['username']) && isset($_GET['password']) && Accounts::isLoggedIn($_GET['username'], $_GET['password'])) {

      if(isset($_GET['reportID']) && intval($_GET['reportID']) > 0) {
        $reportData = Reports::userPastReportDetails($_GET['username'], intval($_GET['reportID']));
        if($reportData != NULL)
          echo json_encode(array("result" => 200, "content" => $reportData));
        else
          echo json_encode(array("result" => 400, "message" => "Report not found"));
      }
      else {
        echo json_encode(array("result" => 200, "content" => Reports::userPastReports($_GET['username'])));
      }
    }
    else {
      echo json_encode(array("result" => 401, "message" => "Username/password pair is incorrect"));
    }
  }

  if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if(isset($_POST['username']) && isset($_POST['password']) && Accounts::isLoggedIn($_POST['username'], $_POST['password'])) {

      if(!checkParameter($_POST["plate"], "string"))
      {
        echo json_encode(array("result" => 404, "message" => "Missing or invalid parameter plate"));
        die();
      }
      if(!checkParameter(intval($_POST["violationType"]), "integer"))
      {
        echo json_encode(array("result" => 404, "message" => "Missing or invalid parameter violationType"));
        die();
      }
      if(!checkParameter(doubleval($_POST["latitude"]), "double"))
      {
        echo json_encode(array("result" => 404, "message" => "Missing or invalid parameter latitude"));
        die();
      }
      if(!checkParameter(doubleval($_POST["longitude"]), "double"))
      {
        echo json_encode(array("result" => 404, "message" => "Missing or invalid parameter longitude"));
        die();
      }
      if(!checkParameter($_POST["pictures"], "string"))
      {
        echo json_encode(array("result" => 404, "message" => "Missing or invalid parameter pictures"));
        die();
      }

      $pictureList = str_replace(" ","+" , json_decode($_POST['pictures'], true));
      $fiscalCode = Accounts::userFiscalCode($_POST['username']);

      $reportResult = Reports::createReport($fiscalCode, $_POST['plate'], $_POST['violationType'], $_POST['latitude'], $_POST['longitude'], $pictureList);

      if($reportResult == 404) {
        echo json_encode(array("result" => 404, "message" => "Invalid parameters"));
        die();
      }
      if($reportResult == 405) {
        echo json_encode(array("result" => 405, "message" => "Error loading pictures"));
        die();
      }

      echo json_encode(array("result" => 200));
    }
    else {
      echo json_encode(array("result" => 401, "message" => "Username/password pair is incorrect"));
    }
  }
?>