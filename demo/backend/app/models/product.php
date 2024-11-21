<?php

namespace App\Models;

class Product
{
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
    public $tahun_rilis;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    // Create product
    public function create($data)
    {
        $query = "INSERT INTO products (name, brand, category, tahun_rilis, price, stok, image, description)
              VALUES (?, ?, ?, ?, ?, ?, ?, ?);";

        $stmt = $this->conn->prepare($query);

        if ($stmt === false) {
            error_log("Prepare failed: " . $this->conn->error);
            http_response_code(500);
            echo json_encode(["message" => "Database prepare failed.", "error" => $this->conn->error]);
            return false;
        }

        // Konversi tipe data
        $price = (float)$data["price"];
        $stok = (int)$data["stok"];
        $tahun_rilis = (int)$data["tahun_rilis"];
        $image = $data["image"]; // base64 string

        $stmt->bind_param(
            "sssissss",
            $data["name"],
            $data["brand"],
            $data["category"],
            $tahun_rilis,
            $price,
            $stok,
            $image,
            $data["description"]
        );

        if ($stmt->execute()) {
            // http_response_code(201);
            // echo json_encode(["message" => "Product created successfully."]);
            return true;
        } else {
            // error_log("Execution failed: " . $stmt->error);
            http_response_code(500);
            echo json_encode(["message" => "Failed to create product.", "error" => $stmt->error]);
            return false;
        }
    }


    public function createName($data)
    {
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
    public function readAll()
    {
        $query = "SELECT id, name, tahun_rilis, muchBought, image FROM products";
        $result = $this->conn->query($query);

        $data = [];
        while ($row = $result->fetch_assoc()) {
            if (isset($row['image']) && !empty($row['image'])) {
                // Konversi kolom image ke format Base64 dengan MIME type
                $row['image'] = "data:image/jpeg;base64," . base64_encode($row['image']);
            }
            // else {
            //     // Jika image kosong, gunakan placeholder
            //     // $row['image'] = "data:image/jpeg;base64," . base64_encode(file_get_contents('path/to/placeholder.jpg'));
            //     echo json_encode(["Message" => "Image not found"]);
            // }
            $data[] = $row;
        }
        return $data;
    }


    // Read all products by category brand
    public function readByBrand($brand)
    {
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

    public function readById($id)
    {
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
    public function update($id, $data)
    {
        // Validasi input $data
        if (!is_array($data) || empty($data)) {
            return false;
        }

        // Ambil data dari array $data
        $name = $data["name"];
        $brand = $data["brand"];
        $description = $data["description"];
        $tahun_rilis = $data["tahun_rilis"];
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
            $tahun_rilis,
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
    public function buyProduc($id)
    {
        $query = "UPDATE products SET stok = stok - 1, muchBought = muchBought + 1 WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $id);

        return $stmt->execute();
    }

    // Delete product
    public function delete($id)
    {
        $query = "DELETE FROM products WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $id);
        $stmt->execute();
    }
}
