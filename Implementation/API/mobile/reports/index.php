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
      if(isset($_POST['plate']) && isset($_POST['violationType']) && isset($_POST['latitude']) && isset($_POST['longitude']) && isset($_POST['pictureCount']) && intval($_POST['pictureCount']) > 0) {
        $pictureList = [];
        $pictureCount = intval($_POST['pictureCount']);
        for($i = 0; $i < $pictureCount; $i = $i + 1) {
          array_push($pictureList, $_FILES["picture-".$i]["tmp_name"]);
        }

        $reportID = Reports::createReport($_POST['username'], $_POST['plate'], $_POST['violationType'], $_POST['latitude'], $_POST['longitude'], $pictureList);

        if($reportID != NULL) {
          $target_dir = "../../reportPictures/".$reportID."/";
          if (!file_exists($target_dir)) {
            mkdir($target_dir, 0777, true);
          }

          $regularLoad = true;
          for($i = 0; $i < $pictureCount; $i = $i + 1) {
            $target_file = $target_dir . $reportID . "-pic-" . str_pad($i, 3, '0', STR_PAD_LEFT) . "." . strtolower(pathinfo($_FILES["fileToUpload"]["name"],PATHINFO_EXTENSION));
            $regularLoad = $regularLoad && move_uploaded_file($_FILES["picture-".$i]["tmp_name"], $target_file);
          }

          if($regularLoad)
            echo json_encode(array("result" => 200));
          else
            echo json_encode(array("result" => 404, "message" => "Error loading pictures"));
        }
        else {
          echo json_encode(array("result" => 403, "message" => "Missing or invalid parameters"));
        }
        
      }
      else
        echo json_encode(array("result" => 403, "message" => "Missing or invalid parameters"));
    }
    else {
      echo json_encode(array("result" => 401, "message" => "Username/password pair is incorrect"));
    }
  }
?>