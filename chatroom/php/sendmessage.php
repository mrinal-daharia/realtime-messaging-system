<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    http_response_code(403);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST['message'])) {
    include 'db.php';

    $user_id = $_SESSION['user_id'];
    $message = htmlspecialchars(trim($_POST['message']));

    try {
        // Insert the message
        $stmt = $conn->prepare("INSERT INTO messages (user_id, message, created_at) VALUES (?, ?, NOW())");
        $stmt->execute([$user_id, $message]);

        // Update user's status to active
        $update = $conn->prepare("UPDATE users SET status = 'active' WHERE id = ?");
        $update->execute([$user_id]);

        // No output on success
        http_response_code(200);
        exit;
    } catch (Exception $e) {
        http_response_code(500);
        exit;
    }
} else {
    http_response_code(400);
    exit;
}
