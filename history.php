<?php
session_start();
include 'config.php';

if (!isset($_SESSION['user_id'])) {
    die("⚠️ Please log in first! <a href='login.php'>Login</a>");
}

$user_id = $_SESSION['user_id'];

// Fetch Completed Tasks
$sql_history = "SELECT * FROM tasks WHERE (created_by = ? OR assigned_to = ?) AND status = 'completed' ORDER BY created_at DESC";
$stmt_history = $conn->prepare($sql_history);
$stmt_history->bind_param("ii", $user_id, $user_id);
$stmt_history->execute();
$completed_tasks = $stmt_history->get_result();
$stmt_history->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="icon" type="image/png" href="/images/twi.png">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Written.in | Completed Tasks</title>
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

</head>
<body>

<h2>Completed Tasks</h2>
<a href="dashboard.php"><button>Back to Dashboard</button></a>

<hr>

<?php if ($completed_tasks->num_rows > 0) { ?>
    <ul>
        <?php while ($task = $completed_tasks->fetch_assoc()) { ?>
            <li>
                <strong><?= htmlspecialchars($task['title']) ?></strong><br>
                <?= htmlspecialchars($task['description']) ?><br>
                <small>Completed on: <?= $task['created_at'] ?></small>
            </li>
        <?php } ?>
    </ul>
<?php } else { ?>
    <p>No completed tasks.</p>
<?php } ?>

</body>
</html>
