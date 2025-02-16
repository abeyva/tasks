<?php
session_start();
include 'config.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

if (isset($_GET['id'])) {
    $task_id = $_GET['id'];
    $user_id = $_SESSION['user_id'];

    // Update task status
    $sql = "UPDATE tasks SET status = 'completed', updated_at = NOW() WHERE id = ? AND (created_by = ? OR assigned_to = ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("iii", $task_id, $user_id, $user_id);
    
    if ($stmt->execute()) {
        header("Location: dashboard.php");
    } else {
        echo "Error marking task complete.";
    }
} else {
    echo "Invalid request.";
}
?>
