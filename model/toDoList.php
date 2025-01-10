<?php

namespace Model;

use app\Config\DbConfig;
use mysqli;

class ToDoList extends DbConfig{
    public $connect;

    public function __construct(){
        $this->connect = new mysqli($this->host, $this->user, $this->pass, $this->dbName, $this->port);
        if ($this->connect->connect_error){
            die("Connection failed: " . $this->connect->connect_error);
        }
    }

    public function getAll(){
        $sql = "SELECT * FROM todo_list";
        $result = $this->connect->query($sql);
        $this->connect->close();

        $data = [];
        while($row = $result->fetch_assoc()){
            $data[] = $row;
        }
        return $data;
    }

    public function create($data){
        $todo =  $data['todo'];
        $sql = "INSERT INTO todo_list (todo_list) VALUES (?)";
        $stmt = $this->connect->prepare($sql);
        $stmt->bind_param('s', $todo);
        $stmt->execute();
        $this->connect->close();
    }

    public function update($data, $id){
        $todo = $data['todo'];
        $sql = "UPDATE todo_list SET todo_list = ? WHERE id = ? ";
        $stmt = $this->connect->prepare($sql);
        $stmt->bind_param("si", $todo, $id);
        $stmt->execute();
        $this->connect->close();
    }

    public function delete($id){
        $sql = "DELETE FROM todo_list WHERE id = ?";
        $stmt = $this->connect->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $this->connect->close();
    }
}
