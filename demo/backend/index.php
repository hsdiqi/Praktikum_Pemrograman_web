<?php

// echo "Current Path: " . realpath(__DIR__ . '/app/routes/routesApp.php') . PHP_EOL;
// echo "Class Exists: " . (class_exists('App\Routes\RoutesApp') ? 'Yes' : 'No');

header("Content-Type: application/json");

include "./app/routes/routesApp.php";

use App\Routes\routesApp;


// Mendapatkan HTTP method dan path
$method = $_SERVER['REQUEST_METHOD'];
$path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

// Inisialisasi ProductRoutes
$productRoutes = new routesApp();

// Panggil handler untuk menangani request
$productRoutes->handle($method, $path);
