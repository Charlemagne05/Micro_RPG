<?php
class RPGClass {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    // Lister toutes les classes
    public function getAll() {
        $stmt = $this->pdo->query("SELECT * FROM classes ORDER BY id ASC");
        return $stmt->fetchAll();
    }

    // Ajouter une classe
    public function add($name, $description) {
        $stmt = $this->pdo->prepare("INSERT INTO classes (name, description) VALUES (?, ?)");
        return $stmt->execute([$name, $description]);
    }

    // Modifier une classe
    public function update($id, $name, $description) {
        $stmt = $this->pdo->prepare("UPDATE classes SET name = ?, description = ? WHERE id = ?");
        return $stmt->execute([$name, $description, $id]);
    }

    // Supprimer une classe
    public function delete($id) {
        $stmt = $this->pdo->prepare("DELETE FROM classes WHERE id = ?");
        return $stmt->execute([$id]);
    }

    // Obtenir une classe par id
    public function getById($id) {
        $stmt = $this->pdo->prepare("SELECT * FROM classes WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }
}