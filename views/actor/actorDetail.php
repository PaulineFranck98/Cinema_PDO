<?php

ob_start();
?>

<?php while ($actor = $actorDetail->fetch()) { 
    ?>
    <h1 class="h1_detail"><?= mb_strtoupper($actor['actor']) ?></h1>
    <div class="detail-container">
        <figure>
            <img src="./public/images/<?= $actor['actor_picture'] ?>" alt="picture of actor : <?= $actor['actor'] ?>">
        </figure>
        <div class="detail-aside">
            <p>Date de naissance : <?= $actor['birth_date'] ?></p>
            <p class="border"></p>
            <p>Genre : <?= $actor['person_gender'] ?></p>
            <p>Films :</p>
            <?php while ($film = $actorFilms->fetch()) : ?>
                <figure class="figure_films">
                    <a href="index.php?action=detailMovie&id=<?= $film['id_film'] ?>">
                        <img src="./public/images/<?= $film['picture'] ?>" alt="picture of film : <?= $film['title'] ?>">
                    </a>
                </figure>
            <?php endwhile; ?>
        </div>

    </div>
   <?php }
    ?>
   
<?php

$title = "Détails de l'acteur";
$content = ob_get_clean();
require "views/template.php";
?>