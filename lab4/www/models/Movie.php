<?php
class Movie {
    public static function findOrCreate($title, $time, $price) {
        $db = Database::getConnection();
        $stmt = $db->prepare("SELECT id FROM movies WHERE title = ? AND show_time = ?");
        $stmt->execute([$title, $time]);
        $movie = $stmt->fetch();

        if ($movie) {
            return $movie['id'];
        } else {
            $stmt = $db->prepare("INSERT INTO movies (title, show_time, price) VALUES (?, ?, ?)");
            $stmt->execute([$title, $time, $price]);
            return $db->lastInsertId();
        }
    }
}
?>