<?php
require_once 'core/Database.php';
require_once 'core/Router.php';
require_once 'models/Movie.php';
require_once 'models/Visitor.php';
require_once 'models/Ticket.php';
require_once 'controllers/TicketController.php';

$router = new Router();

$router->add('/', 'TicketController', 'index');
$router->add('/add', 'TicketController', 'add');

$router->run();
?>