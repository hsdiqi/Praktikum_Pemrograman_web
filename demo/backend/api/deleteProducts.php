<?php

header("Content-Type: application/json");
include_once '../config/dbConfig.php';
include_once '../models/Product.php';

use Demo\Backend\Config\DbConfig;
use Demo\Backend\Models\Product;

$database = new DbConfig();
$db = $database->getConnection();

$product = new Product($db);

$data = json_decode(file_get_contents("php://input"));

$product->id = $data->id;  // Mengambil id dari input JSON

if ($product->delete($product->id)) {
    echo json_encode(["message" => "Product deleted successfully."]);
} else {
    echo json_encode(["message" => "Failed to delete product."]);
}