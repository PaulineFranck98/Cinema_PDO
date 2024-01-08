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
    while ($film = $films->fetch()) { 
    
    ?>
       <div>
            <figure>
                <a href="index.php?action=detailMovie&id=<?=$film['id_film']?>">
                    <img src="./public/images/<?= $film['picture'] ?>" alt="picture of film : <?= $film['title'] ?>">
                </a>
                <figcaption>
                    <a href="#"><strong><?= $film['title'] ?></strong></a>
                </figcaption>
            </figure>

        </div>

    <?php }
    ?>
</div>

<?php

$title = "Liste des films";
$content = ob_get_clean();
require "views/template.php";
?>