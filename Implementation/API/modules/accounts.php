<?php

  class Accounts{
    public static function login($username, $password)
    {
      if(!is_string($username) || !is_string($password))
        return false;

      global $_CONFIG;
      $DBconn = new mysqli($_CONFIG['host'], $_CONFIG['user'], $_CONFIG['pass'], $_CONFIG['dbname']) or die('Connection error');

      //Addition of "safestreets" string at the end of the password to make it difficult the recovery of the password from the hash
      $hashpassword = hash('sha256', $password."safestreets");

      //Prepared statement for SQL injection avoidance
      $statement = $DBconn->prepare("SELECT fiscalCode, firstName, lastName, username, suspended FROM users WHERE username=? AND passwordHash=?");
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
  }
?>