<?php
session_start();
include 'config.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="icon" type="image/png" href="/images/twi.png">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Written.in | Login</title>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500&display=swap" rel="stylesheet">

    <!-- PWA Manifest -->
    <link rel="manifest" href="/manifest.json">
    <!-- Register Service Worker -->
    <script>
    if ("serviceWorker" in navigator) {
        navigator.serviceWorker.register("/sw.js")
        .then(() => console.log("Service Worker Registered"))
        .catch((error) => console.log("Service Worker Registration Failed", error));
    }
    </script>


    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Roboto', sans-serif;
        }
        body {
            background: #121212;
            color: #fff;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            height: 100vh;
        }
        /* Navbar */
        .navbar {
            width: 100%;
            background: #1e1e1e;
            padding: 16px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.5);
            position: fixed;
            top: 0;
            left: 0;
            z-index: 1000;
        }
        .navbar h1 {
            font-size: 24px;
            text-transform: uppercase;
            letter-spacing: 1px;
            cursor: pointer;
            margin-left: 20px;
        }
        .navbar a {
            color: white;
            text-decoration: none;
            font-size: 18px;
            margin-right: 20px;
        }
        .navbar a:hover {
            text-decoration: underline;
        }
        /* Login Form */
        .login-container {
            background: #1e1e1e;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 15px rgba(255, 255, 255, 0.15);
            text-align: center;
            width: 100%;
            max-width: 350px;
        }
        .login-container h2 {
            margin-bottom: 15px;
        }
        .login-container input {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: none;
            border-radius: 5px;
            font-size: 16px;
        }
        .login-container button {
            width: 100%;
            padding: 10px;
            background: #ff6b6b;
            border: none;
            color: white;
            font-size: 16px;
            border-radius: 5px;
            cursor: pointer;
            margin-top: 10px;
        }
        .login-container button:hover {
            background: #e63946;
        }
        .login-container p {
            margin-top: 15px;
        }
        .login-container a {
            color: #ff6b6b;
            text-decoration: none;
        }
        .login-container a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>

<!-- Navbar -->
<div class="navbar">
    <h1 onclick="window.location.href='index.php'"><img src="/images/twih.png" alt="Written.in" style="height: 40px;">
    </h1>
    <a href="about.php">ℹ️ About</a>
</div>

<!-- Login Form -->
<div class="login-container">
    <h2>Login</h2>
    <form action="login_action.php" method="POST">
        <input type="email" name="email" placeholder="Email" required>
        <input type="password" name="password" placeholder="Password" required>
        <button type="submit">Login</button>
    </form>
    <p>Don't have an account? <a href="register.php">Register</a></p>
</div>

</body>
</html>
