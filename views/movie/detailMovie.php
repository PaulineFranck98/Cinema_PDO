<?php

ob_start();
?>

<?php 
while ($movie = $film->fetch()) { 
    ?>
    <h1 class="h1_detail"><?= mb_strtoupper($movie['title']) ?></h1>
    <div class="detail-container">
        <figure>
            <img src="./public/images/<?= $movie['picture'] ?>" alt="picture of film : <?= $movie['title'] ?>">
            <figcaption>
                <a href="index.php?action=casting&id=<?=$movie['id_film']?>">Afficher le casting</a>
            </figcaption>
        </figure>
        <div class="detail-aside">
            <p>Synopsis : <br><br> <?= $movie['synopsis'] ?></p>
            <p class="border"></p>
            <p>Durée du film : <?= $time ?></p>
            <p class="border"></p>
            <?php
                while ($director = $filmDirector->fetch()) {
                    ?>
                    <p>Réalisé par : </p>
                    <figure>
                        <a href="index.php?action=directorDetail&id=<?= $director['id_director'] ?>">
                            <img src="./public/images/<?= $director['picture'] ?>" alt="picture of film : <?= $director['director'] ?>">
                        </a>
                        <figcaption>
                            <a href="index.php?action=directorDetail&id=<?= $director['id_director'] ?>"><strong><?= $director['director'] ?></strong></a>
                        </figcaption>
                    </figure>
                <?php
                 } 
            ?>
        </div>

    </div>
   <?php }
    

$title = "Détails du film";
$content = ob_get_clean();
require "views/template.php";
?>