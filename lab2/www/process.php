<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    $brand  = trim($_POST['brand']);
    $model  = trim($_POST['model']);
    $price  = trim($_POST['price']);
    $client = trim($_POST['client']);

    if (empty($brand) || empty($model) || empty($client) || empty($price)) {
        $error = "Ошибка: Все поля должны быть заполнены!";
        header("Location: index.php?error=" . urlencode($error));
        exit();
    }

    if (!is_numeric($price) || $price <= 0) {
        $error = "Ошибка: Цена должна быть положительным числом!";
        header("Location: index.php?error=" . urlencode($error));
        exit();
    }

    if (mb_strlen($brand) > 50) {
        $error = "Ошибка: Название марки слишком длинное!";
        header("Location: index.php?error=" . urlencode($error));
        exit();
    }

    if (!preg_match("/^[a-zA-Zа-яА-ЯёЁ\s\-]+$/u", $client)) {
        $error = "Ошибка: ФИО клиента может содержать только буквы, пробелы и дефис!";
        header("Location: index.php?error=" . urlencode($error));
        exit();
    }

    if (!preg_match("/^[a-zA-Zа-яА-ЯёЁ\s\-]+$/u", $brand)) {
        $error = "Ошибка: Марка автомобиля должна содержать только буквы (без цифр)!";
        header("Location: index.php?error=" . urlencode($error));
        exit();
    }
    
    $date = date("Y-m-d H:i:s");
    $data = [$date, $brand, $model, $price, $client];

    $file = fopen('cars.csv', 'a');
    fputcsv($file, $data, ";");
    fclose($file);

    header("Location: index.php?success=1");
    exit();

} else {
    echo "Ошибка: Данные должны передаваться методом POST.";
}
?>