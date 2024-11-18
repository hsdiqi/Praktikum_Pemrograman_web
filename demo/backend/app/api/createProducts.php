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
if (!isset($data['name']) || !isset($data['brand']) || !isset($data['description']) || !isset($data['price']) || !isset($data['category']) || !isset($data['stok']) || !isset($data['muchBought']) || !isset($data['image'])) {
    echo json_encode(["message" => "All fields are required."]);
    exit;
}

// Menetapkan nilai properti pada objek Product
$product->name = $data['name'];
$product->brand = $data['brand'];
$product->description = $data['description'];
$product->price = $data['price'];
$product->category = $data['category'];
$product->stok = $data['stok'];
$product->muchBought = $data['muchBought'];
$product->image = $data['image'];  // Base64 image

// Memanggil metode create() untuk menyimpan produk baru
if ($product->create($data)) {
    echo json_encode(["message" => "Product created successfully."]);
} else {
    echo json_encode(["message" => "Failed to create product."]);
}
