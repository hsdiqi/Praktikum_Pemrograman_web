<?php

header("Content-Type: application/json");
include_once '../config/dbConfig.php';
include_once '../models/Product.php';

use Demo\Backend\Config\DbConfig;
use Demo\Backend\Models\Product;

$database = new DbConfig();
$db = $database->getConnection();

$product = new Product($db);

// Ambil parameter 'id' dari query string
if (!isset($_GET['id'])) {
    echo json_encode(["message" => "ID parameter is required."]);
    exit;
}

$id = $_GET['id']; // Ambil ID dari query string

// Panggil method `readById` dengan ID
$productData = $product->readById($id);

if (!$productData) {
    echo json_encode(["message" => "Product not found."]); // Jika produk tidak ditemukan
} else {
    echo json_encode($productData); // Tampilkan data produk
}
