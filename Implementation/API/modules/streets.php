<?php

  class Streets{
    //Retrieval of human-readable address of the street from geographic coordinates
    private static function getStreetAddress($latitude, $longitude)
    {
      $curl = curl_init();

      //GET request to Google Geocoding APIs
      curl_setopt_array($curl, array(
        CURLOPT_URL => "https://maps.googleapis.com/maps/api/geocode/json?latlng=".$latitude.",".$longitude."&result_type=street_address&key=AIzaSyBa6W0ZackhaU-LpREjigObsqtm_r0ZUQM",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "GET",
        CURLOPT_HTTPHEADER => array(
          "cache-control: no-cache"
        ),
      ));

      $response = curl_exec($curl);
      $err = curl_error($curl);

      curl_close($curl);

      //Decoding of geocoding answer, filtering of the address
      $response = json_decode($response, true);
      $address = $response['results'][0]['formatted_address'];

      //Removal of the street number retrieved from the reverse geocoding
      $address = preg_replace("/(.*)(, \w+,)(.*)/", "$1,$3", $address);
      
      return $address;
    }

    //Retrieval of geographic coordinates of the street from human-readable address
    public static function getStreetCoordinates($address)
    {
      $curl = curl_init();

      $address = str_replace(" ", "+", $address);

      //GET request to Google Geocoding APIs
      curl_setopt_array($curl, array(
        CURLOPT_URL => "https://maps.googleapis.com/maps/api/geocode/json?address=".$address."&key=AIzaSyBa6W0ZackhaU-LpREjigObsqtm_r0ZUQM",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "GET",
        CURLOPT_HTTPHEADER => array(
          "cache-control: no-cache"
        ),
      ));

      $response = curl_exec($curl);
      $err = curl_error($curl);

      curl_close($curl);

      //Decoding of geocoding answer, filtering of the address
      $response = json_decode($response, true);

      if($response['results'][0] == NULL) {
        echo $address."<br>";
        var_dump($response);
      }

      $result = [];
      $result['lat'] = $response['results'][0]['geometry']['location']['lat'];
      $result['lng'] = $response['results'][0]['geometry']['location']['lng'];
      
      return $result;
    }

    //Retrieval of the assigned SafeStreets street encoding from human-readable address
    private static function getStreetID($streetAddress) {
      global $_CONFIG;
      $DBconn = new mysqli($_CONFIG['host'], $_CONFIG['user'], $_CONFIG['pass'], $_CONFIG['dbname']) or die('Connection error');

      $statement = $DBconn->prepare("SELECT streetID FROM streets WHERE name = ?");
      $statement->bind_param("s", $streetAddress);
      $statement->execute();
      $result = $statement->get_result();
      $streetID = mysqli_fetch_assoc($result)['streetID'];
      if($streetID != NULL) {
        return $streetID;
      }
      else {
        //If record is missing creation of the record and retrieval of the created code
        return self::createStreet($streetAddress);
      }
    }

    //Insertion of a street in SafeStreets database
    private static function createStreet($streetAddress) {
      global $_CONFIG;
      $DBconn = new mysqli($_CONFIG['host'], $_CONFIG['user'], $_CONFIG['pass'], $_CONFIG['dbname']) or die('Connection error');

      $statement = $DBconn->prepare("INSERT INTO streets (streets.name) VALUES (?)");
      $statement->bind_param("s", $streetAddress);
      $statement->execute();
      return $DBconn->insert_id;
    }

    //Public function for retrieving street code from geocoordinates
    public static function getStreet($latitude, $longitude) {
      $address = self::getStreetAddress($latitude, $longitude);
      return self::getStreetID($address);
    }
  }
?>