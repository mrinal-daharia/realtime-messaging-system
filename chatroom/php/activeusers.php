<?php
session_start();
include 'db.php';

$stmt = $conn->prepare("SELECT id, username, profile_pic, last_active FROM users");
$stmt->execute();
$users = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Add status based on last active time (5 mins threshold)
foreach ($users as &$user) {
    $last_active = strtotime($user['last_active']);
    $is_active = (time() - $last_active <= 300); // 5 minutes
    $user['status'] = $is_active ? 'active' : 'inactive';
}

echo json_encode($users);
?>
