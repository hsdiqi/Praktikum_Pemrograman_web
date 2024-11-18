<?php

header("Content-Type: application/json");

include __DIR__ . '/../config/dbConfig.php';
include __DIR__ . '/../models/product.php';

use App\Config\DbConfig;
use App\Models\Product;

$database = new DbConfig();
$db = $database->getConnection();

// Parsing ID dari path
$path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
if (strpos($path, '/api/update/') !== false) {
    $id = str_replace('/api/update/', '', $path);
} else {
    http_response_code(400);
    echo json_encode(["message" => "Invalid route."]);
    exit;
}

// Validasi ID
if (empty($id) || !ctype_digit($id)) {
    http_response_code(400);
    echo json_encode(["message" => "Invalid or missing product ID."]);
    exit;
}

// Ambil data JSON dari request body
$data = json_decode(file_get_contents("php://input"));

// Validasi data JSON
if (is_null($data)) {
    http_response_code(400);
    echo json_encode(["message" => "Invalid JSON data."]);
    exit;
}

// Validasi field yang diperlukan
// Validasi hanya untuk field yang wajib
if (empty($data->name) || empty($data->brand)) {
    http_response_code(400);
    echo json_encode(["message" => "Name and Brand are required."]);
    exit;
}

// Tetapkan nilai null untuk field opsional jika tidak diberikan
$description = isset($data->description) ? $data->description : null;
$price = isset($data->price) ? $data->price : null;
$category = isset($data->category) ? $data->category : null;
$stok = isset($data->stok) ? $data->stok : null;
$muchBought = isset($data->muchBought) ? $data->muchBought : null;
$imageBinary = isset($data->image) ? base64_decode($data->image) : null;


// Konversi image base64 ke binary
$imageBinary = base64_decode($data->image);
if ($imageBinary === false) {
    http_response_code(400);
    echo json_encode(["message" => "Invalid image format."]);
    exit;
}

// Membuat objek Product
$product = new Product($db);

// Mengisi properti objek Product
$product->name = $data->name;
$product->brand = $data->brand;
$product->description = $data->description;
$product->price = $data->price;
$product->category = $data->category;
$product->stok = $data->stok;
$product->muchBought = $data->muchBought;
$product->image = $imageBinary;

// Proses update
if ($product->update($id, (array)$data)) {
    http_response_code(200);
    echo json_encode(["message" => "Product updated successfully."]);
} else {
    http_response_code(500);
    echo json_encode(["message" => "Failed to update product."]);
}
