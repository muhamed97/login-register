<?php
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

if (isset($_POST['Register'])) {
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
        $errors['Email'] = "Please enter your Email";
    } else {
        $Email = htmlspecialchars($_POST['Email']);
        $Emailquery = "SELECT COUNT(*) FROM users WHERE Email = '$Email'";
        $EmailResult = mysqli_query($connection, $Emailquery);
        if (!$EmailResult) {
            die("Error in database" . mysqli_error($connection));
        }
        $EmailRow = mysqli_fetch_array($EmailResult);
        if ($EmailRow[0] > 0) {
            $errors['Email'] = "Email is already taken by someone else";
        }
    }

    if (empty($_POST['Password'])) {
        $errors['Password'] = "Please enter your password";
    } else {
        $Password = htmlspecialchars($_POST['Password']);
    }

    if (!array_filter($errors)) {
        $sql = "INSERT INTO users (Email, Password, Username, Age) VALUES ('$Email', '$Password', '$Username', '$Age')";
        $query = mysqli_query($connection, $sql);
        if (!$query) {
            die("Query error: " . mysqli_error($connection));
        } else {
            header("Location: login.php");
            exit;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration Page</title>
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
            position: relative;
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

        @keyframes gradientAnimation {
            0% { background-position: 0% 0%; }
            50% { background-position: 100% 100%; }
            100% { background-position: 0% 0%; }
        }

        body::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(45deg, #2a2a2a, #1a1a1a, #2a2a2a, #1a1a1a);
            background-size: 400% 400%;
            animation: gradientAnimation 15s ease infinite;
            z-index: -1;
        }
    </style>
</head>
<body>

<div class="container">
    <h1>Register</h1>
    <form method="POST">
        <div>
            <label for="Email">Email:</label>
            <input  type="email" id="Email" name="Email" value="<?php echo $Email; ?>">
            <span>*<?php echo $errors['Email']; ?></span>
        </div>
        <div>
            <label for="Password">Password:</label>
            <input  type="password" id="Password" name="Password" value="<?php echo $Password; ?>">
            <span>*<?php echo $errors['Password']; ?></span>
        </div>
        <div>
            <label for="Username">Username:</label>
            <input type="text" id="Username" name="Username" value="<?php echo $Username; ?>">
            <span>*<?php echo $errors['Username']; ?></span>
        </div>
        <div>
            <label for="Age">Age:</label>
            <input type="number" id="Age" name="Age" value="<?php echo $Age; ?>">
            <span>*<?php echo $errors['Age']; ?></span>
        </div>
        <button name="Register">Register</button>
        <p>Already have an account? <a href="login.php">Login Now!</a></p>
    </form>
</div>

</body>
</html>
