<?php
  
  if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    if(isset($_GET['type'])) {
      $plates = ['AA000BB', 'CC111DD', 'EE333FF', 'GG444HH', 'II555JJ', 'KK666LL', 'MM777NN', 'OO888PP', 'QQ999RRR'];
      $locations = [['lat' => 45.812633, 'lon' => 8.823236], ['lat' => 45.694372, 'lon' => 8.818407], ['lat' => 45.663143, 'lon' => 8.789133], 
                    ['lat' => 45.630874, 'lon' => 8.787772], ['lat' => 45.502313, 'lon' => 8.158128], ['lat' => 45.478281, 'lon' => 8.166513]];
      
      if($_GET['type'] == "accidents") {
        $accidents = [];
        $qty = rand(2, 7);
        for($i = 0; $i < $qty; $i++) {
          $accident = array('plate' => $plates[rand(0, count($plates) - 1)], 'location' => $locations[rand(0, count($locations) - 1)]);
          array_push($accidents, $accident);
        }
        echo json_encode($accidents);
      }
      if($_GET['type'] == "trafficTickets") {
        $tickets = [];
        $qty = rand(3, 8);
        for($i = 0; $i < $qty; $i++) {
          $ticket = array('plate' => $plates[rand(0, count($plates) - 1)], 'location' => $locations[rand(0, count($locations) - 1)], 'type' => rand(1, 10));
          array_push($tickets, $ticket);
        }
        echo json_encode($tickets);
      }
    }
    else {
      http_response_code(422);
    }
  }

  if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if(!isset($_POST["userFiscalCode"]))
    {
      http_response_code(422);
    }
    if(!isset($_POST["plate"]))
    {
      http_response_code(422);
    }
    if(!isset($_POST["violationType"]))
    {
      http_response_code(422);
    }
    if(!isset($_POST["latitude"]))
    {
      http_response_code(422);
    }
    if(!isset($_POST["longitude"]))
    {
      http_response_code(422);
    }
    if(!isset($_POST["pictures"]))
    {
      http_response_code(422);
    }

    $data = "Fiscal code: ".$_POST['userFiscalCode']."\nPlate: ".$_POST['plate']."\nViolation type: ".$_POST['violationType']."\nLatitude: ".$_POST['latitude']."\nLongitude: ".$_POST['longitude']."Pictures: \n\n".$_POST['pictures'];
    file_put_contents(__DIR__.'/data.txt', $data);
  }
?>