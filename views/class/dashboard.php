<?php
require_once "../../../../models/_db_connect.php";
require_once "../../../../models/class.php";

$classModel = new RPGClass($pdo);
$classes = $classModel->getAll();
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Gestion des Classes</title>
</head>
<body>
    <?php include "../../../partials/_navbar.html"; ?>

    <h1>Liste des Classes</h1>
    <a href="add.php">➕ Ajouter une classe</a>
    <ul>
        <?php foreach ($classes as $c): ?>
            <li>
                <?= htmlspecialchars($c['name']) ?> - <?= htmlspecialchars($c['description']) ?>
                <a href="edit.php?id=<?= $c['id'] ?>">✏️ Modifier</a>
                <a href="delete.php?id=<?= $c['id'] ?>">🗑 Supprimer</a>
            </li>
        <?php endforeach; ?>
    </ul>
</body>
</html>
