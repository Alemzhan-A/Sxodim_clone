<?php
session_start();
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Список мероприятий</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <header>
        <h1>Предстоящие мероприятия</h1>
        <div class="header-right">
            <?php if (isset($_SESSION['username'])): ?>
                <a href="profile.php" class="header-button"><?php echo htmlspecialchars($_SESSION['username']); ?></a>
                <a href="logout.php" class="header-button">Выйти</a>
            <?php else: ?>
                <a href="login.php" class="header-button">Логин</a>
                <a href="register.php" class="header-button">Регистрация</a>
            <?php endif; ?>
        </div>
    </header>
    <main>
        <div class="events-container">
            <?php
            include 'db_connection.php';
            $events = json_decode(file_get_contents('data/events.json'), true);
            foreach ($events as $event): ?>
                <div class="event-card">
                    <img src="<?php echo $event['image']; ?>" alt="Изображение мероприятия">
                    <h2><?php echo $event['name']; ?></h2>
                    <p><strong>Дата:</strong> <?php echo $event['date']; ?> <strong>Время:</strong> <?php echo $event['time']; ?></p>
                    <p><strong>Место:</strong> <?php echo $event['place']; ?></p>
                    <p><strong>Доступно билетов:</strong> <?php echo $event['available']; ?></p>
                    <a href="event.php?id=<?php echo $event['id']; ?>" class="button">Подробнее</a>
                </div>
            <?php endforeach; ?>
        </div>
    </main>
</body>
</html>
