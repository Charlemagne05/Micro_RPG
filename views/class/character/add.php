<?php
require_once "../../../../models/_db_connect.php";
require_once "../../../../models/class.php";
require_once "../../../../models/character.php";

$classModel = new RPGClass($pdo);
$charModel = new Character($pdo);

$classes = $classModel->getAll();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $pseudo = $_POST['pseudo'] ?? '';
    $class_id = $_POST['class_id'] ?? '';

    if ($charModel->add($pseudo, $class_id)) {
        header("Location: dashboard.php");
        exit;
    } else {
        $error = "Erreur lors de l’ajout du personnage.";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Ajouter un Personnage</title>
</head>
<body>
    <?php include "../../../partials/_navbar.html"; ?>

    <h1>Ajouter un Personnage</h1>
    <?php if (isset($error)) echo "<p style='color:red;'>$error</p>"; ?>

    <form method="post">
        <label>Pseudo :</label><br>
        <input type="text" name="pseudo" required><br><br>

        <label>Classe :</label><br>
        <select name="class_id" required>
            <option value="">-- Choisir une classe --</option>
            <?php foreach ($classes as $c): ?>
                <option value="<?= $c['id'] ?>"><?= htmlspecialchars($c['name']) ?></option>
            <?php endforeach; ?>
        </select><br><br>

        <button type="submit">Créer</button>
    </form>
</body>
</html>
