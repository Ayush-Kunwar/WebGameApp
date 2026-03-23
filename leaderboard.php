<?php
session_start();

$file = "data/leaderboard.json";

if (!file_exists($file)) {
    file_put_contents($file, json_encode([]));
}

$data = json_decode(file_get_contents($file), true);

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["score"])) {

    #$entry = [
    #    "username" => $_SESSION["username"],
    #    "score" => $_POST["score"]
    #];

    #$data[] = $entry;

    #file_put_contents($file, json_encode($data));
    $entry = [
        "username" => $_SESSION["username"],
        "score" => $_POST["score"]
    ];

    $data[] = $entry;

    file_put_contents($file, json_encode($data));

    // VERY IMPORTANT
    header("Location: leaderboard.php");
    exit();

}

?>

<!DOCTYPE html>
<html>

<head>
    <title>Leaderboard</title>
    <link rel="stylesheet" href="css/style.css">
</head>

<body>

    <div id="navbar">

        <a name="home" href="index.php">Home</a>

        <div class="right">

            <a name="memory" href="pairs.php">Play Pairs</a>
            <a name="leaderboard" href="leaderboard.php">Leaderboard</a>

            <?php
            if (isset($_COOKIE['avatar'])) {
                echo "<span style='margin-left:10px;'>" . $_COOKIE['avatar'] . "</span>";
            }
            ?>

        </div>

    </div>

    <div id="main">

        <div class="content-box">

            <h2>Leaderboard</h2>

            <table>

                <tr>
                    <th>Username</th>
                    <th>Score</th>
                </tr>

                <?php

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