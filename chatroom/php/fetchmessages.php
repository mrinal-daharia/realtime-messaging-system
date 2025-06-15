<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    http_response_code(403);
    exit("User not logged in.");
}

include 'db.php';

try {
    $currentUserId = $_SESSION['user_id'];

    $sql = "
        SELECT messages.*, users.username, users.profile_pic, users.id AS uid
        FROM messages
        JOIN users ON messages.user_id = users.id
        ORDER BY messages.created_at DESC
        LIMIT 100
    ";

    $result = $conn->query($sql);

    $messages = [];
    if ($result && $result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $row['is_self'] = ($row['uid'] == $currentUserId);
            $messages[] = $row;
        }
    }

    $messages = array_reverse($messages); // Oldest first

    header('Content-Type: application/json');
    echo json_encode($messages);
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['error' => 'Failed to fetch messages.']);
}
?>
