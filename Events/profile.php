<?php
session_start();
include 'db_connection.php';

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit;
}

$username = $_SESSION['username'];

$sql = "SELECT * FROM bookings WHERE username = ?";
$bookings = [];

if ($stmt = $mysqli->prepare($sql)) {
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();
    while ($row = $result->fetch_assoc()) {
        $bookings[] = $row;
    }
    $stmt->close();
} else {
    echo "Ошибка: " . $mysqli->error;
}
$events = json_decode(file_get_contents('data/events.json'), true);

$userBookings = [];
foreach ($bookings as $booking) {
    foreach ($events as $event) {
        if ($event['id'] == $booking['event_id']) {
            $booking['event'] = $event;
            $userBookings[] = $booking;
            break;
        }
    }
}

$mysqli->close();
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Профиль пользователя</title>
    <link rel="stylesheet" href="css/profile-styles.css">
</head>
<body>
    <header>
        <h1><?php echo htmlspecialchars($username); ?></h1>
        <div class="header-right">
            <a href="logout.php" class="header-button">Выйти</a>
        </div>
    </header>
    <main>
        <h2>Мои бронирования</h2>
        <?php if (empty($userBookings)): ?>
            <p>У вас нет бронирований.</p>
        <?php else: ?>
            <table>
                <thead>
                    <tr>
                        <th>Мероприятие</th>
                        <th>Количество билетов</th>
                        <th>Дата</th>
                        <th>Время</th>
                        <th>Место</th>
                        <th>Действия</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($userBookings as $booking): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($booking['event']['name']); ?></td>
                            <td><?php echo htmlspecialchars($booking['quantity']); ?></td>
                            <td><?php echo htmlspecialchars($booking['event']['date']); ?></td>
                            <td><?php echo htmlspecialchars($booking['event']['time']); ?></td>
                            <td><?php echo htmlspecialchars($booking['event']['place']); ?></td>
                            <td>
                                <form action="cancel_booking.php" method="post">
                                    <input type="hidden" name="booking_id" value="<?php echo $booking['id']; ?>">
                                    <button type="submit">Отменить</button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
    </main>
</body>
</html>
