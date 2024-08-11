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

$Email = $Password = $Username = $Age = "";
$errors = array('Email' => '', 'Password' => '', 'Age' => '', 'Username' => '');

if (isset($_POST['login'])) {
    if (empty($_POST['Username'])) {
        $errors['Username'] = "Please enter your Username";
    } else {   
        $Username = htmlspecialchars($_POST['Username']);
    }

    if (empty($_POST['Age'])) {
        $errors['Age'] = "Please enter your Age";
    } else {   
        $Age = htmlspecialchars($_POST['Age']);
    }

    if (empty($_POST['Email'])) {
        $errors['Email'] = "Please enter Email";
    } else {
        $Email = htmlspecialchars($_POST['Email']);
    }

    if (empty($_POST['Password'])) {
        $errors['Password'] = "Please enter your password";
    } else {   
        $Password = htmlspecialchars($_POST['Password']);

        $passwordCheckQuery = "SELECT Password FROM users WHERE Email='$Email'";
        $passwordCheckQueryResult = mysqli_query($connection, $passwordCheckQuery);

        if (!$passwordCheckQueryResult) {
            die("Error in database: " . mysqli_error($connection));
        }

        $PasswordCheckRow = mysqli_fetch_array($passwordCheckQueryResult);

        if ($PasswordCheckRow) {
            if ($Password === $PasswordCheckRow['Password']) {
                $_SESSION['userID'] = $Email;
                header("Location: index.php");
                exit;
            } else {
                $errors['Password'] = "Password is not correct";
            }
        } else {
            $errors['Email'] = "Email not found";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
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
            box-sizing: border-box;
        }
        h1 {
            margin-bottom: 1.5rem;
            font-size: 32px;
            text-align: center;
        }
        form {
            display: flex;
            flex-direction: column;
        }
        div {
            margin-bottom: 1.5rem;
        }
        label {
            font-weight: bold;
            display: block;
            margin-bottom: .5rem;
            color: #ddd;
        }
        input[type="email"],
        input[type="password"],
        input[type="text"],
        input[type="number"] {
            width: 100%;
            padding: .75rem;
            border: 1px solid #444;
            border-radius: 25px;
            background: #222;
            color: #fff;
            box-sizing: border-box;
            transition: border-color 0.3s, box-shadow 0.3s;
        }
        input[type="email"]:focus,
        input[type="password"]:focus,
        input[type="text"]:focus,
        input[type="number"]:focus {
            border-color: #ff5722;
            box-shadow: 0 0 8px rgba(255, 87, 34, 0.5);
            outline: none;
        }
        span {
            color: #f44336;
            font-size: .875rem;
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
        p {
            text-align: center;
            margin-top: 1rem;
        }
        p a {
            color: #ff5722;
            text-decoration: none;
            font-weight: bold;
        }
        p a:hover {
            text-decoration: underline;
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
            background: linear-gradient(45deg, #444, #111, #444, #111);
            background-size: 400% 400%;
            animation: animateBackground 12s ease infinite;
            z-index: -1;
        }
    </style>
</head>
<body>

<div class="container">
    <h1>Login</h1>
    <form method="POST">
        <div>
            <label for="Email">Email:</label>
            <input  type="email" id="Email" name="Email" value="<?php echo htmlspecialchars($Email); ?>">
            <span>*<?php echo htmlspecialchars($errors['Email']); ?></span>
        </div>
        <div>
            <label for="Password">Password:</label>
            <input  type="password" id="Password" name="Password" value="<?php echo htmlspecialchars($Password); ?>">
            <span>*<?php echo htmlspecialchars($errors['Password']); ?></span>
        </div>
        <button name="login">Login</button>
        <p>Don't have an account? <a href="register.php">Register Now!</a></p>
    </form>
</div>

</body>
</html>
