<?php
class Ticket {
    public static function create($visitorId, $movieId) {
        $db = Database::getConnection();
        $stmt = $db->prepare("INSERT INTO tickets (visitor_id, movie_id, created_at) VALUES (?, ?, NOW())");
        $stmt->execute([$visitorId, $movieId]);
    }

    public static function getAllWithDetails($searchQuery = '') {
        $db = Database::getConnection();
        $sql = "SELECT t.id, t.created_at, m.title as movie_title, m.show_time, m.price, v.name as visitor_name 
                FROM tickets t
                JOIN visitors v ON t.visitor_id = v.id
                JOIN movies m ON t.movie_id = m.id ";
        
        if ($searchQuery !== '') {
            $sql .= "WHERE m.title LIKE ? ORDER BY m.show_time ASC";
            $stmt = $db->prepare($sql);
            $stmt->execute(["%$searchQuery%"]);
        } else {
            $sql .= "ORDER BY t.id DESC";
            $stmt = $db->query($sql);
        }
        return $stmt->fetchAll();
    }
}
?>