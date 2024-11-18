<?php

namespace App\Routes;

// echo "Hello in routes";

// echo "Current Path: " . realpath(__DIR__ . '/routes/routesApp.php') . PHP_EOL;
// echo "Class Exists: " . (class_exists('App\Routes\RoutesApp') ? 'Yes' : 'No');

class routesApp
{
    public function handle($method, $path)
    {
        if ($method === "GET" && $path === "/api/allProducts") {
            include __DIR__ . "/../api/getProducts.php";
            return;
        }

        if ($method === "GET" && strpos($path, "/api/allProducts/byBrand/") == 0) {
            $brand = str_replace("/api/productsByBrand/", "", $path);
            error_log("Nama Brand: " . $brand);

            // Pastikan 'brand' valid
            if (empty($brand)) {
                http_response_code(400);
                echo json_encode(["message" => "Brand name is missing"]);
                exit;
            }

            include __DIR__ . "/../api/getProductsByBrand.php";
            return;
        }

        if ($method === "GET" && strpos($path, "/api/product/") == 0) {
            $id = str_replace("/api/product", "", $path);
            error_log("Id:" . $id);

            if (empty($id)) {
                http_response_code(400);
                echo json_encode(["message" => "id is missing"]);
                exit;
            }

            include __DIR__ . "./../api/getProductById.php";
            return;
        }

        if ($method == "POST" && $path == "/api/addProduct") {
            include __DIR__ . "/../api/createProducts.php";
            return;
        }

        if ($method === "PUT" && preg_match("#^/api/update/(\d+)$#", $path, $matches)) {
            $id = $matches[1]; // Ambil ID dari path
            error_log("Id: " . $id);

            if (empty($id)) {
                http_response_code(400); // Bad Request
                echo json_encode(["message" => "ID is missing"]);
                exit;
            }

            include __DIR__ . "/../api/updateProducts.php";
            return;
        }

        if ($method === "PUT" && preg_match("#^/api/buy/(\d+)$#", $path, $matches)) {
            $id = $matches[1]; // Ambil ID dari hasil pencocokan regex
            error_log("Id: " . $id);

            // Periksa apakah ID valid
            if (empty($id)) {
                http_response_code(400);
                echo json_encode(["message" => "ID is missing"]);
                exit;
            }

            // Masukkan file untuk proses pembelian
            include __DIR__ . "/../api/buyProduct.php";  // Gunakan path relatif yang benar
            return;
        }

        if ($method === "DELETE" && preg_match("#^/api/delete/(\d+)$#", $path, $matches)) {
            $id = $matches[1];
            error_log(" Id: " . $id);
            if (empty($id)) {
                http_response_code(400);
                echo json_encode(["message" => " ID is missing"]);
                exit;
            }
            include __DIR__ . "/../api/deleteProducts.php";
            return;
        }

        http_response_code(404);
        echo json_encode([
            "status" => "Error",
            "message" => "Route Notfound"
        ]);
    }
}
