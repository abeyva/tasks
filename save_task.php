<?php
session_start();
include 'config.php';

if (!isset($_SESSION['user_id'])) {
    $status = "error";
    $message = "⚠️ Please log in first!";
} else {
    $user_id = $_SESSION['user_id'];
    $title = trim($_POST['title']);
    $description = trim($_POST['description']);
    $assigned_to = $_POST['assigned_to']; // Can be empty for self-task
    $timestamp = date('Y-m-d H:i:s');

    if (empty($title) || empty($description)) {
        $status = "error";
        $message = "❌ Title and Description are required!";
    } else {
        // If assigned_to is empty, assign task to self
        if (empty($assigned_to)) {
            $assigned_to = $user_id;
        }

        // Insert task into database
        $sql = "INSERT INTO tasks (title, description, created_by, assigned_to, created_at) 
                VALUES (?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssiss", $title, $description, $user_id, $assigned_to, $timestamp);

        if ($stmt->execute()) {
            $status = "success";
            $message = "Task added";
        } else {
            $status = "error";
            $message = "❌ Error adding task: " . $conn->error;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $status === "success" ? "Task Saved" : "Error"; ?></title>
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
        <p>Now back to Dashboard...</p>
    </div>

    <script>
        setTimeout(function() {
            window.location.href = "dashboard.php";
        }, 1800);
    </script>
</body>
</html>
