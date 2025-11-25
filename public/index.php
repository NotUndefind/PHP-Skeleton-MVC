<?php

require_once __DIR__ . '/../vendor/autoload.php';

use App\Router\Router;
use App\Controllers\FormController;

// Créer une instance du router
$router = new Router();

// Créer une instance du controller
$controller = new FormController();

// Définir les routes
$router->get('/', [$controller, 'showForm']);
$router->post('/submit', [$controller, 'handleSubmit']);
$router->get('/email', [$controller, 'showEmailForm']);
$router->post('/email', [$controller, 'sendEmail']);

// Lancer le router
$router->run();
