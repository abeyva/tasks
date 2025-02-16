<?php
session_start();
include 'config.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$request_id = $_GET['id'];
$user_id = $_SESSION['user_id'];

$sql = "DELETE FROM connection_requests WHERE id = ? AND receiver_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ii", $request_id, $user_id);

if ($stmt->execute()) {
    header("Location: connections.php");
} else {
    echo "Error rejecting request.";
}
?>
