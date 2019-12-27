<?php
  include_once("streets.php");

  class Reports{
    //Generic SQL query for reports data retrieval
    private static $pastReportsSQL = "SELECT users.username AS username, firstName, lastName, reportID, timestamp, streets.name AS address, licensePlate, violations.description AS violation, notes FROM reports JOIN users ON reports.user = users.fiscalCode JOIN streets ON reports.street = streets.streetID JOIN violations ON reports.violation = violations.violationID";

    //Retrieval of an array containing links to the pictures related to parameter's report ID
    private static function reportPictures($reportID) {
      $directory = "../../reportPictures/".$reportID."/";
      $pictures = scandir($directory, SCANDIR_SORT_ASCENDING);

      $pictureList = [];
      foreach($pictures as $pic) {
        if(strpos($pic, "jpg") != FALSE || strpos($pic, "png") != FALSE) {
          array_push($pictureList, $_SERVER['HTTP_HOST']."/reportPictures/".$reportID."/".$pic);
        }
      }
      
      return $pictureList;
    }

    public static function pastReports()
    {
      global $_CONFIG;
      $DBconn = new mysqli($_CONFIG['host'], $_CONFIG['user'], $_CONFIG['pass'], $_CONFIG['dbname']) or die('Connection error');

      $statement = $DBconn->prepare("SELECT reportID, username, timestamp, violation, address, licensePlate, notes FROM (".self::$pastReportsSQL.") userPastReports");
      $statement->execute();
      $result = $statement->get_result();

      $data = $result->fetch_all(MYSQLI_ASSOC);

      foreach($data as &$record) {
        $record['pictures'] = self::reportPictures($record['reportID']);
      }

      return $data;
    }

    public static function pastReportDetails($reportID)
    {
      global $_CONFIG;
      $DBconn = new mysqli($_CONFIG['host'], $_CONFIG['user'], $_CONFIG['pass'], $_CONFIG['dbname']) or die('Connection error');

      $statement = $DBconn->prepare("SELECT * FROM (".self::$pastReportsSQL.") pastReports WHERE reportID = ?");
      $statement->bind_param("s", $reportID);
      $statement->execute();
      $result = $statement->get_result();

      $data = $result->fetch_assoc();
      $data['pictures'] = self::reportPictures($reportID);

      return $data;
    }

    public static function userPastReports($username)
    {
      global $_CONFIG;
      $DBconn = new mysqli($_CONFIG['host'], $_CONFIG['user'], $_CONFIG['pass'], $_CONFIG['dbname']) or die('Connection error');

      $statement = $DBconn->prepare("SELECT reportID, violation, address, timestamp FROM (".self::$pastReportsSQL.") userPastReports WHERE username = ?");
      $statement->bind_param("s", $username);
      $statement->execute();
      $result = $statement->get_result();

      $data = $result->fetch_all(MYSQLI_ASSOC);

      foreach($data as &$record) {
        $record['pictures'] = self::reportPictures($record['reportID']);
      }      

      return $data;
    }

    public static function userPastReportDetails($username, $reportID)
    {
      global $_CONFIG;
      $DBconn = new mysqli($_CONFIG['host'], $_CONFIG['user'], $_CONFIG['pass'], $_CONFIG['dbname']) or die('Connection error');

      $statement = $DBconn->prepare("SELECT reportID, violation, address, timestamp, licensePlate, notes FROM (".self::$pastReportsSQL.") userPastReportDetails WHERE username = ? and reportID = ?");
      $statement->bind_param("ss", $username, $reportID);
      $statement->execute();
      $result = $statement->get_result();

      $data = $result->fetch_assoc();
      $data['pictures'] = self::reportPictures($reportID);

      return $data;
    }

    public static function createReport($username, $plate, $violationType, $latitude, $longitude, $pictureList) {
      if(gettype($username) == "string" && gettype($plate) == "string" && intval($violationType) > 0 
          && gettype($pictureList) == "array" && count($pictureList) > 0) {

        $streetCode = Streets::getStreet($latitude, $longitude);

        global $_CONFIG;
        $DBconn = new mysqli($_CONFIG['host'], $_CONFIG['user'], $_CONFIG['pass'], $_CONFIG['dbname']) or die('Connection error');

        $statement = $DBconn->prepare("INSERT INTO reports (user, violation, licensePlate, street, latitude, longitude) VALUES (?, ?, ?, ?, ?, ?)");
        $statement->bind_param("sisidd", $username, intval($violationType), $plate, $streetCode, floatval($latitude), floatval($longitude));
        $statement->execute();
        $result = $statement->get_result();

        $reportID = $DBconn->insert_id;

        if($reportID == NULL) {
          return 404;
        }

        $target_dir = "../../reportPictures/".$reportID."/";
        if (!file_exists($target_dir)) {
          mkdir($target_dir, 0777, true);
        }

        $regularLoad = true;
        $pictureCount = count($pictureList);
        for($i = 0; $i < $pictureCount; $i = $i + 1) {
          $target_file = $target_dir . $reportID . "-pic-" . str_pad($i, 3, '0', STR_PAD_LEFT) . ".jpg";
          $regularLoad = $regularLoad && file_put_contents($target_file, base64_decode($pictureList[$i]));
        }

        if($regularLoad)
          return 200;
        else {
          self::deleteReport($reportID);
          return 405;
        }
      }
      else {
        return NULL;
      }
    }

    public static function deleteReport($reportID) {
      global $_CONFIG;
      $DBconn = new mysqli($_CONFIG['host'], $_CONFIG['user'], $_CONFIG['pass'], $_CONFIG['dbname']) or die('Connection error');

      $statement = $DBconn->prepare("DELETE FROM reports WHERE reportID = ?");
      $statement->bind_param("s", $reportID);
      $statement->execute();
    }
  }
?>