<?php
  include_once(__DIR__."/../../modules/reports.php");
  include_once(__DIR__."/../../modules/accounts.php");
  include_once(__DIR__."/../../modules/common.php");
  include_once(__DIR__."/../../config.php");
  
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
        $reports = Reports::userPastReports($_GET['username']);
        if(count($reports) > 0)
          echo json_encode(array("result" => 200, "content" => $reports));
        else
          echo json_encode(array("result" => 201, "content" => "Report list is empty"));
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
        return;
      }
      if(!checkParameter(intval($_POST["violationType"]), "integer"))
      {
        echo json_encode(array("result" => 404, "message" => "Missing or invalid parameter violationType"));
        return;
      }
      if(!checkParameter(doubleval($_POST["latitude"]), "double"))
      {
        echo json_encode(array("result" => 404, "message" => "Missing or invalid parameter latitude"));
        return;
      }
      if(!checkParameter(doubleval($_POST["longitude"]), "double"))
      {
        echo json_encode(array("result" => 404, "message" => "Missing or invalid parameter longitude"));
        return;
      }
      if(!checkParameter($_POST["pictures"], "string"))
      {
        echo json_encode(array("result" => 404, "message" => "Missing or invalid parameter pictures"));
        return;
      }

      $pictureList = str_replace(" ","+" , json_decode($_POST['pictures'], true));
      $fiscalCode = Accounts::userFiscalCode($_POST['username']);

      $reportResult = Reports::createReport($fiscalCode, $_POST['plate'], $_POST['violationType'], str_replace(",", ".", $_POST['latitude']), str_replace(",", ".", $_POST['longitude']), $pictureList);

      if($reportResult == 404) {
        echo json_encode(array("result" => 404, "message" => "Invalid parameters"));
        return;
      }
      if($reportResult == 405) {
        echo json_encode(array("result" => 405, "message" => "Error loading pictures"));
        return;
      }

      echo json_encode(array("result" => 200));
    }
    else {
      echo json_encode(array("result" => 401, "message" => "Username/password pair is incorrect"));
    }
  }
?>