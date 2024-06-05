<?php
session_start();
$events = json_decode(file_get_contents('data/events.json'), true);
$eventId = $_GET['id'];
$event = array_filter($events, function ($e) use ($eventId) { return $e['id'] == $eventId; });
$event = reset($event);
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title><?php echo $event['name']; ?></title>
    <link rel="stylesheet" href="css/eventss-styles.css">
</head>
<body>
    <header>
        <h1><?php echo $event['name']; ?></h1>
        <div class="header-right">
        <a href="index.php" class="header-button"> Обратно</a>
            <?php if (isset($_SESSION['username'])): ?>
                <span><?php echo htmlspecialchars($_SESSION['username']); ?></span>
                <a href="logout.php" class="header-button">Выйти</a>
            <?php else: ?>
                <a href="login.php" class="header-button">Логин</a>
                <a href="register.php" class="header-button">Регистрация</a>
            <?php endif; ?>
        </div>
    </header>
    <main>
        <div class="event-details">
            <img src="<?php echo $event['image']; ?>" alt="Изображение мероприятия">
            <p><strong>Дата:</strong> <?php echo $event['date']; ?></p>
            <p><strong>Время:</strong> <?php echo $event['time']; ?></p>
            <p><strong>Место:</strong> <?php echo $event['place']; ?></p>
            <p><strong>Доступно:</strong> <?php echo $event['available']; ?></p>
            <p><?php echo nl2br($event['description']); ?></p>

            <?php if (isset($_SESSION['username'])): ?>
                <form action="book_ticket.php" method="post">
                    <label for="quantity">Количество билетов:</label>
                    <input type="number" id="quantity" name="quantity" min="1" max="<?php echo $event['available']; ?>" required>
                    <input type="hidden" name="event_id" value="<?php echo $eventId; ?>">
                    <button type="submit">Забронировать билет</button>
                </form>
            <?php else: ?>
                <p><a href="login.php" class="header-button">Войдите в систему</a> для бронирования билетов.</p>
            <?php endif; ?>
        </div>
    </main>
</body>
</html>
