<?php

ob_start();
?>

<?php 
while ($movie = $film->fetch()) { 
    ?>
    <h1 class="h1_detail"><?= mb_strtoupper($movie['title']) ?></h1>
    <a style='display:none;'href="index.php?action=updateMovieForm&id=<?= $movie['id_film'] ?>">Modifier</a>

    <form style='display:none;'action="index.php?action=deleteMovie" method="post">
        <input type="hidden" name="id_film" value="<?= $movie['id_film'] ?>">
        <input type="submit" name="submit" value="Delete Movie">

    </form>
    <div class="detail-container">
        <figure class="detail-containerfigure">
            <img class="detail-containerimg" src="./public/images/<?= $movie['picture'] ?>" alt="picture of film : <?= $movie['title'] ?>">
            <figcaption>
                <a href="index.php?action=casting&id=<?=$movie['id_film']?>">Afficher le casting</a>
                
            </figcaption>
        </figure>
        <div class="detail-aside">
            <div>
                <p><?= $movie['synopsis'] ?></p>
                <br>
                <p class="border"></p>
                <br>
                <p>Durée du film : <?= $time ?></p>
                <br>
                <p class="border"></p>
                <br>
                <p>Date de sortie : <?=$movie['date']?></p>
                <br><br>
                <p>Réalisé par : </p>
            </div>
            <div class='aside-bottom'>
                <div class="aside-director">
                <?php
                    while ($director = $filmDirector->fetch()) {
                        ?>
                            <figure>
                                <a href="index.php?action=directorDetail&id=<?= $director['id_director'] ?>">
                                    <img src="./public/images/<?= $director['picture'] ?>" alt="picture of director : <?= $director['director'] ?>">
                                </a>
                                <figcaption>
                                    <a href="index.php?action=directorDetail&id=<?= $director['id_director'] ?>"><strong><?= $director['director'] ?></strong></a>
                                </figcaption>
                            </figure>
                            
                            <?php
                    } ?>
                    </div>
                    <div class="aside-actors">
                        <?php 
                        while ($actor = $mainActors->fetch()) {
                            ?>
                            <!-- <p>Acteurs principaux :</p> -->
        
                            <figure>
                                <a href="index.php?action=actorDetail&id=<?= $actor['id_actor'] ?>">
                                    <img src="./public/images/<?= $actor['picture'] ?>" alt="picture of actor : <?= $actor['actor'] ?>">
                                </a>
                                <figcaption>
                                    <a href="index.php?action=actorDetail&id=<?= $actor['id_actor'] ?>"><strong><?= $actor['actor'] ?></strong></a>
                                </figcaption>
                                </figure>
                            
                        <?php } ?>
                   </div>
            </div>
        </div>

    </div>
   <?php }
    

$title = "Détails du film";
$content = ob_get_clean();
require "views/template.php";
?>