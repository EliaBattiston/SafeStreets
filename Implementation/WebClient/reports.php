<?php
    include("components/checks.php");
    include_once(__DIR__ . "/config.php");
?>

<!DOCTYPE html>
<html>

<head>
    <title>SafeStreets Reports</title>
    <?php include("components/header.php") ?>
</head>
<body>
    <?php include("components/menu.php") ?>

    <div class="ui container">
        <table class="ui celled table" style="margin-top: 50px;">
            <thead>
                <tr>
                    <th>Username</th>
                    <th>Location</th>
                    <th>Timestamp</th>
                    <th>Type</th>
                    <th>Photos</th>
                    <th>License plate</th>
                    <th>Notes</th>
                </tr>
            </thead>
            <?php
                $ch = curl_init();

                $query = http_build_query(
                    array(
                        "username" => $_COOKIE["username"],
                        "password" => $_COOKIE["password"]
                    )
                );
                curl_setopt($ch, CURLOPT_URL, $endpoint."/web/reports/?".$query);
                
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                
                $response = json_decode(curl_exec($ch));
                $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
                curl_close ($ch);

                if($response->result == 200)
                {
                    foreach($response->content as $report)
                    {
                        echo "<tr><a name='".$report->reportID."'>";
                        echo "<td>".$report->username."</td>";
                        echo "<td>".$report->address."</td>";
                        echo "<td>".$report->timestamp."</td>";
                        echo "<td>".$report->violation."</td>";
                        echo '<td class="center aligned"><a class="ui blue icon button" href="photos.php?id='. $report->reportID .'"><i class="folder open icon"></i></a></td>';
                        echo "<td>".$report->licensePlate."</td>";
                        echo "<td>".$report->notes."</td>";
                        echo "</a></tr>";
                    }
                }
            ?>
        </table>
    </div>

</body>

</html>