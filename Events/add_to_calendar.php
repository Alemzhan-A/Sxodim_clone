<?php
session_start();
require_once 'db_connection.php';
require_once 'config.php';

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit;
}

$username = $_SESSION['username'];
$bookingId = $_POST['booking_id'];

$sql = "SELECT * FROM bookings WHERE id = ? AND username = ?";
$booking = null;

if ($stmt = $mysqli->prepare($sql)) {
    $stmt->bind_param("is", $bookingId, $username);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($row = $result->fetch_assoc()) {
        $booking = $row;
    }
    $stmt->close();
} else {
    echo "Ошибка: " . $mysqli->error;
}

if ($booking) {
    $events = json_decode(file_get_contents('data/events.json'), true);
    $event = null;

    foreach ($events as $ev) {
        if ($ev['id'] == $booking['event_id']) {
            $event = $ev;
            break;
        }
    }

    if ($event) {
        $client = getClient();
        if (!$client->getAccessToken()) {
            header('Location: oauth2callback.php');
            exit();
        }

        $service = new Google_Service_Calendar($client);

        $startDateTime = $event['date'] . 'T' . $event['time'] . ':00';
        $endDateTime = date('Y-m-d\TH:i:s', strtotime($startDateTime) + 3600); // +1 час к началу

        $googleEvent = new Google_Service_Calendar_Event(array(
            'summary' => $event['name'],
            'location' => $event['place'],
            'description' => isset($event['description']) ? $event['description'] : '',
            'start' => array(
                'dateTime' => $startDateTime,
                'timeZone' => 'Asia/Almaty',
            ),
            'end' => array(
                'dateTime' => $endDateTime,
                'timeZone' => 'Asia/Almaty', 
            ),
        ));
        try {
            $calendarId = 'primary';
            $createdEvent = $service->events->insert($calendarId, $googleEvent);
            echo 'Event created: ' . $createdEvent->htmlLink . '<br>';
        } catch (Google_Service_Exception $e) {
            echo 'Error: ' . $e->getMessage() . '<br>';
            echo 'Request data: <pre>' . print_r($googleEvent, true) . '</pre>';
        }
    } else {
        echo "Мероприятие не найдено.";
    }
} else {
    echo "Бронирование не найдено.";
}

$mysqli->close();
?>
