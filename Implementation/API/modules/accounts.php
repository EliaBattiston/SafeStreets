<?php

  class Accounts{

    //Checks for already registered fiscal code and/or username has aleady been made outside this function
    public static function signup($username, $password, $firstName, $lastName, $fiscalCode, $documentPhoto) {
      if(!is_string($username) || !is_string($password) || !is_string($firstName) || !is_string($lastName) || !is_string($fiscalCode))
        return 404;

      //document photo load is made before the creation of the user so that every problem in loading odesn't influence DB integrity
      $target_dir = __DIR__."/../userDocumentPhotos/";
      if (!file_exists($target_dir)) {
        mkdir($target_dir, 0777, true);
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
      $statement = $DBconn->prepare("SELECT fiscalCode, firstName, lastName, username, suspended, role AS roleCode, roles.name AS roleDesc FROM users JOIN roles ON users.role = roles.roleID WHERE username=? AND passwordHash=?");
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
      $statement = $DBconn->prepare("SELECT fiscalCode, firstName, lastName, username, suspended, role AS roleCode, roles.name AS roleDesc FROM users JOIN roles ON users.role = roles.roleID WHERE fiscalCode = ?");
      $statement->bind_param("s", $fiscalCode);
      $statement->execute();
      $result = $statement->get_result();

      if($result->num_rows != 1){
        return NULL;
      }else{
        $data = mysqli_fetch_assoc($result);
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
  }
?>