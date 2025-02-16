<?php
session_start();
include 'config.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// Fetch pending friend requests (received)
$sql_pending = "SELECT c.id, c.user_id AS friend_id, u.username 
                FROM connections c
                JOIN users u ON c.user_id = u.id
                WHERE c.friend_id = ? AND c.status = 'pending'";
$stmt_pending = $conn->prepare($sql_pending);
$stmt_pending->bind_param("i", $user_id);
$stmt_pending->execute();
$pending_requests = $stmt_pending->get_result();

// Fetch accepted connections
$sql_connections = "SELECT c.id, u.username, u.id AS friend_id 
                    FROM connections c
                    JOIN users u ON (c.user_id = u.id OR c.friend_id = u.id)
                    WHERE (c.user_id = ? OR c.friend_id = ?) 
                    AND c.status = 'accepted' 
                    AND u.id != ?";
$stmt_connections = $conn->prepare($sql_connections);
$stmt_connections->bind_param("iii", $user_id, $user_id, $user_id);
$stmt_connections->execute();
$connections = $stmt_connections->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="icon" type="image/png" href="/images/twi.png">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Written.in | Manage Connections</title>
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
        body { background: #121212; color: #fff; display: flex; flex-direction: column; align-items: center; min-height: 100vh; }
        .navbar { width: 100%; background: #1e1e1e; padding: 16px; display: flex; align-items: center; justify-content: center; box-shadow: 0 2px 10px rgba(0, 0, 0, 0.5); position: fixed; top: 0; left: 0; }
        .navbar h1 { font-size: 24px; text-transform: uppercase; letter-spacing: 2px; font-weight: bold; }
        .back-button { position: absolute; left: 16px; font-size: 28px; cursor: pointer; color: white; text-decoration: none; }
        .title { text-align: center; font-size: 28px; font-weight: 700; letter-spacing: 2px; margin: 100px 0 20px; }
        .content-container { width: 90%; max-width: 600px; display: flex; flex-direction: column; align-items: center; gap: 20px; }
        .card { width: 100%; background: #1e1e1e; padding: 20px; border-radius: 12px; box-shadow: 0 6px 15px rgba(255, 255, 255, 0.1); }
        h3 { margin-bottom: 10px; font-size: 20px; font-weight: 500; color: #76c7c0; }
        input { width: 100%; padding: 12px; background: #252525; color: #fff; border: none; border-radius: 8px; font-size: 16px; margin-bottom: 10px; }
        button { width: 100%; padding: 14px; background: #76c7c0; color: #fff; font-size: 18px; font-weight: bold; border: none; border-radius: 8px; cursor: pointer; }
        button:hover { background: #64b3ad; }
        .list { list-style: none; padding: 0; }
        .list li { background: #252525; padding: 12px; margin: 5px 0; border-radius: 8px; display: flex; justify-content: space-between; align-items: center; }
        .actions a { color: white; padding: 8px 12px; border-radius: 6px; text-decoration: none; font-size: 14px; transition: 0.3s; display: inline-block; margin-left: 5px; }
        .actions .accept { background: #4caf50; }
        .actions .reject, .actions .remove { background: #ff5c5c; }
        .actions a:hover { opacity: 0.8; }
    </style>
</head>
<body>

<!-- Navbar -->
<div class="navbar">
    <a href="dashboard.php" class="back-button material-icons">arrow_back</a>
    <h1><img src="/images/twih.png" alt="Written.in" style="height: 40px;"></h1>
</div>

<!-- Title -->
<div class="title">Manage Connections</div>

<!-- Content -->
<div class="content-container">

    <!-- Add Connection Section -->
    <div class="card">
        <h3>🔎 Add a Connection</h3>
        <form action="send_request.php" method="POST">
            <input type="text" name="friend_username" placeholder="Enter username" required>
            <button type="submit">➕ Send Request</button>
        </form>
    </div>

    <!-- Pending Requests -->
    <div class="card">
        <h3>📩 Pending Requests (Received)</h3>
        <ul class="list">
            <?php if ($pending_requests->num_rows > 0): ?>
                <?php while ($req = $pending_requests->fetch_assoc()): ?>
                    <li>
                        <strong><?= htmlspecialchars($req['username']); ?></strong>
                        <div class="actions">
                            <a href="process_request.php?action=accept&id=<?= $req['id']; ?>" class="accept">✅ Accept</a>
                            <a href="process_request.php?action=reject&id=<?= $req['id']; ?>" class="reject">❌ Reject</a>
                        </div>
                    </li>
                <?php endwhile; ?>
            <?php else: ?>
                <li>No pending requests</li>
            <?php endif; ?>
        </ul>
    </div>

    <!-- Your Connections -->
    <div class="card">
        <h3>🔗 Your Connections</h3>
        <ul class="list">
            <?php if ($connections->num_rows > 0): ?>
                <?php while ($conn = $connections->fetch_assoc()): ?>
                    <li>
                        <strong><?= htmlspecialchars($conn['username']); ?></strong>
                        <div class="actions">
                            <a href="process_request.php?action=remove&id=<?= $conn['id']; ?>" class="remove">❌ Remove</a>
                        </div>
                    </li>
                <?php endwhile; ?>
            <?php else: ?>
                <li>No connections yet</li>
            <?php endif; ?>
        </ul>
    </div>

</div>

</body>
</html>
