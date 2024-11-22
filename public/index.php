<?php
// Include the Router class from the core directory
require_once __DIR__ . '/../core/Router.php';

// Include the routes file where the routes are defined
require_once __DIR__ . '/../routes/web.php';

// Instantiate the router
$router = new Router();

// Get the current request method and URI
$method = $_SERVER['REQUEST_METHOD'];
$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

// Dispatch the current request
$router->dispatch($method, $uri);
