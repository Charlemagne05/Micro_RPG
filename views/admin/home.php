<?php
require_once __DIR__ . '/../../models/_db_connect.php';
require_once __DIR__ . '/../../models/class.php';
require_once __DIR__ . '/../../models/character.php';


$classModel = new RPGClass($pdo);
$charModel = new Character($pdo);


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';

    
    if ($action === 'add_class') {
        $classModel->add($_POST['class_name'], $_POST['class_description']);
    }
    if ($action === 'edit_class') {
        $classModel->update($_POST['class_id'], $_POST['class_name'], $_POST['class_description']);
    }
    if ($action === 'delete_class') {
        $classModel->delete($_POST['class_id']);
    }

   
    if ($action === 'add_character') {
        $pseudo = $_POST['char_pseudo'];
        $class_id = $_POST['char_class_id'];
        $pv = rand(50, 100);
        $atk = rand(1, 10);
        $xp = 0;
        $charModel->addCustom($pseudo, $class_id, $pv, $atk, $xp);
    }
    if ($action === 'edit_character') {
        $charModel->update(
            $_POST['char_id'],
            $_POST['char_pseudo'],
            $_POST['char_class_id'],
            $_POST['char_pv'],
            $_POST['char_atk'],
            $_POST['char_xp'],
            isset($_POST['char_connected']) ? 1 : 0
        );
    }
    if ($action === 'delete_character') {
        $charModel->delete($_POST['char_id']);
    }

    header('Location: '.$_SERVER['PHP_SELF']);
    exit;
}

$filter = [];
if (!empty($_GET['pseudo'])) $filter['pseudo'] = $_GET['pseudo'];
if (!empty($_GET['class_id'])) $filter['class_id'] = $_GET['class_id'];

$allClasses = $classModel->getAll();
$characters = $charModel->getAll($filter);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<title>Gestion RPG - Home</title>
<link rel="stylesheet" href="../../assets/css/style.css">
<style>
</style>
</head>
<body>
<h1>Gestion RPG</h1>

<form method="get" style="text-align:center; margin-bottom:20px;">
<input type="text" name="pseudo" placeholder="Rechercher par pseudo" value="<?= htmlspecialchars($_GET['pseudo'] ?? '') ?>">
<select name="class_id">
<option value="">Toutes les classes</option>
<?php foreach($allClasses as $c): ?>
<option value="<?= $c['id'] ?>" <?= (isset($_GET['class_id']) && $_GET['class_id']==$c['id'])?'selected':'' ?>><?= htmlspecialchars($c['name']) ?></option>
<?php endforeach; ?>
</select>
<button type="submit">Filtrer</button>
</form>

<h2>Classes</h2>
<div class="classes">
<?php foreach($allClasses as $c): ?>
<div class="card">
<strong><?= htmlspecialchars($c['name']) ?></strong>
<p><?= htmlspecialchars($c['description']) ?></p>


<form method="post">
<input type="hidden" name="action" value="edit_class">
<input type="hidden" name="class_id" value="<?= $c['id'] ?>">
<label>Nom: <input type="text" name="class_name" value="<?= htmlspecialchars($c['name']) ?>"></label>
<label>Description: <textarea name="class_description"><?= htmlspecialchars($c['description']) ?></textarea></label>
<button type="submit">Modifier</button>
</form>


<form method="post" onsubmit="return confirm('Supprimer cette classe et tous ses personnages ?')">
<input type="hidden" name="action" value="delete_class">
<input type="hidden" name="class_id" value="<?= $c['id'] ?>">
<button type="submit" class="close-button">&times;</button>
</form>
</div>
<?php endforeach; ?>


<div class="card">
<form method="post">
<input type="hidden" name="action" value="add_class">
<label>Nom: <input type="text" name="class_name" required></label>
<label>Description: <textarea name="class_description"></textarea></label>
<button type="submit">Ajouter</button>
</form>
</div>
</div>

<h2>Personnages</h2>
<div class="characters">
<?php foreach($characters as $ch): ?>
<div class="card">
<strong><?= htmlspecialchars($ch['pseudo']) ?> (<?= htmlspecialchars($ch['class_name']) ?>)</strong>
<p>PV: <?= $ch['pv'] ?></p>
<p>ATK: <?= $ch['atk'] ?></p>
<p>XP: <?= $ch['xp'] ?></p>
<p>Status: <?= $ch['connected'] ? 'En ligne' : 'Hors ligne' ?></p>


<form method="post">
<input type="hidden" name="action" value="edit_character">
<input type="hidden" name="char_id" value="<?= $ch['id'] ?>">
<label>Pseudo: <input type="text" name="char_pseudo" value="<?= htmlspecialchars($ch['pseudo']) ?>"></label>
<label>Classe:
<select name="char_class_id">
<?php foreach($allClasses as $c): ?>
<option value="<?= $c['id'] ?>" <?= ($ch['class_id']==$c['id'])?'selected':'' ?>><?= htmlspecialchars($c['name']) ?></option>
<?php endforeach; ?>
</select>
</label>
<label>PV: <input type="number" name="char_pv" value="<?= $ch['pv'] ?>"></label>
<label>ATK: <input type="number" name="char_atk" value="<?= $ch['atk'] ?>"></label>
<label>XP: <input type="number" name="char_xp" value="<?= $ch['xp'] ?>"></label>
<label><input type="checkbox" name="char_connected" <?= $ch['connected']?'checked':'' ?>> En ligne</label>
<button type="submit">Modifier</button>
</form>


<form method="post" onsubmit="return confirm('Supprimer ce personnage ?')">
<input type="hidden" name="action" value="delete_character">
<input type="hidden" name="char_id" value="<?= $ch['id'] ?>">
<button type="submit" class="close-button">&times;</button>
</form>
</div>
<?php endforeach; ?>

<div class="card">
<form method="post">
<input type="hidden" name="action" value="add_character">
<label>Pseudo: <input type="text" name="char_pseudo" required></label>
<label>Classe:
<select name="char_class_id" required>
<option value="">-- Choisir une classe --</option>
<?php foreach($allClasses as $c): ?>
<option value="<?= $c['id'] ?>"><?= htmlspecialchars($c['name']) ?></option>
<?php endforeach; ?>
</select>
</label>
<button type="submit">Ajouter</button>
</form>
</div>
</div>
</body>
</html>