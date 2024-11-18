<?php

header("Content-Type: application/json");

include __DIR__ . '/../config/dbConfig.php';
include __DIR__ . '/../models/product.php';

use App\Config\DbConfig;
use App\Models\Product;

$database = new DbConfig();
$db = $database->getConnection();

$product = new Product($db);

// Membaca data JSON yang dikirimkan
$data = json_decode(file_get_contents("php://input"), true); // Menggunakan true untuk mengembalikan array asosiatif

// Memeriksa apakah data lengkap
if (!isset($data['name']) || !isset($data['brand'])) {
    echo json_encode(["message" => "All fields are required."]);
    exit;
}

// Menetapkan nilai properti pada objek Product
$product->name = $data['name'];
$product->brand = $data['brand'];

// Memanggil metode create() untuk menyimpan produk baru
if ($product->createName($data)) {
    echo json_encode(["message" => "Product created successfully."]);
} else {
    echo json_encode(["message" => "Failed to create product."]);
}
