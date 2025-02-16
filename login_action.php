<?php
session_start();
include 'config.php';

$email = $_POST['email'];
$password = $_POST['password'];

$sql = "SELECT * FROM users WHERE email = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

if ($user && password_verify($password, $user['password'])) {
    $_SESSION['user_id'] = $user['id'];
    $_SESSION['username'] = $user['username'];
    header("Location: dashboard.php");
} else {
    echo "<div class='error-screen'>
            <div class='error-content'>
                <span class='emoji'>😞</span>
                <h2>Invalid Credentials</h2>
                <p>Redirecting back to login...</p>
            </div>
          </div>";
    echo "<script>
        setTimeout(function() {
            document.querySelector('.error-screen').classList.add('fade-out');
        }, 1500);
        setTimeout(function() {
            window.location.href = 'login.php';
        }, 2000);
    </script>";
}
?>

<style>
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
        font-family: Arial, sans-serif;
    }
    .error-screen {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: #ff4c4c;
        display: flex;
        justify-content: center;
        align-items: center;
        color: white;
        text-align: center;
        transition: opacity 0.5s ease-in-out;
    }
    .error-content {
        animation: pop 0.5s ease-in-out;
    }
    .emoji {
        font-size: 60px;
        display: block;
        margin-bottom: 10px;
    }
    .fade-out {
        opacity: 0;
    }
    @keyframes pop {
        0% { transform: scale(0.5); opacity: 0; }
        100% { transform: scale(1); opacity: 1; }
    }
</style>
