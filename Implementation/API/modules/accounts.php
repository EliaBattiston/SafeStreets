<?php

  class Accounts{

    //Checks for already registered fiscal code and/or username has aleady been made outside this function
    public static function signup($username, $password, $firstName, $lastName, $fiscalCode, $documentPhoto) {
      if(!is_string($username) || !is_string($password) || !is_string($firstName) || !is_string($lastName) || !is_string($fiscalCode))
        return 404;

      //document photo load is made before the creation of the user so that every problem in loading odesn't influence DB integrity
      $target_dir = __DIR__."/../userDocumentPhotos/";
      umask(0);
      if (!file_exists($target_dir)) {
        mkdir($target_dir, 0775, true);
      }
      if(!is_writable($target_dir)) {
        chmod($target_dir, 0775);
      }

      $target_file = $target_dir . $fiscalCode . ".jpg";
      $regularLoad = file_put_contents($target_file, base64_decode($documentPhoto));

      if(!$regularLoad)
        return 407;

      global $_CONFIG;
      $DBconn = new mysqli($_CONFIG['host'], $_CONFIG['user'], $_CONFIG['pass'], $_CONFIG['dbname']) or die('Connection error');

      //Addition of "safestreets" string at the end of the password to make it difficult the recovery of the password from the hash
      $hashpassword = hash('sha256', $password."safestreets");

      //Prepared statement for SQL injection avoidance
      $statement = $DBconn->prepare("INSERT INTO users (fiscalCode, firstName, lastName, username, passwordHash, role) VALUES (?, ?, ?, ?, ?, 1)");
      $statement->bind_param("sssss", $fiscalCode, $firstName, $lastName, $username, $hashpassword);
      $statement->execute();
      
      if($DBconn->error != NULL) {
        return 400;
      }
      else {
        return 200;
      }
    }

    public static function login($username, $password) {
      if(!is_string($username) || !is_string($password))
        return false;

      global $_CONFIG;
      $DBconn = new mysqli($_CONFIG['host'], $_CONFIG['user'], $_CONFIG['pass'], $_CONFIG['dbname']) or die('Connection error');

      //Addition of "safestreets" string at the end of the password to make it difficult the recovery of the password from the hash
      $hashpassword = hash('sha256', $password."safestreets");

      //Prepared statement for SQL injection avoidance
      $statement = $DBconn->prepare("SELECT fiscalCode, firstName, lastName, username, acceptedTimestamp, suspended, suspendedTimestamp, role AS roleCode, roles.name AS roleDesc FROM users JOIN roles ON users.role = roles.roleID WHERE username=? AND passwordHash=?");
      $statement->bind_param("ss", $username, $hashpassword);
      $statement->execute();
      $result = $statement->get_result();

      if($result->num_rows != 1){
        return NULL;
      }else{
        $data = mysqli_fetch_assoc($result);
        return $data;
      }
    }

    public static function isLoggedIn($username, $password) {
      $result = self::login($username, $password);
      return ($result != NULL && $result['suspended'] == false) ? true : false;
    }

    public static function userData($fiscalCode) {
      global $_CONFIG;
      $DBconn = new mysqli($_CONFIG['host'], $_CONFIG['user'], $_CONFIG['pass'], $_CONFIG['dbname']) or die('Connection error');

      //Prepared statement for SQL injection avoidance
      $statement = $DBconn->prepare("SELECT fiscalCode, firstName, lastName, username, email, suspended, suspendedTimestamp, role AS roleCode, roles.name AS roleDesc, accepterAdmin AS accepterAdminFiscalCode, acceptedTimestamp FROM users JOIN roles ON users.role = roles.roleID WHERE fiscalCode = ?");
      $statement->bind_param("s", $fiscalCode);
      $statement->execute();
      $result = $statement->get_result();

      if($result->num_rows != 1){
        return NULL;
      }else{
        $data = mysqli_fetch_assoc($result);
        $data['documentPhoto'] = "https://safestreets.altervista.org/api/userDocumentPhotos/".$data['fiscalCode'].".jpg";
        return $data;
      }
    }

    public static function userList() {
      global $_CONFIG;
      $DBconn = new mysqli($_CONFIG['host'], $_CONFIG['user'], $_CONFIG['pass'], $_CONFIG['dbname']) or die('Connection error');

      //Prepared statement for SQL injection avoidance
      $statement = $DBconn->prepare("SELECT fiscalCode, firstName, lastName, username, email, acceptedTimestamp, suspended, suspendedTimestamp, role AS roleCode, roles.name AS roleDesc FROM users JOIN roles ON users.role = roles.roleID");
      if(!$statement){
        echo "Prepare failed: (". $DBconn->errno.") ".$DBconn->error."<br>";
      }
      $statement->execute();
      $result = $statement->get_result();

      if($result->num_rows == 0){
        return NULL;
      }else{
        $data = $result->fetch_all(MYSQLI_ASSOC);
        foreach($data as &$record) {
          $record['documentPhoto'] = "https://safestreets.altervista.org/api/userDocumentPhotos/".$record['fiscalCode'].".jpg";
        }
        return $data;
      }
    }

    public static function userFiscalCode($username) {
      global $_CONFIG;
      $DBconn = new mysqli($_CONFIG['host'], $_CONFIG['user'], $_CONFIG['pass'], $_CONFIG['dbname']) or die('Connection error');

      //Prepared statement for SQL injection avoidance
      $statement = $DBconn->prepare("SELECT fiscalCode FROM users WHERE username=?");
      $statement->bind_param("s", $username);
      $statement->execute();
      $result = $statement->get_result();

      if($result->num_rows != 1){
        return NULL;
      }else{
        $data = mysqli_fetch_assoc($result);
        return $data['fiscalCode'];
      }
    }

    public static function userEmail($username) {
      global $_CONFIG;
      $DBconn = new mysqli($_CONFIG['host'], $_CONFIG['user'], $_CONFIG['pass'], $_CONFIG['dbname']) or die('Connection error');

      //Prepared statement for SQL injection avoidance
      $statement = $DBconn->prepare("SELECT email FROM users WHERE username=?");
      $statement->bind_param("s", $username);
      $statement->execute();
      $result = $statement->get_result();

      if($result->num_rows != 1){
        return NULL;
      }else{
        $data = mysqli_fetch_assoc($result);
        return $data['email'];
      }
    }

    public static function userUpdatePassword($username, $newpassword) {
      global $_CONFIG;
      $DBconn = new mysqli($_CONFIG['host'], $_CONFIG['user'], $_CONFIG['pass'], $_CONFIG['dbname']) or die('Connection error');

      $newhashpassword = hash('sha256', $newpassword."safestreets");

      //Prepared statement for SQL injection avoidance
      $statement = $DBconn->prepare("UPDATE users SET passwordHash = ? WHERE username=?");
      $statement->bind_param("ss", $newhashpassword, $username);
      $statement->execute();
    }

    private static function generateRandomString($length) {
      $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
      $charactersLength = strlen($characters);
      $randomString = '';
      for ($i = 0; $i < $length; $i++) {
          $randomString .= $characters[rand(0, $charactersLength - 1)];
      }
      return $randomString;
    }

    public static function userAssignRandomPassword($username) {
      global $_CONFIG;
      $DBconn = new mysqli($_CONFIG['host'], $_CONFIG['user'], $_CONFIG['pass'], $_CONFIG['dbname']) or die('Connection error');

      $newpassword = self::generateRandomString(12);
      $newhashpassword = hash('sha256', $newpassword."safestreets");

      //Prepared statement for SQL injection avoidance
      $statement = $DBconn->prepare("UPDATE users SET passwordHash = ? WHERE username=?");
      $statement->bind_param("ss", $newhashpassword, $username);
      $statement->execute();

      return $newpassword;
    }

    public static function isOfficer($username) {
      return self::userHasRole($username, 2);
    }

    public static function isAdministrator($username) {
      return self::userHasRole($username, 3);
    }

    private static function userHasRole($username, $level) {
      if(!is_string($username))
        return false;

      global $_CONFIG;
      $DBconn = new mysqli($_CONFIG['host'], $_CONFIG['user'], $_CONFIG['pass'], $_CONFIG['dbname']) or die('Connection error');

      //Prepared statement for SQL injection avoidance
      $statement = $DBconn->prepare("SELECT role FROM users WHERE username=?");
      $statement->bind_param("s", $username);
      $statement->execute();
      $result = $statement->get_result();

      if($result->num_rows != 1){
        return false;
      }else{
        $data = mysqli_fetch_assoc($result);
        return $data['role'] >= $level;
      }
    }

    public static function modifyUserRole($username, $roleCode) {
      $fiscalCode = self::userFiscalCode($username);

      if($fiscalCode != NULL) {
        global $_CONFIG;
        $DBconn = new mysqli($_CONFIG['host'], $_CONFIG['user'], $_CONFIG['pass'], $_CONFIG['dbname']) or die('Connection error');

        $statement = $DBconn->prepare("UPDATE users SET role = ? WHERE fiscalCode = ?");
        $statement->bind_param("is", intval($roleCode), $fiscalCode);
        $statement->execute();
        return true;
      }
      else {
        return false;
      }
    }

    public static function acceptUser($username, $administratorUsername) {
      $fiscalCode = self::userFiscalCode($username);
      $adminFiscalCode = self::userFiscalCode($administratorUsername);

      if($fiscalCode != NULL && $adminFiscalCode != NULL) {
        global $_CONFIG;
        $DBconn = new mysqli($_CONFIG['host'], $_CONFIG['user'], $_CONFIG['pass'], $_CONFIG['dbname']) or die('Connection error');

        $statement = $DBconn->prepare("UPDATE users SET accepterAdmin = ?, acceptedTimestamp = CURRENT_TIMESTAMP WHERE fiscalCode = ?");
        $statement->bind_param("ss", $adminFiscalCode, $fiscalCode);
        $statement->execute();
        return true;
      }
      else {
        return false;
      }
    }

    public static function suspendUser($username) {
      $fiscalCode = self::userFiscalCode($username);

      if($fiscalCode != NULL) {
        global $_CONFIG;
        $DBconn = new mysqli($_CONFIG['host'], $_CONFIG['user'], $_CONFIG['pass'], $_CONFIG['dbname']) or die('Connection error');

        $statement = $DBconn->prepare("UPDATE users SET suspended = 1, suspendedTimestamp = CURRENT_TIMESTAMP WHERE fiscalCode = ?");
        $statement->bind_param("s", $fiscalCode);
        $statement->execute();
        return true;
      }
      else {
        return false;
      }
    }

    public static function restoreUser($username) {
      $fiscalCode = self::userFiscalCode($username);

      if($fiscalCode != NULL) {
        global $_CONFIG;
        $DBconn = new mysqli($_CONFIG['host'], $_CONFIG['user'], $_CONFIG['pass'], $_CONFIG['dbname']) or die('Connection error');

        $statement = $DBconn->prepare("UPDATE users SET suspended = 0, suspendedTimestamp = NULL WHERE fiscalCode = ?");
        $statement->bind_param("s", $fiscalCode);
        $statement->execute();
        return true;
      }
      else {
        return false;
      }
    }
  }
?>