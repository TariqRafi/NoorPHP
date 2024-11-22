<?php
// routes/web.php

// Include the controller
require_once __DIR__ . '../app/Controllers/HomeController.php';

// Define all routes here
$router->get('/', 'HomeController@index')
       ->get('/about', 'HomeController@about');
