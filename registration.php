<?php
session_start();

$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $username = $_POST["username"];
    $avatar = $_POST["avatar"];

    $invalid = '/[!@#%&\^\*\(\)\+=\{\}\[\];:"\'<>?\/]/';

    if (preg_match($invalid, $username)) {
        $error = "Invalid characters in username.";
    } else {

        $_SESSION["username"] = $username;

        setcookie("username", $username, time() + 3600 * 24 * 30);

        setcookie("avatar", $avatar, time() + 3600 * 24 * 30);

        header("Location: index.php");
        exit();

    }

}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Register</title>
    <link rel="stylesheet" href="css/style.css">
</head>

<body>

    <div id="navbar">

        <a name="home" href="index.php">Home</a>

        <div class="right">
            <a name="memory" href="pairs.php">Play Pairs</a>
            <a name="register" href="registration.php">Register</a>
        </div>

    </div>

    <div id="main">

        <div class="content-box">

            <h2>Register Profile</h2>

            <form method="POST">

                <label>Username</label><br>

                <input type="text" name="username" required><br>

                <span style="color:red;">
                    <?php echo $error; ?>
                </span>

                <br><br>

                <label>Select Avatar</label><br>

                <select name="avatar">

                    <option>😀</option>
                    <option>😎</option>
                    <option>👾</option>
                    <option>🤖</option>
                    <option>🐱</option>
                    <option>🐸</option>
                    <option>🐼</option>

                </select>

                <br><br>

                <button type="submit">Register</button>

            </form>

        </div>

    </div>

</body>

</html>