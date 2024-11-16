<?php

header("Content-Type: application/json");
include_once '../config/dbConfig.php';
include_once '../models/Product.php';

use Demo\Backend\Config\DbConfig;
use Demo\Backend\Models\Product;

$database = new DbConfig();
$db = $database->getConnection();

$product = new Product($db);
$products = $product->readAll(); // `readAll()` mengembalikan array langsung

if (empty($products)) {
    echo json_encode(["message" => "No products found."]);  // Jika tidak ada produk
} else {
    echo json_encode($products); // Langsung encode hasil dari `readAll()`
}
