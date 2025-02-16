<?php
session_start();
include 'config.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

if (isset($_GET['action']) && isset($_GET['id'])) {
    $action = $_GET['action'];
    $connection_id = intval($_GET['id']);

    if ($action === 'accept') {
        // Accept friend request
        $sql = "UPDATE connections SET status = 'accepted' WHERE id = ? AND friend_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ii", $connection_id, $user_id);
        $stmt->execute();
    } elseif ($action === 'reject') {
        // Reject (delete) friend request
        $sql = "DELETE FROM connections WHERE id = ? AND friend_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ii", $connection_id, $user_id);
        $stmt->execute();
    } elseif ($action === 'remove') {
        // Remove an existing connection
        $sql = "DELETE FROM connections WHERE id = ? AND (user_id = ? OR friend_id = ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("iii", $connection_id, $user_id, $user_id);
        $stmt->execute();
    }

    // Redirect back to connections page
    header("Location: connections.php");
    exit();
} else {
    header("Location: connections.php");
    exit();
}
?>
