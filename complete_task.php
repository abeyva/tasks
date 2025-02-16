<?php
session_start();
include 'config.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

if (!isset($_GET['id']) || empty($_GET['id'])) {
    die("Invalid task ID");
}

$task_id = intval($_GET['id']);
$user_id = $_SESSION['user_id'];

// Check if the task exists and is assigned to the user
$check_task = $conn->prepare("SELECT id FROM tasks WHERE id = ? AND (created_by = ? OR assigned_to = ?) AND status = 'pending'");
$check_task->bind_param("iii", $task_id, $user_id, $user_id);
$check_task->execute();
$result = $check_task->get_result();

if ($result->num_rows === 0) {
    die("Invalid task update or already completed.");
}

// Update the task status to 'completed'
$update_task = $conn->prepare("UPDATE tasks SET status = 'completed' WHERE id = ?");
$update_task->bind_param("i", $task_id);

if ($update_task->execute()) {
    header("Location: dashboard.php");
} else {
    echo "Error updating task.";
}
?>
