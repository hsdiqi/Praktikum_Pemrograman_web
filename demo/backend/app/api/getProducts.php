<?php

header("Content-Type: application/json");

include  "./app/config/dbConfig.php";
include "./app/models/product.php";

use App\Config\DbConfig;
use App\Models\Product;

$database = new DbConfig();
$db = $database->getConnection();

$product = new Product($db);
$products = $product->readAll(); // `readAll()` mengembalikan array langsung

if (empty($products)) {
    echo json_encode(["message" => "No products found."]);  // Jika tidak ada produk
} else {
    echo json_encode($products); // Langsung encode hasil dari `readAll()`
}


var_dump(__DIR__);
var_dump(class_exists('App\Config\DbConfig'));
