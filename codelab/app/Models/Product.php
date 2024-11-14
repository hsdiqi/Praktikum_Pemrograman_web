<?php

namespace App\Models;

include "app/Config/DatabaseConfig.php";

use app\Config\DatabaseConfig;
use mysqli;

class Product extends DatabaseConfig {
    public $conn;

    public function __construct() {
        // Menggunakan konfigurasi database dari DatabaseConfig
        $this->conn = new mysqli($this->host, $this->username, $this->password, $this->database_name, $this->port);

        // Cek koneksi ke database
        if ($this->conn->connect_error) {
            die("Connection failed: " . $this->conn->connect_error);
        }
    }

    // Ambil semua data produk
    public function findAll() {
        $sql = "SELECT * FROM products";
        $result = $this->conn->query($sql);
        
        // Menyimpan data hasil query
        $data = [];
        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }

        return $data;
    }

    // Ambil data produk berdasarkan ID
    public function findById($id) {
        $sql = "SELECT * FROM products WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $id); // Bind param dengan benar, tipe "i" untuk integer
        $stmt->execute();
        $result = $stmt->get_result();
        $data = $result->fetch_assoc(); // Ambil hasilnya sebagai associative array
        $stmt->close(); // Pastikan menutup statement setelah selesai
    
        return $data; // Kembalikan data atau null jika tidak ditemukan
    }
    
    // Menambahkan produk baru
    public function create($data) {
        // Menggunakan 'product_name' yang sesuai dengan nama kolom di database
        $productName = $data['product_name']; // Perbaiki nama kolom
        $query = "INSERT INTO products (product_name) VALUES (?)"; // Gunakan 'product_name'
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("s", $productName);
        $stmt->execute();
    }

    // Memperbarui data produk berdasarkan ID
    public function update($id, $data) {
        // Pastikan $data adalah array yang berisi nilai untuk diupdate
        if (!is_array($data) || empty($data)) {
            return false;
        }
    
        // Ambil nilai product_name dari array $data
        $productName = $data['product_name']; // Menggunakan nama kolom yang benar
    
        // Query untuk memperbarui produk
        $query = "UPDATE products SET product_name = ? WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("si", $productName, $id);
        $stmt->execute();
    
        // Cek apakah baris diperbarui
        if ($stmt->affected_rows > 0) {
            return true;
        }
    
        return false; // Jika tidak ada baris yang diperbarui
    }
    

    // Menghapus produk berdasarkan ID
    public function delete($id) {
        $query = "DELETE FROM products WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $id);
        $stmt->execute();
    }

    // Menutup koneksi setelah semua operasi selesai
    public function __destruct() {
        if ($this->conn) {
            $this->conn->close();
        }
    }
}