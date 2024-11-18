<?php

header("Content-Type: application/json");

include  "./app/config/dbConfig.php";
include "./app/models/product.php";

use App\Config\DbConfig;
use App\Models\Product;

$database = new DbConfig();
$db = $database->getConnection();

$product = new Product($db);

// Ambil path dari request URL
$path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
error_log("path: ". $path);

// Ekstrak parameter 'brand' dari path
if (strpos($path, "/api/allProducts/ByBrand/") === 0) {
    $brand = str_replace("/api/allProducts/ByBrand/", "", $path);
} else {
    echo json_encode(["message" => "Brand parameter is required."]);
    exit;
}

$product = new Product($db);
$products = $product->readByBrand($brand);

if (empty($products)) {
    echo json_encode(["message" => "No products found for brand: $brand"]);
} else {
    echo json_encode($products);
}

?>