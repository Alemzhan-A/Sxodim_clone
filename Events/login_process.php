<?php
include 'db_connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM users WHERE username = ?";
    if ($stmt = $mysqli->prepare($sql)) {
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows === 1) {
            $row = $result->fetch_assoc();
            if (password_verify($password, $row['password'])) {
                session_start();
                $_SESSION['username'] = $username;
                header("Location: index.php?message=success");
                exit;
            } else {
                header("Location: login.php?message=error&reason=incorrect_password");
            }
        } else {
            header("Location: login.php?message=error&reason=user_not_found");
        }
        $stmt->close();
    } else {
        header("Location: login.php?message=error&reason=" . urlencode($mysqli->error));
    }
    $mysqli->close();
}
?>
