<?php
session_start();
include 'db_connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_SESSION['username'])) {
    $event_id = $_POST['event_id'];
    $quantity = $_POST['quantity'];
    $username = $_SESSION['username'];
    $events = json_decode(file_get_contents('data/events.json'), true);
    $event_key = array_search($event_id, array_column($events, 'id'));
    if ($event_key !== false && $events[$event_key]['available'] >= $quantity) {
        $events[$event_key]['available'] -= $quantity;
        file_put_contents('data/events.json', json_encode($events, JSON_PRETTY_PRINT));
        $sql = "INSERT INTO bookings (username, event_id, quantity) VALUES (?, ?, ?)";
        if ($stmt = $mysqli->prepare($sql)) {
            $stmt->bind_param("sii", $username, $event_id, $quantity);
            if ($stmt->execute()) {
                header("Location: event.php?id=$event_id&message=success");
                exit;
            } else {
                header("Location: event.php?id=$event_id&message=error&reason=" . urlencode($stmt->error));
            }
            $stmt->close();
        }
    } else {
        header("Location: event.php?id=$event_id&message=error&reason=not_enough_tickets");
    }
} else {
    header("Location: login.php");
}
$mysqli->close();
?>
