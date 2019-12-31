<?php $filename = basename($_SERVER["PHP_SELF"], ".php");  ?>

<div class="ui fixed inverted green menu">
    <div class="ui container">
        <div class="item">
            <img src="images/SafeStreets_logo.svg" style ="width: 40px;">
        </div>

        <h3 class="ui header item <?php if($filename == "reports") echo "active" ?>">
            <a href="reports.php">
                Reports
            </a>
        </h3>

        <?php if(isset($_COOKIE["admin"])) { ?>
            <h3 class="ui header item <?php if($filename == "accounts") echo "active" ?>">
                <a href="accounts.php">
                    Accounts
                </a>
            </h3>
        <?php } ?>

        <!--<h3 class="ui header item <?php if($filename == "stats") echo "active" ?>">
            <a href="stats.php">
                Unsafe Areas
            </a>
        </h3>-->

        <h3 class="ui right header item">
            <a href="src/logout.php">
                <i class="sign out icon"></i> Log Out
            </a>
        </h3>
    </div>
</div>