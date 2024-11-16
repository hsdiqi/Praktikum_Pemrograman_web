<?php

header("Content-Type: application/json");
include_once '../config/dbConfig.php';
include_once '../models/Product.php';

use Demo\Backend\Config\DbConfig;
use Demo\Backend\Models\Product;

$database = new DbConfig();
$db = $database->getConnection();

if (!isset($_GET['id'])) {
    echo json_encode(["message" => "Product ID is required."]);
    exit;
}

$id = $_GET['id']; 

$product = new Product($db);

if ($product->buyProduc($id)) {
    echo json_encode(["message" => "Product bought successfully."]);
} else {
    echo json_encode(["message" => "Failed to buy product."]);
}