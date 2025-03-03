<?php
  include_once(__DIR__."/streets.php");
  include_once(__DIR__."/accounts.php");

  class Reports{
    //Generic SQL query for reports data retrieval
    private static $pastReportsSQL = "SELECT users.username AS username, firstName, lastName, reportID, timestamp, streets.name AS address, latitude, longitude, licensePlate, violations.description AS violation, notes FROM reports JOIN users ON reports.user = users.fiscalCode JOIN streets ON reports.street = streets.streetID JOIN violations ON reports.violation = violations.violationID";

    //Retrieval of an array containing links to the pictures related to parameter's report ID
    private static function reportPictures($reportID) {
      $directory = __DIR__ . "/../reportPictures/".$reportID."/";
      $pictures = scandir($directory, SCANDIR_SORT_ASCENDING);

      $pictureList = [];
      foreach($pictures as $pic) {
        if(strpos($pic, "jpg") != FALSE || strpos($pic, "png") != FALSE) {
          array_push($pictureList, "https://safestreets.altervista.org/api/reportPictures/".$reportID."/".$pic);
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
      if($data != NULL)
        $data['pictures'] = self::reportPictures($reportID);

      return $data;
    }

    public static function userPastReports($username)
    {
      global $_CONFIG;
      $DBconn = new mysqli($_CONFIG['host'], $_CONFIG['user'], $_CONFIG['pass'], $_CONFIG['dbname']) or die('Connection error');

      $statement = $DBconn->prepare("SELECT username, reportID, timestamp, address, latitude, longitude, licensePlate, violation, notes FROM (".self::$pastReportsSQL.") userPastReportDetails WHERE username = ?");
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

      $statement = $DBconn->prepare("SELECT username, reportID, timestamp, address, latitude, longitude, licensePlate, violation, notes FROM (".self::$pastReportsSQL.") userPastReportDetails WHERE username = ? and reportID = ?");
      $statement->bind_param("ss", $username, $reportID);
      $statement->execute();
      $result = $statement->get_result();

      $data = $result->fetch_assoc();
      if($data != NULL)
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

        $reportID = $DBconn->insert_id;

        if($reportID == NULL) {
          return 404;
        }

        $target_dir = __DIR__ . "/../reportPictures/".$reportID."/";
        umask(0);
        if (!file_exists($target_dir)) {
          mkdir($target_dir, 0775, true);
        }
        if(!is_writable($target_dir)) {
          chmod($target_dir, 0775);
        }

        $regularLoad = true;
        $pictureCount = count($pictureList);
        for($i = 0; $i < $pictureCount; $i = $i + 1) {
          $target_file = $target_dir . $reportID . "-pic-" . str_pad($i, 3, '0', STR_PAD_LEFT) . ".jpg";
          $regularLoad = $regularLoad && file_put_contents($target_file, base64_decode($pictureList[$i]));
        }

        if($regularLoad) {

          //Sending data to municipality
          $_SERVER["REQUEST_METHOD"] = "POST";
          unset($_POST);
          $_POST["userFiscalCode"] = $username;
          $_POST["plate"] = $plate;
          $_POST["violationType"] = $violationType;
          $_POST["latitude"] = $latitude;
          $_POST["longitude"] = $longitude;
          $_POST["pictures"] = json_encode($pictureList);
          ob_start();
          
          //For real deployment substitute the string with the municipality endpoint
          $url = __DIR__."/../../municipalityStub/index.php";
          require($url);
          ob_get_clean();

          return 200;
        }
        else {
          self::deleteReport($reportID);
          return 405;
        }
      }
      else {
        return 404;
      }
    }

    private static function deleteReport($reportID) {
      global $_CONFIG;
      $DBconn = new mysqli($_CONFIG['host'], $_CONFIG['user'], $_CONFIG['pass'], $_CONFIG['dbname']) or die('Connection error');

      $statement = $DBconn->prepare("DELETE FROM reports WHERE reportID = ?");
      $statement->bind_param("s", $reportID);
      $statement->execute();
    }

    private static function executeMunicipalityCall($type){
      $_SERVER["REQUEST_METHOD"] = "GET";
      unset($_GET);
      $_GET["type"] = $type;
      ob_start();
      
      //For real deployment substitute the string with the municipality endpoint
      $url = __DIR__."/../../municipalityStub/index.php";

      require($url);
      return json_decode(ob_get_clean(), true);
    }

    private static function getAccidentsFromMunicipality() {
      global $_CONFIG;
      $DBconn = new mysqli($_CONFIG['host'], $_CONFIG['user'], $_CONFIG['pass'], $_CONFIG['dbname']) or die('Connection error');

      $statement = $DBconn->prepare("INSERT INTO accidents (licensePlate, street) VALUES (?, ?)");

      $municipalityData = self::executeMunicipalityCall("accidents");

      foreach($municipalityData as $datum) {
        $streetCode = Streets::getStreet($datum['location']['lat'], $datum['location']['lon']);
        $statement->bind_param("ss", $datum['plate'], $streetCode);
        $statement->execute();
      }
    }

    private static function getTrafficTicketsFromMunicipality() {
      global $_CONFIG;
      $DBconn = new mysqli($_CONFIG['host'], $_CONFIG['user'], $_CONFIG['pass'], $_CONFIG['dbname']) or die('Connection error');

      $statement = $DBconn->prepare("INSERT INTO trafficTickets (licensePlate, street, violation) VALUES (?, ?, ?)");

      $municipalityData = self::executeMunicipalityCall("trafficTickets");

      foreach($municipalityData as $datum) {
        $streetCode = Streets::getStreet($datum['location']['lat'], $datum['location']['lon']);
        $statement->bind_param("sss", $datum['plate'], $streetCode, $datum['type']);
        $statement->execute();
      }
    }

    public static function streetSafety() {
      global $_CONFIG;
      $DBconn = new mysqli($_CONFIG['host'], $_CONFIG['user'], $_CONFIG['pass'], $_CONFIG['dbname']) or die('Connection error');

      self::getAccidentsFromMunicipality();
      self::getTrafficTicketsFromMunicipality();

      $statement = $DBconn->prepare("
        SELECT name, reportsNum, accidentsNum, trafficticketsNum
        FROM streets 
        LEFT JOIN
        (
          SELECT count(*) AS reportsNum, street
          FROM reports
          GROUP by street
        ) AS reportsCount ON streets.streetID = reportsCount.street
        LEFT JOIN 
        (
          SELECT count(*) AS accidentsNum, street 
          FROM accidents
          GROUP by street
        ) AS accidentsCount ON streets.streetID = accidentsCount.street
        LEFT JOIN 
        (
          SELECT count(*) AS trafficticketsNum, street 
          FROM trafficTickets
          GROUP by street
        ) AS trafficTicketsCount ON streets.streetID = trafficTicketsCount.street
      ");
      
      $statement->execute();
      $result = $statement->get_result();
      $reportsCount = $result->fetch_all(MYSQLI_ASSOC);

      $elaboratedData = [];
      for($i = 0, $j = 0; $i < count($reportsCount); $i++) {
        $report = $reportsCount[$i];
        $coordinates = Streets::getStreetCoordinates($report['name']);
        if($coordinates['lat'] != NULL && $coordinates['lng'] != NULL) {
          $elaboratedData[$j] = [];
          $elaboratedData[$j]['address'] = $report['name'];
          
          $elaboratedData[$j]['latitude'] = $coordinates['lat'];
          $elaboratedData[$j]['longitude'] = $coordinates['lng'];

          $reports = $report['reportsNum'] == NULL ? 0 : $report['reportsNum'];
          $accidents = $report['accidentsNum'] == NULL ? 0 : $report['accidentsNum'];
          $tickets = $report['trafficticketsNum'] == NULL ? 0 : $report['trafficticketsNum'];
          $elaboratedData[$j]['content'] = "SafeStreets reports: ".$reports.", accidents: ".$accidents.", emitted traffic tickets: ".$tickets;

          $sum = $reports + $accidents + $tickets;
          if($sum >= 25) {
            $elaboratedData[$j]['severity'] = "High";
          }
          else {
            if($sum >= 12) {
              $elaboratedData[$j]['severity'] = "Medium";
            }
            else {
              $elaboratedData[$j]['severity'] = "Low";
            }
          }
          $j++;
        }
      }

      return $elaboratedData;
    }
  }
?>