<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    http_response_code(403);
    exit("User not logged in.");
}

include 'db.php';

try {
    $sql = "SELECT username, status FROM users";
    $result = $conn->query($sql);

    $users = [];
    if ($result && $result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $users[] = $row;
        }
    }

    header('Content-Type: application/json');
    echo json_encode($users);
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['error' => 'Failed to fetch users']);
}
