<?php require_once 'db.php'; ?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Система Кинотеатра</title>
    <style>
        body { font-family: sans-serif; background: #f0f2f5; padding: 20px; }
        .container { max-width: 1100px; margin: 0 auto; background: #fff; padding: 25px; border-radius: 10px; box-shadow: 0 4px 6px rgba(0,0,0,0.1); }
        .panels { display: flex; gap: 20px; margin-bottom: 25px; }
        .panel { flex: 1; padding: 15px; border: 1px solid #ddd; border-radius: 8px; background: #fafafa; }
        label { font-size: 12px; color: #666; font-weight: bold; }
        input { width: 100%; padding: 10px; margin: 5px 0 15px 0; box-sizing: border-box; border: 1px solid #ccc; border-radius: 4px; }
        button { width: 100%; padding: 12px; border: none; border-radius: 4px; cursor: pointer; color: white; font-weight: bold; }
        .btn-add { background: #28a745; }
        .btn-search { background: #007bff; }
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #ddd; padding: 12px; text-align: left; }
        th { background: #f8f9fa; }
        .error { color: #721c24; background: #f8d7da; padding: 10px; margin-bottom: 15px; border-radius: 4px; }
        .success { color: #155724; background: #d4edda; padding: 10px; margin-bottom: 15px; border-radius: 4px; }
    </style>
</head>
<body>
<div class="container">
    <h2>Продажа билетов: Кинотеатр</h2>

    <?php if (isset($_GET['error'])) echo "<div class='error'>{$_GET['error']}</div>"; ?>
    <?php if (isset($_GET['success'])) echo "<div class='success'>Билет успешно оформлен!</div>"; ?>

    <div class="panels">
        <div class="panel">
            <h3>Оформить билет</h3>
            <form action="process.php" method="POST">
                <label>Фильм (можно с цифрами):</label>
                <input type="text" name="movie" placeholder="Напр: Джон Уик 4" required>
                
                <label>Дата и время сеанса:</label>
                <input type="datetime-local" name="show_time" required>
                
                <label>Цена билета (руб):</label>
                <input type="number" name="price" placeholder="500" required>
                
                <label>Имя зрителя (без цифр):</label>
                <input type="text" name="visitor" placeholder="Иванов Иван" required>
                
                <button type="submit" class="btn-add">Подтвердить продажу</button>
            </form>
        </div>

        <div class="panel">
            <h3>Поиск сеансов</h3>
            <form action="index.php" method="GET">
                <label>Введите название фильма:</label>
                <input type="text" name="search" placeholder="Поиск..." 
                       value="<?php echo isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>">
                <button type="submit" class="btn-search">Найти билеты</button>
                <p style="text-align:center;"><a href="index.php" style="color: #666; font-size: 14px;">Сбросить поиск</a></p>
            </form>
        </div>
    </div>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Дата покупки</th>
                <th>Фильм</th>
                <th>Дата и время сеанса</th>
                <th>Цена</th>
                <th>Зритель</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $q = isset($_GET['search']) ? trim($_GET['search']) : '';
            if ($q !== '') {
                $stmt = $pdo->prepare("SELECT * FROM cinema_tickets WHERE movie_title LIKE ? ORDER BY show_time ASC");
                $stmt->execute(["%$q%"]);
            } else {
                $stmt = $pdo->query("SELECT * FROM cinema_tickets ORDER BY id DESC");
            }

            foreach ($stmt->fetchAll() as $row) {
                $nice_time = date('d.m.Y H:i', strtotime($row['show_time']));
                
                echo "<tr>
                    <td>{$row['id']}</td>
                    <td>{$row['created_at']}</td>
                    <td>{$row['movie_title']}</td>
                    <td>{$nice_time}</td>
                    <td>" . number_format($row['price'], 0, '', ' ') . " руб.</td>
                    <td>{$row['visitor_name']}</td>
                </tr>";
            }
            ?>
        </tbody>
    </table>
</div>
</body>
</html>