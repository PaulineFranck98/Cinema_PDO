<?php

ob_start();
?>

<?php while ($director = $directorDetail->fetch()) { 
    ?>
    <h1 class="h1_detail"><?= mb_strtoupper($director['director']) ?></h1>
    <div class="detail-container">
        <figure>
            <img src="./public/images/<?= $director['picture'] ?>" alt="picture of actor : <?= $director['director'] ?>">
        </figure>
        <div class="detail-aside">
            <p>Date de naissance : <?= $director['birth_date'] ?></p>
            <p class="border"></p>
            <p>Genre : <?= $director['person_gender'] ?></p>
            <p>Films :</p>
            <div class="films-director">
                <?php while ($film = $directorFilms->fetch()) : ?>
                    <figure class="figure_films">
                        <a href="index.php?action=detailMovie&id=<?= $film['id_film'] ?>">
                            <img src="./public/images/<?= $film['picture'] ?>" alt="picture of film : <?= $film['title'] ?>">
                        </a>
                    </figure>
                <?php endwhile; ?>
                </div>
        </div>

    </div>
   <?php }
    ?>
   
<?php

$title = "Détails du film";
$content = ob_get_clean();
require "views/template.php";
?>