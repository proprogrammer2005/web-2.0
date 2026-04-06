<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Кинотеатр (MVC)</title>
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
    <h2>Продажа билетов</h2>

    <?php if (isset($_GET['error'])) echo "<div class='error'>" . htmlspecialchars($_GET['error']) . "</div>"; ?>
    <?php if (isset($_GET['success'])) echo "<div class='success'>Билет успешно оформлен!</div>"; ?>

    <div class="panels">
        <div class="panel">
            <h3>Оформить билет</h3>
            <form action="/add" method="POST">
                <label>Фильм (можно с цифрами):</label>
                <input type="text" name="movie" required>
                <label>Дата и время сеанса:</label>
                <input type="datetime-local" name="show_time" required>
                <label>Цена билета (руб):</label>
                <input type="number" name="price" required>
                <label>Имя зрителя (без цифр):</label>
                <input type="text" name="visitor" required>
                <button type="submit" class="btn-add">Подтвердить продажу</button>
            </form>
        </div>

        <div class="panel">
            <h3>Поиск сеансов</h3>
            <form action="/" method="GET">
                <label>Введите название фильма:</label>
                <input type="text" name="search" value="<?php echo htmlspecialchars($search); ?>">
                <button type="submit" class="btn-search">Найти билеты</button>
                <p style="text-align:center;"><a href="/">Сбросить поиск</a></p>
            </form>
        </div>
    </div>

    <table>
        <thead>
            <tr><th>ID Покупки</th><th>Дата оформления</th><th>Фильм</th><th>Сеанс</th><th>Цена</th><th>Зритель</th></tr>
        </thead>
        <tbody>
            <?php foreach ($tickets as $t): ?>
                <tr>
                    <td><?php echo $t['id']; ?></td>
                    <td><?php echo $t['created_at']; ?></td>
                    <td><?php echo htmlspecialchars($t['movie_title']); ?></td>
                    <td><?php echo date('d.m.Y H:i', strtotime($t['show_time'])); ?></td>
                    <td><?php echo number_format($t['price'], 0, '', ' '); ?> руб.</td>
                    <td><?php echo htmlspecialchars($t['visitor_name']); ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
</body>
</html>