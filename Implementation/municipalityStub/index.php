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

        $pastReports = json_decode(file_get_contents(__DIR__.'/data.txt'), true);
        if(is_array($pastReports)) {
          foreach($pastReports as $pastreport) {
            $ticket = array('plate' => $pastreport['plate'], 'location' => ['lat' => $pastreport['lat'], 'lon' => $pastreport['lon']], 'type' => $pastreport['violation']);
            if(rand(1, 10) >= 4)
              array_push($tickets, $ticket);
          }        
          file_put_contents(__DIR__.'/data.txt', "");
        }


        $tickets = [];
        $qty = rand(1, 5);
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

    $pastReports = json_decode(file_get_contents(__DIR__.'/data.txt'), true);
    if($pastReports == NULL || $pastReports == "") {
      $pastReports = [];
    }

    $data = array("fiscal code" => $_POST['userFiscalCode'], "plate" => $_POST['plate'], "violation" => $_POST['violationType'], "lat" => $_POST['latitude'], "lon" => $_POST['longitude']);
    
    array_push($pastReports, $data);
    
    file_put_contents(__DIR__.'/data.txt', json_encode($pastReports));
  }
?>