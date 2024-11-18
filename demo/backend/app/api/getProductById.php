<?php

header("Content-Type: application/json");
include_once '../config/dbConfig.php';
include_once '../models/Product.php';

use App\Config\DbConfig;
use App\Models\Product;

$database = new DbConfig();
$db = $database->getConnection();

$product = new Product($db);

$path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

if (strpos($path, "/api/product/") === 0) {
    $id = str_replace("/api/product/","", $path);
}else {
    echo json_encode(["message" => "Id parameter is required."]);
    exit;
}

$product = new Product($db);
$products = $product->readById($id);

if (empty($products)) {
    echo json_encode(["message" => "No products found for brand: $id"]);
} else {
    echo json_encode($products);
}
