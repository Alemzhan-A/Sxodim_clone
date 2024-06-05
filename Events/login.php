<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Логин</title>
    <link rel="stylesheet" href="css/auth-style.css">
</head>
<body>
    <header>
        <h1>Вход в систему</h1>
    </header>
    <div class="main-container">
        <div class="form-container">
            <h2>Логин</h2>
            <form action="login_process.php" method="post">
                <label for="username">Имя пользователя</label>
                <input type="text" id="username" name="username" required>
                
                <label for="password">Пароль</label>
                <input type="password" id="password" name="password" required>
                
                <button type="submit">Войти</button>
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
