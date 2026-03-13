<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    $brand  = trim($_POST['brand']);
    $model  = trim($_POST['model']);
    $price  = trim($_POST['price']);
    $client = trim($_POST['client']);
    $date   = date("Y-m-d H:i:s");

    $data = [$date, $brand, $model, $price, $client];

    $file = fopen('cars.csv', 'a');
    
    fputcsv($file, $data, ";");
    
    fclose($file);

    header("Location: index.php");
    exit();
} else {
    echo "Ошибка: Данные должны передаваться методом POST.";
}
?>