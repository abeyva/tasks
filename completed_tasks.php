<?php
session_start();
include 'config.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// Fetch completed tasks
$query = $conn->prepare("SELECT id, title, description, updated_at FROM tasks WHERE (created_by = ? OR assigned_to = ?) AND status = 'completed' ORDER BY updated_at DESC");
$query->bind_param("ii", $user_id, $user_id);
$query->execute();
$result = $query->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="icon" type="image/png" href="/images/twi.png">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Written.in | Completed Tasks</title>
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
        .menu-icon {
            position: absolute;
            left: 20px;
            font-size: 28px;
            cursor: pointer;
        }
        .navbar h1 {
            font-size: 24px;
            text-transform: uppercase;
            letter-spacing: 1px;
            cursor: pointer;
        }
        /* Sidebar */
        .sidebar {
            position: fixed;
            top: 0;
            left: -250px;
            width: 250px;
            height: 100%;
            background: #252525;
            transition: 0.3s;
            padding-top: 50px;
            box-shadow: 4px 0 10px rgba(0, 0, 0, 0.5);
        }
        .sidebar a {
            display: block;
            padding: 15px;
            color: white;
            text-decoration: none;
            font-size: 18px;
        }
        .sidebar a:hover {
            background: #333;
        }
        .back-btn {
            display: block;
            padding: 15px;
            background: #333;
            color: white;
            text-decoration: none;
            font-size: 18px;
            text-align: center;
            border-bottom: 1px solid #444;
        }
        .content {
            padding: 80px 20px 20px;
        }
        /* Task Cards */
        .task-card {
            background: #1e1e1e;
            padding: 15px;
            border-radius: 10px;
            margin: 10px 0;
            box-shadow: 0 4px 15px rgba(255, 255, 255, 0.15);
            transition: transform 0.2s, box-shadow 0.2s;
        }
        .task-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 6px 20px rgba(255, 255, 255, 0.2);
        }
        .task-title {
            font-size: 18px;
            font-weight: bold;
        }
        .task-meta {
            font-size: 14px;
            color: #bbb;
        }
    </style>
</head>
<body>

<!-- Navbar -->
<div class="navbar">
    <span class="menu-icon material-icons" onclick="toggleMenu()">menu</span>
    <h1 onclick="window.location.href='dashboard.php'"><img src="/images/twih.png" alt="Written.in" style="height: 40px;"></h1>
</div>

<!-- Sidebar Menu -->
<div class="sidebar" id="sidebar">
    <a href="#" class="back-btn" onclick="toggleMenu()">MENU</a>
    <a href="dashboard.php">📋 Dashboard</a>
    <a href="completed_tasks.php">✅ Completed Tasks</a>
    <a href="connections.php">👥 Manage Connections</a> 
    <a href="settings.php">⚙️ User Settings</a>
    <a href="logout.php">🚪 Logout</a>
</div>

<!-- Main Content -->
<div class="content">
    <h2>✅ Completed Tasks</h2>

    <?php while ($row = $result->fetch_assoc()): ?>
        <div class="task-card">
            <div class="task-title"><?= htmlspecialchars($row['title']) ?></div>
            <div class="task-meta"><?= htmlspecialchars($row['description']) ?></div>
            <div class="task-meta">Completed on: <?= !empty($row['updated_at']) ? $row['updated_at'] : 'Unknown Date' ?></div>
        </div>
    <?php endwhile; ?>
</div>

<script>
function toggleMenu() {
    var sidebar = document.getElementById("sidebar");
    sidebar.style.left = (sidebar.style.left === "0px") ? "-250px" : "0px";
}
</script>

</body>
</html>
