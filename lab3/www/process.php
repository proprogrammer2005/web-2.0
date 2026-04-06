<?php
require_once 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $movie   = trim($_POST['movie']);
    $time    = trim($_POST['show_time']);
    $price   = trim($_POST['price']);
    $visitor = trim($_POST['visitor']);

    $movie_pattern = "/^[a-zA-Zа-яА-ЯёЁ0-9\s\-]+$/u";
    $name_pattern = "/^[a-zA-Zа-яА-ЯёЁ\s\-]+$/u";

    if (empty($movie) || empty($time) || empty($price) || empty($visitor)) {
        header("Location: index.php?error=Заполните все поля"); exit();
    }
    
    if (!preg_match($movie_pattern, $movie)) {
        header("Location: index.php?error=Недопустимые символы в названии фильма"); exit();
    }

    if (!preg_match($name_pattern, $visitor)) {
        header("Location: index.php?error=В имени зрителя не должно быть цифр"); exit();
    }

    $sql = "INSERT INTO cinema_tickets (created_at, movie_title, show_time, price, visitor_name) 
            VALUES (NOW(), :movie, :time, :price, :visitor)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['movie' => $movie, 'time' => $time, 'price' => $price, 'visitor' => $visitor]);

    header("Location: index.php?success=1");
    exit();
}