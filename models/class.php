<?php
class RPGClass {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function getAll() {
        $stmt = $this->pdo->query("SELECT * FROM classes ORDER BY id ASC");
        return $stmt->fetchAll();
    }

   
    public function add($name, $description) {
        $stmt = $this->pdo->prepare("INSERT INTO classes (name, description) VALUES (?, ?)");
        return $stmt->execute([$name, $description]);
    }

   
    public function update($id, $name, $description) {
        $stmt = $this->pdo->prepare("UPDATE classes SET name = ?, description = ? WHERE id = ?");
        return $stmt->execute([$name, $description, $id]);
    }

   

}