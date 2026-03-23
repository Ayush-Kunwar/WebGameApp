<?php
session_start();
?>
<!DOCTYPE html>
<html>

<head>
    <title>Pairs Game</title>
    <link rel="stylesheet" href="css/style.css">
</head>

<body>

    <div id="navbar">

        <a name="home" href="index.php">Home</a>

        <div class="right">

            <a name="memory" href="pairs.php">Play Pairs</a>

            <?php
            if (isset($_SESSION['username'])) {
                echo '<a name="leaderboard" href="leaderboard.php">Leaderboard</a>';
            } else {
                echo '<a name="register" href="registration.php">Register</a>';
            }
            ?>

            <?php
            if (isset($_COOKIE['avatar'])) {
                echo "<span style='margin-left:10px;'>" . $_COOKIE['avatar'] . "</span>";
            }
            ?>

        </div>
    </div>


    <div id="main">

        <div class="content-box">

            <?php

            if (isset($_SESSION['username'])) {

                echo "<h2>Welcome to Pairs</h2>";

                echo '<a href="pairs.php">
            <button>Click here to play</button>
          </a>';
            } else {

                echo "<p>You’re not using a registered session?
          <a href='registration.php'>Register now</a>
          </p>";

            }

            ?>

        </div>

    </div>

</body>

</html>