<?php
// je démarre ma temporisation de sortie 
ob_start();
?>

<h1>DERNIERS FILMS</h1>
<div class="films-grid">
    <?php
    while ($film = $lastmovies->fetch()) {
    ?>
        <figure class="figure_films">
            <a href="index.php?action=detailMovie&id=<?= $film['id_film'] ?>">
                <img src="./public/images/<?= $film['picture'] ?>" alt="picture of film : <?= $film['title'] ?>">
            </a>
            <figcaption>
                <a href="index.php?action=detailMovie&id=<?= $film['id_film'] ?>"><strong><?= $film['title'] ?></strong></a>
            </figcaption>
        </figure>
    <?php
    }
    ?>
</div>
<?php

$title = "Page d'accueil";
$content = ob_get_clean();
require "views/template.php";
?>