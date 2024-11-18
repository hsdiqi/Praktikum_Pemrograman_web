<?php

namespace App\Config;

class DbConfig {
    private $host = "localhost";
    private $db_name = "prak_web";
    private $username = "root";
    private $password = "";

    public $conn;

    public function getConnection() {
        $this->conn = null;
        try {
            // Menggunakan MySQLi untuk membuat koneksi
            $this->conn = new \mysqli($this->host, $this->username, $this->password, $this->db_name);

            // Cek apakah koneksi berhasil
            if ($this->conn->connect_error) {
                throw new \Exception("Connection failed: " . $this->conn->connect_error);
            }
        } catch (\Exception $exception) {
            echo "Connection error: " . $exception->getMessage();  // Menampilkan pesan error
            die();  // Menghentikan eksekusi skrip jika gagal terkoneksi
        }
        return $this->conn;
    }
}
