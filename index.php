<?php
// Définir la racine du projet
define('ROOT', __DIR__);

// Inclusion automatique des modèles si ils existent
if (file_exists(ROOT . '/models/class.php')) {
    require_once ROOT . '/models/class.php';
}
if (file_exists(ROOT . '/models/character.php')) {
    require_once ROOT . '/models/character.php';
}
if (file_exists(ROOT . '/models/_db_connect.php')) {
    require_once ROOT . '/models/_db_connect.php';
}

// Déterminer la page à afficher (home par défaut)
$page = 'home';
$folder = 'admin'; // par défaut on charge les pages admin

// Si un paramètre GET est fourni, on peut choisir la page et le dossier
if (isset($_GET['page']) && !empty($_GET['page'])) {
    $page = basename($_GET['page']); // sécurité
}

if (isset($_GET['folder']) && !empty($_GET['folder'])) {
    $folder = basename($_GET['folder']); // sécurité
}

// Construire le chemin complet
$pagePath = ROOT . "/views/{$folder}/{$page}.php";

// Vérifier si le fichier existe
if (file_exists($pagePath)) {
    include $pagePath;
} else {
    echo "<h1>Erreur 404</h1>";
    echo "<p>La page '{$page}.php' est introuvable dans le dossier '{$folder}'.</p>";
    echo "<p><a href='index.php'>Retour à l'accueil</a></p>";
}