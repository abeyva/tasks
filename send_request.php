<?php
session_start();
include 'config.php';

$status = "error";
$message = "⚠️ Error: Invalid request. Please log in.";

if (isset($_SESSION['user_id']) && isset($_POST['friend_username'])) {
    $user_id = $_SESSION['user_id'];
    $friend_username = trim($_POST['friend_username']);

    // Check if the entered username exists
    $sql = "SELECT id FROM users WHERE username = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $friend_username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 0) {
        $message = "Error: User not found!";
    } else {
        $friend = $result->fetch_assoc();
        $friend_id = $friend['id'];

        // Prevent sending a request to yourself
        if ($friend_id == $user_id) {
            $message = "Error: You cannot add yourself!";
        } else {
            // Check if a request already exists
            $sql_check = "SELECT id, status FROM connections 
                          WHERE (user_id = ? AND friend_id = ?) OR (user_id = ? AND friend_id = ?)";
            $stmt_check = $conn->prepare($sql_check);
            $stmt_check->bind_param("iiii", $user_id, $friend_id, $friend_id, $user_id);
            $stmt_check->execute();
            $result_check = $stmt_check->get_result();

            if ($result_check->num_rows > 0) {
                $row = $result_check->fetch_assoc();
                
                if ($row['status'] === 'pending') {
                    $message = "You already sent a request!";
                } elseif ($row['status'] === 'accepted') {
                    $message = "You are already connected!";
                }
            } else {
                // Send a new friend request
                $sql_insert = "INSERT INTO connections (user_id, friend_id, status) VALUES (?, ?, 'pending')";
                $stmt_insert = $conn->prepare($sql_insert);
                $stmt_insert->bind_param("ii", $user_id, $friend_id);

                if ($stmt_insert->execute()) {
                    $status = "success";
                    $message = "Friend request sent successfully!";
                } else {
                    $message = "Error sending request: " . $conn->error;
                }
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $status === "success" ? "Request Sent" : "Error"; ?></title>
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
        <p>Redirecting to Connections...</p>
    </div>

    <script>
        setTimeout(function() {
            window.location.href = "connections.php";
        }, 1800);
    </script>
</body>
</html>
