<?php include("components/checks.php") ?>

<!DOCTYPE html>
<html>

<head>
    <title>SafeStreets Suggestions</title>
    <?php include("components/header.php") ?>
</head>
<body>
    <?php include("components/menu.php") ?>

    <div class="ui container">
        <div class="ui red segment" style="margin-top: 50px;">
            <h3>Via Roma, Via Colombo</h3>
            <b>Severity:</b> High
            <br>
            <b>Cause:</b> In the last month
            <br>
            <ul>
                <li><b>Accidents:</b> 5</li>
                <li><b>Traffic tickets:</b> 0</li>
                <li><b>Reports:</b> 2</li>
            </ul>
            <br>
            <b>Most frequent violation:</b> Engage the intersection without halting at the stop sign
            <br>
            <b>Suggested solutions:</b>
            <br>
            <ol>
                <li>Replace the intersection with a roundabout</li>
                <li>Place traffic lights at the intersection</li>
            </ol>
        </div>

        <div class="ui yellow segment">
            <h3>Via Bonacalza</h3>
            <b>Severity:</b> Medium
            <br>
            <b>Cause:</b> In the last two months
            <br>
            <ul>
                <li><b>Accidents:</b> 0</li>
                <li><b>Traffic tickets:</b> 55</li>
                <li><b>Reports:</b> 12</li>
            </ul>
            <br>
            <b>Most frequent violation:</b> Parking on the bicycle lane
            <br>
            <b>Suggested solutions:</b>
            <br>
            <ol>
                <li>Place barriers between the lane and the street</li>
            </ol>
        </div>

        <div class="ui blue segment">
            <h3>Via Garibaldi</h3>
            <b>Severity:</b> Low
            <br>
            <b>Cause:</b> In the last two weeks
            <br>
            <ul>
                <li><b>Accidents:</b> 0</li>
                <li><b>Traffic tickets:</b> 0</li>
                <li><b>Reports:</b> 21</li>
            </ul>
            <br>
            <b>Most frequent violation:</b> Double parking
            <br>
            <b>Suggested solutions:</b>
            <br>
            <ol>
                <li>Make more parking spots available in the surrounding area</li>
                <li>Increase frequency of police patrols</li>
            </ol>
        </div>

    </div>

</body>

</html>