<?php
// Start the session to access the logged-in user's username
session_start();

// Path to the JSON file used to persist leaderboard scores
$file = "data/leaderboard.json";

// If the leaderboard file doesn't exist yet, create it with an empty array
if (!file_exists($file)) {
    file_put_contents($file, json_encode([]));
}

// Read and decode the existing leaderboard data from the JSON file
$data = json_decode(file_get_contents($file), true);

// Handle score submission — only process POST requests that include a score
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["score"])) {

    // Build a new leaderboard entry using the session username and submitted score
    $entry = [
        "username" => $_SESSION["username"],
        "score" => $_POST["score"]
    ];

    // Append the new entry to the existing leaderboard data
    $data[] = $entry;

    // Sort all entries by score in descending order (highest score first)
    usort($data, function ($a, $b) {
        return $b["score"] - $a["score"];
    });

    // Write the updated and sorted leaderboard back to the JSON file
    file_put_contents($file, json_encode($data));

    // Redirect back to the leaderboard page using Post/Redirect/Get pattern
    // This prevents the score from being resubmitted if the user refreshes the page
    header("Location: leaderboard.php");
    exit();

}

?>

<!DOCTYPE html>
<html>

<head>
    <title>Leaderboard</title>
    <!-- Link to shared stylesheet for consistent layout across all pages -->
    <link rel="stylesheet" href="css/style.css">
</head>

<body>

    <div id="navbar">

        <!-- Home link aligned to the left of the navbar -->
        <a name="home" href="index.php">Home</a>

        <div class="right">

            <!-- Navigation links on the right side of the navbar -->
            <a name="memory" href="pairs.php">Play Pairs</a>
            <a name="leaderboard" href="leaderboard.php">Leaderboard</a>

            <?php
            // Display the user's avatar emoji in the navbar if one has been set
            if (isset($_COOKIE['avatar'])) {
                echo "<span style='margin-left:10px;'>" . $_COOKIE['avatar'] . "</span>";
            }
            ?>

        </div>

    </div>

    <div id="main">

        <div class="content-box">

            <h2>Leaderboard</h2>

            <!-- Table displaying all submitted scores sorted highest first -->
            <table>

                <tr>
                    <th>Username</th>
                    <th>Total Score</th>
                </tr>

                <?php
                // Loop through each leaderboard entry and render a table row
                foreach ($data as $row) {

                    echo "<tr>";
                    echo "<td>" . $row["username"] . "</td>";
                    echo "<td>" . $row["score"] . "</td>";
                    echo "</tr>";

                }
                ?>

            </table>

        </div>

    </div>

</body>

</html>