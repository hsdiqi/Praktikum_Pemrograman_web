<?php

namespace App\Models;

class Product {
    private $conn;

    public $id;
    public $name;
    public $brand;
    public $description;
    public $price;
    public $category;
    public $stok;
    public $muchBought;
    public $image;

    public function __construct($db) {
        $this->conn = $db;
    }

    // Create product
    public function create($data) {
        $name = $data["name"];
        $brand = $data["brand"];
        $description = $data["description"];
        $price = $data["price"];
        $category = $data["category"];
        $stok = $data["stok"];
        $muchBought = $data["muchBought"];
    
        // Jika gambar diterima dalam format base64, ubah ke binary
        $image = base64_decode($data["image"]);
    
        $query = "INSERT INTO products (name, brand, description, price, category, stok, muchBought, image) 
                  VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        
        $stmt = $this->conn->prepare($query);
    
        if ($stmt === false) {
            die("Prepare failed: " . $this->conn->error);
        }
    
        // Bind semua parameter dalam satu pemanggilan
        $stmt->bind_param("ssssiiib", $name, $brand, $description, $category, $stok, $muchBought, $price, $image);
    
        // Eksekusi query
        if ($stmt->execute()) {
            return true;
        } else {
            die("Execution failed: " . $stmt->error);
        }
    }
    
    public function createName($data) {
        $name = $data["name"];
        $brand = $data["brand"];

        $query = "INSERT INTO products (name, brand) VALUES (?, ?)";

        $stmt = $this->conn->prepare($query);

        if ($stmt === false) {
            die("Prepare failed: " . $this->conn->error);
        }

        $stmt->bind_param("ss", $name, $brand);

        return $stmt->execute();
    }
    

    // Read all products
    public function readAll() {
        $query = "SELECT * FROM products";
        $result = $this->conn->query($query);

        $data = [];
        while ($row = $result->fetch_assoc()) {
            if (isset($row['image'])) {
                // Konversi kolom image ke format Base64 jika kolom image ada
                $row['image'] = base64_encode($row['image']);
            }
            $data[] = $row;
        }

        return $data;
    }

    // Read all products by category brand
    public function readByBrand($brand) {
        $query = "SELECT * FROM products WHERE brand = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("s", $brand); 
        $stmt->execute();
        $result = $stmt->get_result();

        $data = [];
        while ($row = $result->fetch_assoc()) {
            if (isset($row['image'])) {
                // Konversi kolom image ke format Base64 jika kolom image ada
                $row['image'] = base64_encode($row['image']);
            }
            $data[] = $row;
        }
    
        return $data;
    }

    public function readById($id) {
        $query = "SELECT * FROM products WHERE id = ?";
        $stmt = $this->conn->prepare($query);
    
        if (!$stmt) {
            die("Preparation failed: " . $this->conn->error);
        }
    
        $stmt->bind_param("i", $id); // Bind parameter ID sebagai integer
        $stmt->execute();
        $result = $stmt->get_result();
    
        // Jika data ditemukan, fetch sebagai array asosiatif
        if ($result->num_rows > 0) {
            $data = $result->fetch_assoc();
    
            // Konversi gambar ke Base64 jika kolom image ada
            if (isset($data['image'])) {
                $data['image'] = base64_encode($data['image']);
            }
    
            $stmt->close();
            return $data;
        } else {
            // Jika tidak ada data, kembalikan null
            $stmt->close();
            return null;
        }
    }
    

    // Update product
    public function update($id, $data) {
        // Validasi input $data
        if (!is_array($data) || empty($data)) {
            return false;
        }
    
        // Ambil data dari array $data
        $name = $data["name"];
        $brand = $data["brand"];
        $description = $data["description"];
        $price = $data["price"];
        $category = $data["category"];
        $stok = $data["stok"];
        $muchBought = $data["muchBought"];
        $image = base64_decode($data["image"]);
    
        // Query update dengan placeholder ?
        $query = "UPDATE products SET name = ?, brand = ?, description = ?, price = ?, category = ?, stok = ?, muchBought = ?, image = ? WHERE id = ?";
        $stmt = $this->conn->prepare($query);
    
        if (!$stmt) {
            die("Preparation failed: " . $this->conn->error);
        }
    
        // Bind parameter ke query (menggunakan tipe data yang sesuai)
        $stmt->bind_param(
            "sssdsibii", // Tipe data: string, string, string, double, string, integer, integer, blob, integer
            $name,
            $brand,
            $description,
            $price,
            $category,
            $stok,
            $muchBought,
            $image,
            $id
        );
    
        // Eksekusi statement
        $result = $stmt->execute();
    
        // Tutup statement
        $stmt->close();
    
        return $result;
    }
    

    // Buy product
    public function buyProduc($id){
        $query = "UPDATE products SET stok = stok - 1, muchBought = muchBought + 1 WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $id);

        return $stmt->execute();
    }

    // Delete product
    public function delete($id) {
        $query = "DELETE FROM products WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $id);
        $stmt->execute();
    }
}
