<?php

define('ROOT', __DIR__);

if (file_exists(ROOT . '/models/class.php')) {
    require_once ROOT . '/models/class.php';
}
if (file_exists(ROOT . '/models/character.php')) {
    require_once ROOT . '/models/character.php';
}
if (file_exists(ROOT . '/models/_db_connect.php')) {
    require_once ROOT . '/models/_db_connect.php';
}


$page = 'home';
$folder = 'admin'; 


if (isset($_GET['page']) && !empty($_GET['page'])) {
    $page = basename($_GET['page']); 
}

if (isset($_GET['folder']) && !empty($_GET['folder'])) {
    $folder = basename($_GET['folder']); 
}


$pagePath = ROOT . "/views/{$folder}/{$page}.php";


if (file_exists($pagePath)) {
    include $pagePath;
} else {
    echo "<h1>Erreur 404</h1>";
    echo "<p>La page '{$page}.php' est introuvable dans le dossier '{$folder}'.</p>";
    echo "<p><a href='index.php'>Retour à l'accueil</a></p>";
}