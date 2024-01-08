<?php
// je démarre ma temporisation de sortie 
ob_start();
?>

<!-- va afficher le template, et dans ce template va afficher homePage.php -->
<h2>Ceci est une page d'accueil</h2>

<?php

$title = "Page d'accueil";
$content = ob_get_clean();
require "views/template.php";
?>