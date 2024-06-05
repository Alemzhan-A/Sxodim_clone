<?php
session_start();
include 'db_connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_SESSION['username'])) {
    $booking_id = $_POST['booking_id'];
    $sql = "SELECT event_id, quantity FROM bookings WHERE id = ?";
    if ($stmt = $mysqli->prepare($sql)) {
        $stmt->bind_param("i", $booking_id);
        $stmt->execute();
        $stmt->bind_result($event_id, $quantity);
        $stmt->fetch();
        $stmt->close();
        $sql = "DELETE FROM bookings WHERE id = ?";
        if ($stmt = $mysqli->prepare($sql)) {
            $stmt->bind_param("i", $booking_id);
            $stmt->execute();
            $stmt->close();
        }
        $events = json_decode(file_get_contents('data/events.json'), true);
        $event_key = array_search($event_id, array_column($events, 'id'));

        if ($event_key !== false) {
            $events[$event_key]['available'] += $quantity;
            file_put_contents('data/events.json', json_encode($events, JSON_PRETTY_PRINT));
        }

        header("Location: profile.php");
        exit;
    } else {
        echo "Ошибка: " . $mysqli->error;
    }
} else {
    header("Location: login.php");
}
$mysqli->close();
?>
