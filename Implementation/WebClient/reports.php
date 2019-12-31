<?php
    include("components/checks.php");
    include_once(__DIR__ . "/config.php");

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

    if($response->result == 401)
    {
        header("location: src/logout.php");
        exit;
    }
?>

<!DOCTYPE html>
<html>

<head>
    <title>SafeStreets Reports</title>
    <?php include("components/header.php") ?>
    <script>
        $(document).ready(function() {
            $('#data').DataTable({
                "aaSorting": [[ 0, "desc" ]]
            });
        });
    </script>
</head>
<body>
    <?php include("components/menu.php") ?>

    <div class="ui container" style="padding-top:90px;">
        <table id="data" class="ui celled table">
            <thead>
                <tr>
                    <th>Report ID</th>
                    <th>Username</th>
                    <th>Location</th>
                    <th>Timestamp</th>
                    <th>Type</th>
                    <th>License plate</th>
                    <th>Notes</th>
                    <th>Details</th>
                </tr>
            </thead>
            <?php
                if($response->result == 200)
                {
                    foreach($response->content as $report)
                    {
                        echo "<tr><a name='".$report->reportID."'>";
                        echo "<td>".$report->reportID."</td>";
                        echo "<td>".$report->username."</td>";
                        echo "<td>".$report->address."</td>";
                        echo "<td>".$report->timestamp."</td>";
                        echo "<td>".$report->violation."</td>";
                        echo "<td>".$report->licensePlate."</td>";
                        echo "<td>".$report->notes."</td>";
                        echo '<td class="center aligned"><a class="ui blue icon button" href="details.php?id='. $report->reportID .'"><i class="folder open icon"></i></a></td>';
                        echo "</a></tr>";
                    }
                }
            ?>
        </table>
    </div>

</body>

</html>