<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Автосалон - Учет продаж</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        .form-container { margin-bottom: 30px; padding: 15px; border: 1px solid #ccc; width: 300px; display: inline-block; vertical-align: top;}
        .search-container { margin-bottom: 30px; padding: 15px; border: 1px solid #007BFF; width: 300px; display: inline-block; vertical-align: top; margin-left: 20px;}
        input[type="text"], input[type="number"] { width: 100%; margin-bottom: 10px; padding: 5px; box-sizing: border-box;}
        table { border-collapse: collapse; width: 800px; }
        th, td { border: 1px solid #000; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
    </style>
</head>
<body>

    <?php
    if (isset($_GET['error'])) {
        echo "<div style='color: #721c24; background-color: #f8d7da; border: 1px solid #f5c6cb; padding: 15px; margin-bottom: 20px; width: 600px; border-radius: 5px;'>";
        echo htmlspecialchars($_GET['error']);
        echo "</div>";
    }

    if (isset($_GET['success']) && $_GET['success'] == 1) {
        echo "<div style='color: #155724; background-color: #d4edda; border: 1px solid #c3e6cb; padding: 15px; margin-bottom: 20px; width: 600px; border-radius: 5px;'>";
        echo "Автомобиль успешно добавлен в базу!";
        echo "</div>";
    }
    ?>
    
    <h2>Регистрация продажи автомобиля</h2>
    
    <div class="form-container">
        <form action="process.php" method="POST">
            <label>Марка автомобиля:</label>
            <input type="text" name="brand" required>

            <label>Модель:</label>
            <input type="text" name="model" required>

            <label>Цена (руб):</label>
            <input type="number" name="price" required>

            <label>ФИО клиента:</label>
            <input type="text" name="client" required>

            <button type="submit">Сохранить данные</button>
        </form>
    </div>

    <div class="search-container">
        <form action="" method="GET">
            <label>Поиск по марке автомобиля:</label>
            <input type="text" name="search" placeholder="Например: Toyota" 
                   value="<?php echo isset($_GET['search']) ? $_GET['search'] : ''; ?>">
            
            <button type="submit">Найти</button>
            <a href="index.php"><button type="button">Сбросить</button></a>
        </form>
    </div>

    <h2>Список проданных автомобилей</h2>
    <table>
        <tr>
            <th>Дата</th>
            <th>Марка</th>
            <th>Модель</th>
            <th>Цена</th>
            <th>Клиент</th>
        </tr>
        <?php
        $searchQuery = isset($_GET['search']) ? trim($_GET['search']) : '';

        $filename = 'cars.csv';
        if (file_exists($filename)) {
            $file = fopen($filename, 'r');
            
            while (($row = fgetcsv($file, 1000, ";")) !== FALSE) {
                if ($searchQuery !== '' && stripos($row[1], $searchQuery) === false) {
                    continue; 
                }

                echo "<tr>";
                foreach ($row as $cell) {
                    echo "<td>" . $cell . "</td>";
                }
                echo "</tr>";
            }
            fclose($file);
        } else {
            echo "<tr><td colspan='5'>Данных пока нет.</td></tr>";
        }
        ?>
    </table>

</body>
</html>