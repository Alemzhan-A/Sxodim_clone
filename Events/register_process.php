<?php
include 'db_connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['new_username'];
    $password = password_hash($_POST['new_password'], PASSWORD_DEFAULT);
    $sql = "INSERT INTO users (username, password) VALUES (?, ?)";
    if ($stmt = $mysqli->prepare($sql)) {
        $stmt->bind_param("ss", $username, $password);

        if ($stmt->execute()) {
            session_start();
            $_SESSION['username'] = $username;
            header("Location: index.php?message=success");
            exit;
        } else {
            header("Location: register.php?message=error&reason=" . urlencode($stmt->error));
        }
        $stmt->close();
    } else {
        header("Location: register.php?message=error&reason=" . urlencode($mysqli->error));
    }
    $mysqli->close();
}
?>
