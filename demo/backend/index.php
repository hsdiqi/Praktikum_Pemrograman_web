<?php

header('Access-Control-Allow-Origin: http://127.0.0.1:5500'); // Allow your frontend origin
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS'); // Allowed methods
header('Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept, Authorization'); 

// echo "Current Path: " . realpath(__DIR__ . '/app/routes/routesApp.php') . PHP_EOL;
// echo "Class Exists: " . (class_exists('App\Routes\RoutesApp') ? 'Yes' : 'No');

header("Content-Type: application/json");

include "./app/routes/routesApp.php";

use App\Routes\routesApp;

if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
    // Jika metode OPTIONS, kirimkan status OK dan berhenti
    header("Access-Control-Allow-Origin: *");
    header("Access-Control-Allow-Methods: POST, GET, PUT, DELETE, OPTIONS");
    header("Access-Control-Allow-Headers: Content-Type");
    http_response_code(200);  // Status OK untuk preflight
    exit();
}

// Mendapatkan HTTP method dan path
$method = $_SERVER['REQUEST_METHOD'];
$path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);



// Inisialisasi ProductRoutes
$productRoutes = new routesApp();

// Panggil handler untuk menangani request
$productRoutes->handle($method, $path);
