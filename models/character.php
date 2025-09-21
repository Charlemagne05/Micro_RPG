<?php
class Character {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    // Lister tous les personnages, avec la classe jointe
    public function getAll($filter = []) {
        $sql = "SELECT ch.*, cl.name AS class_name 
                FROM characters ch 
                JOIN classes cl ON ch.class_id = cl.id";
        $params = [];

        // Filtrage optionnel par pseudo ou class_id
        if (!empty($filter)) {
            $conditions = [];
            if (!empty($filter['pseudo'])) {
                $conditions[] = "ch.pseudo LIKE ?";
                $params[] = "%".$filter['pseudo']."%";
            }
            if (!empty($filter['class_id'])) {
                $conditions[] = "ch.class_id = ?";
                $params[] = $filter['class_id'];
            }
            if ($conditions) {
                $sql .= " WHERE " . implode(" AND ", $conditions);
            }
        }

        $sql .= " ORDER BY ch.id ASC";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll();
    }

    // Ajouter un personnage avec stats aléatoires
    public function add($pseudo, $class_id) {
        $pv = rand(50, 100);
        $atk = rand(1, 10);
        $xp = 0;
        $stmt = $this->pdo->prepare("INSERT INTO characters (pseudo, class_id, pv, atk, xp, connected) VALUES (?, ?, ?, ?, ?, 0)");
        return $stmt->execute([$pseudo, $class_id, $pv, $atk, $xp]);
    }

    // Modifier un personnage
    public function update($id, $pseudo, $class_id, $pv, $atk, $xp, $connected) {
        $stmt = $this->pdo->prepare("UPDATE characters SET pseudo = ?, class_id = ?, pv = ?, atk = ?, xp = ?, connected = ? WHERE id = ?");
        return $stmt->execute([$pseudo, $class_id, $pv, $atk, $xp, $connected, $id]);
    }

    // Supprimer un personnage
    public function delete($id) {
        $stmt = $this->pdo->prepare("DELETE FROM characters WHERE id = ?");
        return $stmt->execute([$id]);
    }

    // Obtenir un personnage par id
    public function getById($id) {
        $stmt = $this->pdo->prepare("SELECT ch.*, cl.name AS class_name 
                                     FROM characters ch 
                                     JOIN classes cl ON ch.class_id = cl.id 
                                     WHERE ch.id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }
}