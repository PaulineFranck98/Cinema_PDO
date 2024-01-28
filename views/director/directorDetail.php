<?php

ob_start();
?>
<div >
<?php while ($director = $directorDetail->fetch()) { 
    ?>
    <h1 class="h1_detail"><?= mb_strtoupper($director['director']) ?></h1>

    <div class="detail-container">
        <figure>
            <img src="./public/images/<?= $director['picture'] ?>" alt="picture of director : <?= $director['director'] ?>"  class="director-img">
        </figure>
        <div class="detail-aside">
            <p>Date de naissance : <?= $director['birth_date'] ?></p>
            <p class="border"></p>
            <p>Genre : <?= $director['person_gender'] ?></p>
            <p class="border"></p>
            <p>Films réalisés :</p>
            <div class="aside-films">
                <?php while ($film = $directorFilms->fetch()) : ?>
                    <figure class="figure_films">
                            <img src="./public/images/<?= $film['picture'] ?>" alt="picture of film : <?= $film['title'] ?>">
                    </figure>
                <?php endwhile; ?>
            </div>
        </div>
    </div>
    <div class="deleteUpdateButton">
    <a href="index.php?action=updateDirectorForm&id=<?= $director['id_director'] ?>">Modifier</a>

<form action="index.php?action=deleteDirector" method="post">
    <input type="hidden" name="id_director" value="<?= $director['id_director'] ?>">
    <input type="submit" name="submit" value="Supprimer" class="delete-button">
</form>
    </div>
   <?php }
    ?>
</div>
<?php
$currentPage = 'personDetail';
$title = "Détails réalisateur";
$content = ob_get_clean();
require "views/template.php";
?>