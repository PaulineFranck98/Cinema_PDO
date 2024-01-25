<?php

ob_start();
?>
<div >
<?php while ($actor = $actorDetail->fetch()) { 
    ?>
    <h1 class="h1_detail"><?= mb_strtoupper($actor['actor']) ?></h1>

   


    <div class="detail-container">
        <figure>
            <img src="./public/images/<?= $actor['actor_picture'] ?>" alt="picture of actor : <?= $actor['actor'] ?>"  class="actor-img">
        </figure>
        <div class="detail-aside">
            <p>Date de naissance : <?= $actor['birth_date'] ?></p>
            <p class="border"></p>
            <p>Genre : <?= $actor['person_gender'] ?></p>
            <p class="border"></p>
            <p>Films notables :</p>
            <div class="aside-films">
                <?php while ($film = $actorFilms->fetch()) : ?>
                    <figure class="figure_films">
                        <a href="index.php?action=detailMovie&id=<?= $film['id_film'] ?>" >
                            <img src="./public/images/<?= $film['picture'] ?>" alt="picture of film : <?= $film['title'] ?>">
                        </a>
                    </figure>
                <?php endwhile; ?>
            </div>
        </div>
    </div>
    <div class="deleteUpdateButton">
    <a href="index.php?action=updateActorForm&id=<?= $actor['id_actor'] ?>">Modifier</a>

<form action="index.php?action=deleteActor" method="post">
    <input type="hidden" name="id_actor" value="<?= $actor['id_actor'] ?>">
    <input type="submit" name="submit" value="Supprimer" class="delete-button">
</form>
    </div>
   <?php }
    ?>
</div>
<?php

$title = "Détails de l'acteur";
$content = ob_get_clean();
$currentPage = 'personDetail'; 
require "views/template.php";
?>