<?php
// Start the session to access session variables (e.g. username set during registration)
session_start();
?>
<!DOCTYPE html>
<html>

<head>
    <title>Pairs Game</title>
    <!-- Link to shared stylesheet for consistent layout across all pages -->
    <link rel="stylesheet" href="css/style.css">
</head>

<body>

    <div id="navbar">

        <!-- Home link aligned to the left of the navbar -->
        <a name="home" href="index.php">Home</a>

        <div class="right">

            <!-- Play Pairs link always visible in the navbar -->
            <a name="memory" href="pairs.php">Play Pairs</a>

            <?php
            // If the user has a registered session, show the Leaderboard link
            // Otherwise show the Register link
            if (isset($_SESSION['username'])) {
                echo '<a name="leaderboard" href="leaderboard.php">Leaderboard</a>';
            } else {
                echo '<a name="register" href="registration.php">Register</a>';
            }
            ?>

            <?php
            // If the user has selected an avatar, display it in the navbar from cookie
            if (isset($_COOKIE['avatar'])) {
                echo "<span style='margin-left:10px;'>" . $_COOKIE['avatar'] . "</span>";
            }
            ?>

        </div>
    </div>


    <div id="main">

        <div class="content-box">

            <?php
            // Check if the user is in a registered session
            if (isset($_SESSION['username'])) {

                // Registered user: show welcome message and button to start the game
                echo "<h2>Welcome to Pairs</h2>";

                echo '<a href="pairs.php">
            <button>Click here to play</button>
          </a>';
            } else {

                // Unregistered user: prompt them to register before playing
                echo "<p>You're not using a registered session?
          <a href='registration.php'>Register now</a>
          </p>";

            }
            ?>

        </div>

    </div>

</body>

</html>