<?php
session_start();
include 'db.php'; // DB connection file

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name       = $_POST['name'];
    $email      = $_POST['email'];
    $username   = $_POST['username'];
    $password   = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $profilePic = $_FILES['profile_pic']['name'];

    $targetDir = "../uploads/";
    $targetFile = $targetDir . basename($profilePic);

    // Move profile picture
    if (!move_uploaded_file($_FILES['profile_pic']['tmp_name'], $targetFile)) {
        die("Profile picture upload failed.");
    }

    // Check if user already exists
    $check = $conn->prepare("SELECT * FROM users WHERE email = ? OR username = ?");
    $check->bind_param("ss", $email, $username);
    $check->execute();
    $result = $check->get_result();

    if ($result->num_rows > 0) {
        echo "User already exists!";
        exit();
    }

    // Insert new user
    $stmt = $conn->prepare("INSERT INTO users (name, email, username, password, profile_pic, status) VALUES (?, ?, ?, ?, ?, 'active')");
    $stmt->bind_param("sssss", $name, $email, $username, $password, $profilePic);

    if ($stmt->execute()) {
        $_SESSION['user_id'] = $stmt->insert_id;
        $_SESSION['username'] = $username;
        echo "Signup successful!";
        header("Location: ../signin.html");
    } else {
        echo "Signup failed!";
    }

    $stmt->close();
    $conn->close();
}
?>
