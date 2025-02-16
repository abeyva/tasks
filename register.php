<?php
include 'config.php';

// Generate random numbers for the CAPTCHA
$rand1 = rand(1, 10);
$rand2 = rand(1, 10);
$sum = $rand1 + $rand2;
session_start();
$_SESSION['captcha'] = $sum;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="icon" type="image/png" href="/images/twi.png">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Written.in | Register</title>
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
        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Roboto', sans-serif; }
        body { background: #121212; color: #fff; display: flex; flex-direction: column; align-items: center; justify-content: center; height: 100vh; }
        .navbar { width: 100%; background: #1e1e1e; padding: 16px; display: flex; align-items: center; justify-content: space-between; box-shadow: 0 2px 10px rgba(0, 0, 0, 0.5); position: fixed; top: 0; left: 0; z-index: 1000; }
        .navbar h1 { font-size: 24px; text-transform: uppercase; cursor: pointer; margin-left: 20px; }
        .navbar a { color: white; text-decoration: none; font-size: 18px; margin-right: 20px; }
        .register-container { background: #1e1e1e; padding: 30px; border-radius: 10px; box-shadow: 0 4px 15px rgba(255, 255, 255, 0.15); text-align: center; width: 100%; max-width: 350px; margin-top: 80px; }
        .register-container h2 { margin-bottom: 15px; }
        .register-container input { width: 100%; padding: 10px; margin: 10px 0; border: none; border-radius: 5px; font-size: 16px; }
        .register-container button { width: 100%; padding: 10px; background: #4CAF50; border: none; color: white; font-size: 16px; border-radius: 5px; cursor: pointer; margin-top: 10px; }
        .register-container button:hover { background: #388E3C; }
        .register-container p { margin-top: 15px; }
    </style>
</head>
<body>

<!-- Navbar -->
<div class="navbar">
    <h1 onclick="window.location.href='index.php'"><img src="/images/twih.png" alt="Written.in" style="height: 40px;"></h1>
    <a href="about.php">ℹ️ About</a>
</div>

<!-- Register Form -->
<div class="register-container">
    <h2>Register</h2>
    <form action="register_action.php" method="POST" onsubmit="return validateForm()">
        <input type="text" name="username" placeholder="Username (4+ characters)" required minlength="4">
        <input type="text" name="name" placeholder="Full Name" required>
        <input type="email" name="email" placeholder="Email" required>
        <input type="password" id="password" name="password" placeholder="Password" required>
        <input type="password" id="confirm_password" name="confirm_password" placeholder="Repeat Password" required>

        <!-- Math CAPTCHA -->
        <label for="captcha">Solve: <?php echo "$rand1 + $rand2 = ?"; ?></label>
        <input type="number" id="captcha" name="captcha" required>

        <button type="submit">Register</button>
    </form>
    <p>Already have an account? <a href="login.php">Login</a></p>
</div>

<script>
function validateForm() {
    var password = document.getElementById("password").value;
    var confirmPassword = document.getElementById("confirm_password").value;
    
    if (password !== confirmPassword) {
        alert("Passwords do not match!");
        return false;
    }
    
    return true;
}
</script>

</body>
</html>
