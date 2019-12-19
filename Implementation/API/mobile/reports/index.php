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
        echo json_encode(array("result" => 404, "message" => "Missing/invalid parameter plate"));
        die();
      }
      if(!checkParameter(intval($_POST["violationType"]), "integer"))
      {
        echo json_encode(array("result" => 404, "message" => "Missing/invalid parameter violationType"));
        die();
      }
      if(!checkParameter(doubleval($_POST["latitude"]), "double"))
      {
        echo json_encode(array("result" => 404, "message" => "Missing/invalid parameter latitude"));
        die();
      }
      if(!checkParameter(doubleval($_POST["longitude"]), "double"))
      {
        echo json_encode(array("result" => 404, "message" => "Missing/invalid parameter longitude"));
        die();
      }
      if(!checkParameter($_POST["pictures"], "string"))
      {
        echo json_encode(array("result" => 404, "message" => "Missing/invalid parameter pictures"));
        die();
      }
      if(!checkParameter(intval($_POST["pictureCount"]), "integer"))
      {
        echo json_encode(array("result" => 404, "message" => "Missing/invalid parameter pictureCount"));
        die();
      }
      $pictureCount = intval($_POST['pictureCount']);
      $pictureList = str_replace(" ","+" , json_decode($_POST['pictures'], true));
      $fiscalCode = Accounts::userFiscalCode($_POST['username']);

      $reportID = Reports::createReport($fiscalCode, $_POST['plate'], $_POST['violationType'], $_POST['latitude'], $_POST['longitude'], $pictureList);

      if($reportID != NULL) {
        $target_dir = "../../reportPictures/".$reportID."/";
        if (!file_exists($target_dir)) {
          mkdir($target_dir, 0777, true);
        }

        $regularLoad = true;
        for($i = 0; $i < $pictureCount; $i = $i + 1) {
          $target_file = $target_dir . $reportID . "-pic-" . str_pad($i, 3, '0', STR_PAD_LEFT) . ".jpg";
          $regularLoad = $regularLoad && file_put_contents($target_file, base64_decode($pictureList[$i]));
        }

        if($regularLoad)
          echo json_encode(array("result" => 200));
        else {
          Reports::deleteReport($reportID);
          echo json_encode(array("result" => 405, "message" => "Error loading pictures"));
        }
      }
      else {
        echo json_encode(array("result" => 404, "message" => "Invalid parameters"));
      }
    }
    else {
      echo json_encode(array("result" => 401, "message" => "Username/password pair is incorrect"));
    }
  }
?>