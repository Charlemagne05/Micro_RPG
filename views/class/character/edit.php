<?php
require_once "../../../../models/_db_connect.php";
require_once "../../../../models/class.php";
require_once "../../../../models/character.php";

$classModel = new RPGClass($pdo);
$charModel = new Character($pdo);

$id = $_GET['id'] ?? null;
if (!$id) {
    header("Location: dashboard.php");
    exit;
}

$character = $charModel->getById($id);
$classes = $classModel->getAll();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $pseudo = $_POST['pseudo'] ?? '';
    $class_id = $_POST['class_id'] ?? '';

    if ($charModel->update($id, $pseudo, $class_id)) {
        header("Location: dashboard.php");
        exit;
    } else {
        $error = "Erreur lors de la modification.";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Modifier un Personnage</title>
</head>
<body>
    <?php include "../../../partials/_navbar.html"; ?>

    <h1>Modifier le Personnage</h1>
    <?php if (isset($error)) echo "<p style='color:red;'>$error</p>"; ?>

    <form method="post">
        <label>Pseudo :</label><br>
        <input type="text" name="pseudo" value="<?= htmlspecialchars($character['pseudo']) ?>" required><br><br>

        <label>Classe :</label><br>
        <select name="class_id" required>
            <?php foreach ($classes as $c): ?>
                <option value="<?= $c['id'] ?>" <?= ($c['id'] == $character['class_id'] ? 'selected' : '') ?>>
                    <?= htmlspecialchars($c['name']) ?>
                </option>
            <?php endforeach; ?>
        </select><br><br>

        <button type="submit">Enregistrer</button>
    </form>
</body>
</html>
