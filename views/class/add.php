<?php
require_once "../../../../models/_db_connect.php";
require_once "../../../../models/class.php";

$classModel = new RPGClass($pdo);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'] ?? '';
    $description = $_POST['description'] ?? '';

    if ($classModel->add($name, $description)) {
        header("Location: dashboard.php");
        exit;
    } else {
        $error = "Erreur lors de l’ajout de la classe.";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Ajouter une Classe</title>
</head>
<body>
    <?php include "../../../partials/_navbar.html"; ?>

    <h1>Ajouter une Classe</h1>
    <?php if (isset($error)) echo "<p style='color:red;'>$error</p>"; ?>

    <form method="post">
        <label>Nom :</label><br>
        <input type="text" name="name" required><br><br>

        <label>Description :</label><br>
        <textarea name="description"></textarea><br><br>

        <button type="submit">Ajouter</button>
    </form>
</body>
</html>
