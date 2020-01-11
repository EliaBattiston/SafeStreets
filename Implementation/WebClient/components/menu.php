<?php $filename = basename($_SERVER["PHP_SELF"], ".php");  ?>

<div class="ui fixed inverted green menu">
    <!-- For everything but mobile -->
    <div class="ui mobile hidden container">
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

        <?php if(isset($_COOKIE["admin"])) { ?>
            <h3 class="ui header item <?php if($filename == "acceptance") echo "active" ?>">
                <a href="acceptance.php">
                    User acceptance
                </a>
            </h3>
        <?php } ?>

        <?php if(isset($_COOKIE["admin"])) { ?>
            <h3 class="ui header item <?php if($filename == "create") echo "active" ?>">
                <a href="create.php">
                    User creation
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

    <!-- Only for mobile -->
    <div class="ui mobile only container">
        <div class="item">
            <img src="images/SafeStreets_logo.svg" style ="width: 40px;">
        </div>

        <button id="menuDropdown" class="ui right item icon dropdown green button" onclick="$('#menuDropdown').dropdown('');  ">
            <i class="bars icon"></i>
            <div class="inverted menu">
                <a class="item <?php if($filename == "reports") echo "active" ?>" href="reports.php">
                    Reports
                </a>

                <?php if(isset($_COOKIE["admin"])) { ?>
                    <a class="item <?php if($filename == "accounts") echo "active" ?>" href="accounts.php">
                        Accounts
                    </a>
                <?php } ?>

                <?php if(isset($_COOKIE["admin"])) { ?>
                    <a class="item <?php if($filename == "acceptance") echo "active" ?>" href="acceptance.php">
                        User acceptance
                    </a>
                <?php } ?>

                <?php if(isset($_COOKIE["admin"])) { ?>
                    <a class="item <?php if($filename == "create") echo "active" ?>" href="create.php">
                        User creation
                    </a>
                <?php } ?>

                <a class="item" href="src/logout.php">
                    <i class="sign out icon"></i> Log Out
                </a>
            </div>
        </button>
    </div>
</div>