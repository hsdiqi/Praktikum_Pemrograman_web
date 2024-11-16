<?php

header("Content-Type: application/json");
include_once '../config/dbConfig.php';
include_once '../models/Product.php';

use Demo\Backend\Config\DbConfig;
use Demo\Backend\Models\Product;

$database = new DbConfig();
$db = $database->getConnection();

// Pastikan parameter id ada dalam URL
if (!isset($_GET['id'])) {
    echo json_encode(["message" => "ID parameter is required."]);
    exit;
}

// Ambil ID produk dari URL
$id = $_GET['id'];

// Ambil data JSON dari request body
$data = json_decode(file_get_contents("php://input"));

// Pastikan data JSON valid
if (is_null($data)) {
    echo json_encode(["message" => "Invalid JSON data."]);
    exit;
}

// Pastikan semua data yang diperlukan ada dalam request
if (!isset($data->name) || !isset($data->brand) || !isset($data->description) || !isset($data->price) || !isset($data->category) || !isset($data->stok) || !isset($data->muchBought) || !isset($data->image)) {
    echo json_encode(["message" => "All fields are required."]);
    exit;
}

// Membuat objek Product
$product = new Product($db);

// Mengisi properti objek Product dengan data yang diterima
$product->name = $data->name;
$product->brand = $data->brand;
$product->description = $data->description;
$product->price = $data->price;
$product->category = $data->category;
$product->stok = $data->stok;
$product->muchBought = $data->muchBought;
$product->image = $data->image;

// Memanggil metode update() dan memberikan parameter id dan data produk
if ($product->update($id, (array)$data)) {
    echo json_encode(["message" => "Product updated successfully."]);
} else {
    echo json_encode(["message" => "Failed to update product."]);
}
