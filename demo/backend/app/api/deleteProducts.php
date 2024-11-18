<?php

header("Content-Type: application/json");

include __DIR__ . '/../config/dbConfig.php';
include __DIR__ . '/../models/product.php';

use App\Config\DbConfig;
use App\Models\Product;

$database = new DbConfig();
$db = $database->getConnection();

$path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

// Menggunakan preg_match untuk menangkap ID
if (preg_match("/^\/api\/delete\/(\d+)$/", $path, $matches)) {
    $id = $matches[1];  // Ambil ID dari URL
} else {
    echo json_encode(["message" => "Id parameter is required."]);
    exit;
}

$product = new Product($db);

// Pastikan ID valid dan bukan kosong
if (empty($id)) {
    echo json_encode(["message" => "Invalid ID."]);
    exit;
}

// Proses penghapusan produk berdasarkan ID
if ($product->delete($id)) {
    echo json_encode(["message" => "Product deleted successfully."]);
} else {
    echo json_encode(["message" => "Failed to delete product."]);
}
