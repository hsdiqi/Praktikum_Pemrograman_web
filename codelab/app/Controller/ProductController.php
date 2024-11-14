<?php

namespace app\Controller;

include "app/Traits/ApiResponseFormatter.php";
include "app/Models/Product.php";

use app\Models\Product;
use app\Traits\ApiResponseFormatter;

class ProductController
{

    use ApiResponseFormatter;

    public function index()
    {
        $productModel = new Product();
        $response = $productModel->findAll();
        return $this->apiResponse(200, "Success", $response);
    }

    public function getById($id)
    {
        
        $productModel = new Product();
        $response = $productModel->findById($id);
        if (!$response) {
            return $this->apiResponse(404, "Product not found", null);
        }
        return $this->apiResponse(200, "Success", $response);
    }

    public function insert()
    {
        $jsonInput = file_get_contents('php://input');
        $inputData = json_decode($jsonInput, true);

        if (json_last_error()) {
            $error = json_last_error_msg();
            return $this->apiResponse(400, "Error invalid input: $error", null);
        }

        if (!isset($inputData['product_name']) || empty($inputData['product_name'])) {
            return $this->apiResponse(400, "Error: product_name is required", null);
        }

        $productModel = new Product();
        $response = $productModel->create([
            'product_name' => $inputData['product_name']
        ]);
        return $this->apiResponse(200, "Success", $response);
    }

    public function update($id)
    {
        $jsonInput = file_get_contents('php://input');
        $inputData = json_decode($jsonInput, true);

        // Validate the input data
        if (json_last_error()) {
            $error = json_last_error_msg();
            return $this->apiResponse(400, "Invalid JSON format: $error", null);
        }

        if (!isset($inputData['product_name']) || empty($inputData['product_name'])) {
            return $this->apiResponse(400, "product_name is required", null);
        }

        // Call the update method from Product model
        $productModel = new Product();
        $result = $productModel->update($id, $inputData);

        if ($result) {
            return $this->apiResponse(200, "Product updated successfully", null);
        } else {
            return $this->apiResponse(404, "Product not found", null);
        }
    }

    public function delete($id) {
        $productModel = new Product();
        // Panggil metode delete dan periksa hasilnya
        $result = $productModel->delete($id);
        // Jika produk berhasil dihapus
        return $this->apiResponse(200, "Product deleted successfully", null);
    }
    
}