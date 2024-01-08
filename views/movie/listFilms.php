<?php
// je démarre ma temporisation de sortie 
ob_start();
?>

<!-- va afficher le template, et dans ce template va afficher homePage.php -->

<!-- 
    pour afficher les films je dois fetchAll 
    fetch() est une fonction native de php
    tant que je peux fetch / tant que je peux récupérer un résultat -->
    
    <div>
<!-- rowCount() fonction native qui calcule le nombre d'enregistrements que récupère une requête -->
<h1>Liste des films : <span><?= $films->rowCount() ?></span></h1>
    <?php
    while ($film = $films->fetch()) { ?>
    <div>
        <p><strong><?=$film['title']?></strong></p>
        <a href="index.php?action=detailFilm&id=<?$film['id_film']?>">Détail Film</a>
    </div>
    <?php }
    ?>
</div>

<?php

$title = "liste des films";
$content = ob_get_clean();
require "views/template.php";
?>