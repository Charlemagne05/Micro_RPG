<?php
require_once "../../models/_db_connect.php";
require_once "../../models/class.php";
require_once "../../models/character.php";

$classModel = new RPGClass($pdo);
$charModel = new Character($pdo);

$classes = $classModel->getAll();

$pseudo = $_GET['pseudo'] ?? '';
$class_id = $_GET['class_id'] ?? '';

$results = $charModel->search($pseudo, $class_id);
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Recherche Personnages</title>
</head>
<body>
    <?php include "../partials/_navbar.html"; ?>

    <h1>Recherche de Personnages</h1>
    <form method="get">
        <input type="text" name="pseudo" placeholder="Pseudo" value="<?= htmlspecialchars($pseudo) ?>">
        <select name="class_id">
            <option value="">-- Classe --</option>
            <?php foreach ($classes as $c): ?>
                <option value="<?= $c['id'] ?>" <?= ($c['id'] == $class_id ? 'selected' : '') ?>>
                    <?= htmlspecialchars($c['name']) ?>
                </option>
            <?php endforeach; ?>
        </select>
        <button type="submit">🔍 Rechercher</button>
    </form>

    <h2>Résultats</h2>
    <ul>
        <?php foreach ($results as $r): ?>
            <li><?= htmlspecialchars($r['pseudo']) ?> (<?= $r['class_name'] ?>)</li>
        <?php endforeach; ?>
    </ul>
</body>
</html>
