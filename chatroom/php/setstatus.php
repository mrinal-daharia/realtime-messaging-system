<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    http_response_code(403);
    exit("Not logged in.");
}

include 'db.php'; // your db connection file

$status = $_POST['status'] ?? 'inactive';
$user_id = $_SESSION['user_id'];

$sql = "UPDATE users SET status = ? WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("si", $status, $user_id);
$stmt->execute();

echo json_encode(['success' => true]);
