<?php
session_start();
$localhost = "localhost";
$username = "root";
$pass = "";
$database = "login-register";

$connection = mysqli_connect($localhost, $username, $pass, $database);

if (!$connection) {
    die("Connection error: " . mysqli_connect_error());
}

if (isset($_SESSION['userID'])) {
    $sessionEmail = $_SESSION['userID'];

    $userquerystatment = "SELECT Username, Age FROM `users` WHERE Email='$sessionEmail'";
    $userquery = mysqli_query($connection, $userquerystatment);

    $userfetch = mysqli_fetch_array($userquery);

    $sessionusername = $userfetch['Username'];
    $sessionage = $userfetch['Age'];
} else {
    header("location: login.php");
    exit;
}

if (isset($_POST['logout'])) {
    session_destroy();
    header("location: login.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Profile</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: 'Arial', sans-serif;
            color: #fff;
            background: #000;
            overflow: hidden;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .container {
            background: rgba(0, 0, 0, 0.8);
            padding: 2rem;
            border-radius: 12px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.6);
            width: 100%;
            max-width: 500px;
            text-align: center;
            box-sizing: border-box;
        }
        h2 {
            margin-bottom: 1.5rem;
            font-size: 24px;
        }
        button {
            background: #ff5722;
            color: white;
            border: none;
            padding: 0.75rem;
            border-radius: 25px;
            cursor: pointer;
            font-size: 16px;
            font-weight: bold;
            transition: background-color 0.3s, transform 0.3s;
        }
        button:hover {
            background: #e64a19;
            transform: scale(1.05);
        }
        @keyframes animateBackground {
            0% { background-position: 0% 0%; }
            100% { background-position: 100% 100%; }
        }
        body::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(45deg, #333, #000, #333, #000);
            background-size: 400% 400%;
            animation: animateBackground 12s ease infinite;
            z-index: -1;
        }
    </style>
</head>
<body>

<div class="container">
    <h2><?php echo "Your Username is: " . htmlspecialchars($sessionusername); ?></h2>
    <h2><?php echo "Your Age is: " . htmlspecialchars($sessionage); ?></h2>

    <form method="POST">
        <button name="logout">Logout</button>
    </form>
</div>

</body>
</html>
