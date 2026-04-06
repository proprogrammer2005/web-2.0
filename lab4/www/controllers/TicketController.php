<?php
class TicketController {
    
    public function __construct() {
        $this->initializeDatabase();
    }

    private function initializeDatabase() {
        $db = Database::getConnection();
        
        $db->exec("CREATE TABLE IF NOT EXISTS visitors (id INT AUTO_INCREMENT PRIMARY KEY, name VARCHAR(100) NOT NULL)");
        $db->exec("CREATE TABLE IF NOT EXISTS movies (id INT AUTO_INCREMENT PRIMARY KEY, title VARCHAR(100), show_time DATETIME, price INT)");
        
        $db->exec("CREATE TABLE IF NOT EXISTS tickets (
            id INT AUTO_INCREMENT PRIMARY KEY, 
            visitor_id INT, 
            movie_id INT, 
            created_at DATETIME,
            FOREIGN KEY (visitor_id) REFERENCES visitors(id),
            FOREIGN KEY (movie_id) REFERENCES movies(id)
        )");
    }

    public function index() {
        $search = isset($_GET['search']) ? trim($_GET['search']) : '';
        $tickets = Ticket::getAllWithDetails($search);
        
        require_once 'views/home.php';
    }

    public function add() {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $movie   = trim($_POST['movie']);
            $time    = trim($_POST['show_time']);
            $price   = trim($_POST['price']);
            $visitor = trim($_POST['visitor']);

            if (empty($movie) || empty($time) || empty($price) || empty($visitor)) {
                header("Location: /?error=" . urlencode("Заполните все поля")); exit();
            }
            if (!preg_match("/^[a-zA-Zа-яА-ЯёЁ0-9\s\-]+$/u", $movie)) {
                header("Location: /?error=" . urlencode("Недопустимые символы в фильме")); exit();
            }
            if (!preg_match("/^[a-zA-Zа-яА-ЯёЁ\s\-]+$/u", $visitor)) {
                header("Location: /?error=" . urlencode("В имени не должно быть цифр")); exit();
            }

            $visitorId = Visitor::findOrCreate($visitor);
            $movieId = Movie::findOrCreate($movie, $time, $price);
            Ticket::create($visitorId, $movieId);

            header("Location: /?success=1");
            exit();
        }
    }
}
?>