<?php

header("Content-Type: application/json");
include_once '../config/dbConfig.php';
include_once '../models/Product.php';

use Demo\Backend\Config\DbConfig;
use Demo\Backend\Models\Product;

$database = new DbConfig();
$db = $database->getConnection();

$product = new Product($db);

// Ambil parameter 'brand' dari query string
if (!isset($_GET['brand'])) {
    echo json_encode(["message" => "Brand parameter is required."]);
    exit;
}

$brand = $_GET['brand']; // Ambil merek dari parameter URL

$products = $product->readByBrand($brand);

if (empty($products)) {
    echo json_encode(["message" => "No products found for brand: $brand"]);
} else {
    echo json_encode($products);
}
