<?php
session_start();
include 'config.php';

if (!isset($_SESSION['user_id'])) {
    die("⚠️ Please log in first!");
}

$user_id = $_SESSION['user_id'];

// Fetch user connections for task assignment
$sql = "SELECT u.id, u.username FROM users u 
        JOIN connections c ON (c.user_id = u.id OR c.friend_id = u.id)
        WHERE (c.user_id = ? OR c.friend_id = ?) AND c.status = 'accepted' AND u.id != ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("iii", $user_id, $user_id, $user_id);
$stmt->execute();
$result = $stmt->get_result();
$connections = $result->fetch_all(MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="icon" type="image/png" href="/images/twi.png">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Written.in | Add Task</title>
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
            height: 100vh;
        }
        /* Navbar */
        .navbar {
            width: 100%;
            background: #1e1e1e;
            padding: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.5);
            position: fixed;
            top: 0;
            left: 0;
            z-index: 1000;
        }
        .back-button {
            position: absolute;
            left: 20px;
            font-size: 28px;
            cursor: pointer;
            color: white;
            text-decoration: none;
        }
        .navbar h1 {
            font-size: 24px;
            text-transform: uppercase;
            letter-spacing: 2px;
            font-weight: bold;
            text-align: center;
        }
        /* Page Title */
        .title {
            text-align: center;
            font-size: 28px;
            font-weight: 700;
            margin: 80px 0 20px;
            letter-spacing: 1px;
        }
        /* Form Container */
        .form-container {
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px;
            flex: 1;
        }
        form {
            width: 100%;
            max-width: 600px;
            padding: 20px;
            background: #1e1e1e;
            border-radius: 12px;
            box-shadow: 0 6px 15px rgba(255, 255, 255, 0.1);
            display: flex;
            flex-direction: column;
            gap: 15px;
        }
        label {
            font-size: 16px;
            font-weight: 500;
        }
        input, textarea, select {
            width: 100%;
            padding: 12px;
            background: #252525;
            color: #fff;
            border: none;
            border-radius: 8px;
            font-size: 16px;
            box-shadow: inset 0 2px 4px rgba(255, 255, 255, 0.1);
        }
        textarea {
            height: 120px;
            resize: none;
        }
        /* Button Styling */
        .btn-container {
            display: flex;
            gap: 10px;
        }
        .btn {
            width: 100%;
            padding: 14px;
            font-size: 18px;
            font-weight: bold;
            border: none;
            border-radius: 12px;
            cursor: pointer;
            transition: 0.3s;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.2);
        }
        /* Add Task Button */
        .add-btn {
            background: #00E676;
            color: #121212;
        }
        .add-btn:hover {
            background: #00C853;
            box-shadow: 0px 6px 12px rgba(0, 255, 128, 0.3);
        }
        /* Cancel Button */
        .cancel-btn {
            background: #FF5252;
            color: #fff;
        }
        .cancel-btn:hover {
            background: #E04040;
            box-shadow: 0px 6px 12px rgba(255, 82, 82, 0.3);
        }
    </style>
</head>
<body>

<!-- Navbar -->
<div class="navbar">
    <a href="dashboard.php" class="back-button material-icons">arrow_back</a>
    <h1><img src="/images/twih.png" alt="Written.in" style="height: 40px;"></h1>
</div>

<!-- Page Title -->
<div class="title">🆕 Add New Task</div>

<!-- Form Section -->
<div class="form-container">
    <form action="save_task.php" method="POST">
        <label>📌 Title:</label>
        <input type="text" name="title" required>

        <label>📝 Description:</label>
        <textarea name="description" required></textarea>

        <label>👥 Assign To:</label>
        <select name="assigned_to">
            <option value="">🙋 Self (Personal Task)</option>
            <?php foreach ($connections as $conn) { ?>
                <option value="<?= $conn['id'] ?>">👤 <?= htmlspecialchars($conn['username']) ?></option>
            <?php } ?>
        </select>

        <div class="btn-container">
            <button type="submit" class="btn add-btn">✅ Add Task</button>
            <a href="dashboard.php"><button type="button" class="btn cancel-btn">❌ Cancel</button></a>
        </div>
    </form>
</div>

</body>
</html>
