<?php
require_once "../../../../models/_db_connect.php";
require_once "../../../../models/class.php";

$classModel = new RPGClass($pdo);

$id = $_GET['id'] ?? null;
if (!$id) {
    header("Location: dashboard.php");
    exit;
}

$class = $classModel->getById($id);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'] ?? '';
    $description = $_POST['description'] ?? '';

    if ($classModel->update($id, $name, $description)) {
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
    <title>Modifier une Classe</title>
</head>
<body>
    <?php include "../../../partials/_navbar.html"; ?>

    <h1>Modifier la Classe</h1>
    <?php if (isset($error)) echo "<p style='color:red;'>$error</p>"; ?>

    <form method="post">
        <label>Nom :</label><br>
        <input type="text" name="name" value="<?= htmlspecialchars($class['name']) ?>" required><br><br>

        <label>Description :</label><br>
        <textarea name="description"><?= htmlspecialchars($class['description']) ?></textarea><br><br>

        <button type="submit">Enregistrer</button>
    </form>
</body>
</html>
