# Sxodim_clone
Инструкция по запуску:
1) Запустить XAMPP
2) Включить Apache, MySQL
3) Перейти на сайт http://localhost/phpmyadmin/
4) Создать БД events
5) Написать следующие запросы в sql:
CREATE TABLE bookings (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(255) NOT NULL,
    event_id INT NOT NULL,
    quantity INT NOT NULL
);

CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(255) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL
);

7)Скачать папку Events и переместить ее в xampp/htdocs
8) Ввести в поисковую строку localhost/events/index.php
