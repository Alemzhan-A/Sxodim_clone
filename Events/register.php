<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Регистрация</title>
    <link rel="stylesheet" href="css/auth-style.css">
</head>
<body>
    <header>
        <h1>Регистрация</h1>
    </header>
    <div class="main-container">
        <div class="form-container">
            <h2>Регистрация</h2>
            <form action="register_process.php" method="post">
                <label for="new_username">Имя пользователя</label>
                <input type="text" id="new_username" name="new_username" required>
                
                <label for="new_password">Пароль</label>
                <input type="password" id="new_password" name="new_password" required>
                
                <button type="submit">Зарегистрироваться</button>
            </form>
        </div>
    </div>
    <div id="message-modal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <p id="message-text"></p>
        </div>
    </div>
    <script src="js/messages.js"></script>
</body>
</html>
