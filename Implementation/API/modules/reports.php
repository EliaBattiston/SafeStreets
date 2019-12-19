<?php
  include_once("streets.php");

  class Reports{
    private static $pastReportsSQL = "SELECT users.username AS username, firstName, lastName, reportID, timestamp, streets.name AS address, licensePlate, violations.description AS violation, notes FROM reports JOIN users ON reports.user = users.fiscalCode JOIN streets ON reports.street = streets.streetID JOIN violations ON reports.violation = violations.violationID";
    public static function pastReports()
    {
      global $_CONFIG;
      $DBconn = new mysqli($_CONFIG['host'], $_CONFIG['user'], $_CONFIG['pass'], $_CONFIG['dbname']) or die('Connection error');

      $statement = $DBconn->prepare(self::$pastReportsSQL);
      $statement->execute();
      $result = $statement->get_result();

      $data = $result->fetch_all(MYSQLI_ASSOC);
      return $data;
    }

    public static function userPastReports($username)
    {
      global $_CONFIG;
      $DBconn = new mysqli($_CONFIG['host'], $_CONFIG['user'], $_CONFIG['pass'], $_CONFIG['dbname']) or die('Connection error');

      $statement = $DBconn->prepare("SELECT * FROM (".self::$pastReportsSQL.") userPastReports WHERE username = ?");
      $statement->bind_param("s", $username);
      $statement->execute();
      $result = $statement->get_result();

      $data = $result->fetch_all(MYSQLI_ASSOC);
      return $data;
    }

    public static function userPastReportDetails($username, $reportID)
    {
      global $_CONFIG;
      $DBconn = new mysqli($_CONFIG['host'], $_CONFIG['user'], $_CONFIG['pass'], $_CONFIG['dbname']) or die('Connection error');

      $statement = $DBconn->prepare("SELECT * FROM (".self::$pastReportsSQL.") userPastReportDetails WHERE username = ? and reportID = ?");
      $statement->bind_param("ss", $username, $reportID);
      $statement->execute();
      $result = $statement->get_result();

      $data = $result->fetch_all(MYSQLI_ASSOC);
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

      $data = $result->fetch_all(MYSQLI_ASSOC);
      return $data;
    }

    public static function createReport($username, $plate, $violationType, $latitude, $longitude, $pictureList) {
      if(gettype($username) == "string" && gettype($plate == "string") && intval($violationType) > 0 
          && gettype($pictureList) == "array" && count($pictureList) > 0) {

        $streetCode = Streets::getStreet($latitude, $longitude);

        global $_CONFIG;
        $DBconn = new mysqli($_CONFIG['host'], $_CONFIG['user'], $_CONFIG['pass'], $_CONFIG['dbname']) or die('Connection error');

        $statement = $DBconn->prepare("INSERT INTO reports (user, violation, licensePlate, street, latitude, longitude) VALUES (?, ?, ?, ?, ?, ?)");
        $statement->bind_param("sisidd", $username, intval($violationType), $plate, $streetCode, floatval($latitude), floatval($longitude));
        $statement->execute();
        $result = $statement->get_result();

        return $DBconn->insert_id;
      }
      else {
        return NULL;
      }
    }
  }
?>