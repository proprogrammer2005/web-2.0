<?php
class Visitor {
    public static function findOrCreate($name) {
        $db = Database::getConnection();
        $stmt = $db->prepare("SELECT id FROM visitors WHERE name = ?");
        $stmt->execute([$name]);
        $visitor = $stmt->fetch();

        if ($visitor) {
            return $visitor['id'];
        } else {
            $stmt = $db->prepare("INSERT INTO visitors (name) VALUES (?)");
            $stmt->execute([$name]);
            return $db->lastInsertId();
        }
    }
}
?>