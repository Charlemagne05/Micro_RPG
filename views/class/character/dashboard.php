<?php
require_once "../../../../models/_db_connect.php";
require_once "../../../../models/character.php";

$charModel = new Character($pdo);
$characters = $charModel->getAll();
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Gestion des Personnages</title>
</head>
<body>
    <?php include "../../../partials/_navbar.html"; ?>

    <h1>Liste des Personnages</h1>
    <a href="add.php">➕ Ajouter un personnage</a>
    <ul>
        <?php foreach ($characters as $ch): ?>
            <li>
                <?= htmlspecialchars($ch['pseudo']) ?> (<?= $ch['class_name'] ?>) 
                PV: <?= $ch['pv'] ?> | ATK: <?= $ch['atk'] ?> | XP: <?= $ch['xp'] ?>
                <a href="edit.php?id=<?= $ch['id'] ?>">✏️ Modifier</a>
                <a href="delete.php?id=<?= $ch['id'] ?>">🗑 Supprimer</a>
            </li>
        <?php endforeach; ?>
    </ul>
</body>
</html>
