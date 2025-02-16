<?php
session_start();
include 'config.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$request_id = $_GET['id'];
$user_id = $_SESSION['user_id'];

// Accept request
$sql = "UPDATE connection_requests SET status = 'accepted' WHERE id = ? AND receiver_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ii", $request_id, $user_id);

if ($stmt->execute()) {
    // Add to connections table
    $sql_get_users = "SELECT sender_id, receiver_id FROM connection_requests WHERE id = ?";
    $stmt_get_users = $conn->prepare($sql_get_users);
    $stmt_get_users->bind_param("i", $request_id);
    $stmt_get_users->execute();
    $users = $stmt_get_users->get_result()->fetch_assoc();

    $sql_add = "INSERT INTO connections (user_id, friend_id) VALUES (?, ?), (?, ?)";
    $stmt_add = $conn->prepare($sql_add);
    $stmt_add->bind_param("iiii", $users['sender_id'], $users['receiver_id'], $users['receiver_id'], $users['sender_id']);
    $stmt_add->execute();

    header("Location: connections.php");
} else {
    echo "Error accepting request.";
}
?>
