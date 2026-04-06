<?php
require_once 'db.php';

echo "<h3>Инициализация системы Кинотеатра</h3>";

$sql = "
    CREATE TABLE IF NOT EXISTS cinema_tickets (
        id INT AUTO_INCREMENT PRIMARY KEY,
        created_at DATETIME NOT NULL,
        movie_title VARCHAR(100) NOT NULL,
        show_time DATETIME NOT NULL,
        price INT NOT NULL,
        visitor_name VARCHAR(100) NOT NULL
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
";
$pdo->exec($sql);
echo "Таблица 'cinema_tickets' готова.<br>";

$filename = 'tickets.csv';
if (file_exists($filename)) {
    $file = fopen($filename, 'r');
    
    $stmt = $pdo->prepare("INSERT INTO cinema_tickets (created_at, movie_title, show_time, price, visitor_name) VALUES (?, ?, ?, ?, ?)");
    
    $count = 0;
    while (($row = fgetcsv($file, 1000, ";")) !== FALSE) {
        $stmt->execute([$row[0], $row[1], $row[2], $row[3], $row[4]]);
        $count++;
    }
    fclose($file);
    
    rename($filename, 'tickets_imported.bak');
    echo "Данные из CSV успешно перенесены в БД. Записей: <b>$count</b>";
} else {
    echo "Файл tickets.csv не найден. Возможно, импорт уже был выполнен.";
}

echo "<br><br><a href='index.php'><button>Перейти к просмотру записей</button></a>";
?>