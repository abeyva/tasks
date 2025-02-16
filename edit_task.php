<?php
session_start();
include 'config.php';

if (!isset($_SESSION['user_id'])) {
    die("⚠️ Please log in first! <a href='login.php'>Login</a>");
}

if (!isset($_GET['id'])) {
    die("⚠️ Task ID not provided.");
}

$task_id = $_GET['id'];
$user_id = $_SESSION['user_id'];

// Fetch task details
$sql = "SELECT * FROM tasks WHERE id = ? AND created_by = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ii", $task_id, $user_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    die("❌ Unauthorized action!");
}

$task = $result->fetch_assoc();
$stmt->close();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $new_title = $_POST['title'];
    $new_description = $_POST['description'];

    $sql_update = "UPDATE tasks SET title = ?, description = ? WHERE id = ?";
    $stmt_update = $conn->prepare($sql_update);
    $stmt_update->bind_param("ssi", $new_title, $new_description, $task_id);

    if ($stmt_update->execute()) {
        header("Location: dashboard.php?message=✅ Task updated!");
        exit();
    } else {
        echo "❌ Error updating task.";
    }

    $stmt_update->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="icon" type="image/png" href="/images/twi.png">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Written.in | Edit Task</title>
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
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
        }
        .form-container {
            width: 100%;
            max-width: 600px;
            background: #1e1e1e;
            padding: 20px;
            border-radius: 12px;
            box-shadow: 0 6px 15px rgba(255, 255, 255, 0.1);
        }
        label {
            display: block;
            font-size: 16px;
            font-weight: 500;
            margin-bottom: 5px;
        }
        input, textarea {
            width: 100%;
            padding: 12px;
            background: #252525;
            color: #fff;
            border: none;
            border-radius: 8px;
            font-size: 16px;
            margin-bottom: 15px;
        }
        textarea {
            height: 120px;
            resize: none;
        }
        /* Bright Material Buttons */
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
        /* Save Button */
        .save-btn {
            background: #00E676;
            color: #121212;
        }
        .save-btn:hover {
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
    <span class="menu-icon material-icons" onclick="toggleMenu()">menu</span>
    <h1 onclick="window.location.href='dashboard.php'"><img src="/images/twih.png" alt="Written.in" style="height: 40px;"></h1>
</div>

<!-- Sidebar Menu -->
<div class="sidebar" id="sidebar">
    <a href="#" class="back-btn" onclick="toggleMenu()">TΛSKS MENU</a>
    <a href="dashboard.php">📋 Dashboard</a>
    <a href="connections.php">👥 Manage Connections</a>
    <a href="completed_tasks.php">✅ Completed Tasks</a>
    <a href="settings.php">⚙️ User Settings</a>
    <a href="logout.php">🚪 Logout</a>
</div>

<!-- Main Content -->
<div class="content">
    <h2>Edit Task ✏️</h2>

    <div class="form-container">
        <form method="POST">
            <label>📌 Title:</label>
            <input type="text" name="title" value="<?= htmlspecialchars($task['title']) ?>" required>

            <label>📝 Description:</label>
            <textarea name="description" required><?= htmlspecialchars($task['description']) ?></textarea>

            <div class="btn-container">
                <button type="submit" class="btn save-btn">✅ Save Changes</button>
                <a href="dashboard.php"><button type="button" class="btn cancel-btn">Cancel</button></a>
            </div>
        </form>
    </div>
</div>

<script>
function toggleMenu() {
    var sidebar = document.getElementById("sidebar");
    sidebar.style.left = (sidebar.style.left === "0px") ? "-250px" : "0px";
}
</script>

</body>
</html>
