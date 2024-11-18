<?php

header("Content-Type: application/json"); 

include __DIR__ . '/../config/dbConfig.php';
include __DIR__ . '/../models/product.php';

use App\Config\DbConfig;
use App\Models\Product;

$database = new DbConfig();
$db = $database->getConnection();

$path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

if (strpos($path, "/api/buy/") === 0) {
    $id = str_replace("/api/buy/","", $path);
}else {
    echo json_encode(["message" => "Brand parameter is required."]);
    exit;
}

$product = new Product($db);

if ($product->buyProduc($id)) {
    echo json_encode(["message" => "Product bought successfully."]);
} else {
    echo json_encode(["message" => "Failed to buy product."]);
}