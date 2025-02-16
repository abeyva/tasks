<?php
include 'config.php';

$username = $_POST['username'];
$name = $_POST['name'];
$email = $_POST['email'];
$password = password_hash($_POST['password'], PASSWORD_DEFAULT);

// Check if username exists
$sql_check = "SELECT * FROM users WHERE username = ?";
$stmt_check = $conn->prepare($sql_check);
$stmt_check->bind_param("s", $username);
$stmt_check->execute();
$result_check = $stmt_check->get_result();

if ($result_check->num_rows > 0) {
    $status = "error";
    $message = "Username already taken.";
} else {
    // Insert user
    $sql = "INSERT INTO users (username, name, email, password) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssss", $username, $name, $email, $password);

    if ($stmt->execute()) {
        $status = "success";
        $message = "Registration Successful!";
    } else {
        $status = "error";
        $message = "An error occurred. Please try again.";
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $status === "success" ? "Success" : "Error"; ?></title>
    <style>
        body {
            margin: 0;
            padding: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
            background-color: <?php echo $status === "success" ? "#4CAF50" : "#D32F2F"; ?>;
            color: white;
            font-family: Arial, sans-serif;
            text-align: center;
        }

        .message-container {
            animation: fadeIn 1s ease-in-out;
        }

        .icon {
            font-size: 100px;
            margin-bottom: 20px;
            animation: popIn 0.5s ease-in-out;
        }

        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }

        @keyframes popIn {
            from { transform: scale(0); opacity: 0; }
            to { transform: scale(1); opacity: 1; }
        }
    </style>
</head>
<body>
    <div class="message-container">
        <div class="icon">
            <?php if ($status === "success") { ?>
                ✅ <!-- Success Tick -->
            <?php } else { ?>
                ❌ <!-- Error Cross -->
            <?php } ?>
        </div>
        <h1><?php echo $message; ?></h1>
        <p>Redirecting to Login...</p>
    </div>

    <script>
        setTimeout(function() {
            window.location.href = "login.php";
        }, 3000);
    </script>
</body>
</html>
