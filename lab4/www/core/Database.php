<?php
class Database {
    private static $pdo = null;

    public static function getConnection() {
        if (self::$pdo === null) {
            $host = 'db'; 
            $dbname = 'lab3_db';
            $user = 'appuser';
            $password = 'appPass';
            
            try {
                $dsn = "mysql:host=$host;dbname=$dbname;charset=utf8mb4";
                self::$pdo = new PDO($dsn, $user, $password);
                self::$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                self::$pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
            } catch (PDOException $e) {
                die("Ошибка подключения к БД: " . $e->getMessage());
            }
        }
        return self::$pdo;
    }
}
?>