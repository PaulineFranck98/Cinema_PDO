<?php

ob_start();
?>
<div>
    <?php

    while ($movie = $movieDetail->fetch()) { 
        ?>
        <div class="banner">

        <div class=" background">
                <img src="./public/images/<?= $movie['banner'] ?>" alt="background image">
        </div>

        <div class="content active">

                <img src="./public/images/<?= $movie['title_picture'] ?>" alt="interstellar title png" class="movie-title">
            
                <h4>
                    <span><?=$movie['date']?></span><span><i><?= $movie['age_min'] ?>+</i></span>
                    <span><?= $time ?></span><span>Action</span>
                </h4>

                <p>
                    <?= $movie['synopsis'] ?>
                </p>

                <div class="button">
                    <a href="#"><i class="fa-solid fa-play"></i>  Voir</a>
                    <!-- <a href="#"><i class="fa-solid fa-plus"></i>  Ma Liste</a> -->
                    <a href="index.php?action=casting&id=<?=$movie['id_film']?>">Casting</a>
                </div>
            </div>
            <div style="display:flex;"> 
                <div class="carousel-box">
                    <div class="carousel">
                        <?php
                        while ($film = $films->fetch()) {
                        ?>

                            <div class="carousel-item">
                                <a href="index.php?action=listFilms&id=<?= $film['id_film'] ?>">
                                    <img src="./public/images/<?= $film['picture'] ?>" alt="picture of film : <?= $film['title'] ?>">
                                </a>
                            </div>
                        <?php }?>
                    </div>
                </div>
            </div>

            <a href="#" class="play" onClick="toggleVideo();"><i class="fa-regular fa-circle-play"></i>Voir la Bande Annonce</a>

            <ul class="sci">
                <li><a href="index.php?action=updateMovieForm&id=<?= $movie['id_film'] ?>">Modifier</a></li>
                <li><a href="#"><i class="fa-brands fa-facebook"></i></a></li>
                <li><a href="#"><i class="fa-brands fa-youtube"></i></a></li>
                <li><a href="#"><i class="fa-brands fa-x-twitter"></i></a></li>
                <li><form action="index.php?action=deleteMovie&id=<?=$movie['id_film']?>" method="post"> 
                    <input type="hidden" name="id_film" value="<?= $movie['id_film'] ?>">
                    <input  type="submit" name="submit" value="Supprimer">
                </form></li>
            </ul>
        </div>
        <div class="trailer">
            <video src="./public/videos/interstellar_vid.mp4"
            muted
            controls="true"
            autoplay="true"
            ></video>
            <img src="./public/images/close_cross.png" alt="" class="close"
            onClick="toggleVideo();">

        </div>
    
        <?php } ?>
    </div>
 <?php
$title = "Détails du film";
$content = ob_get_clean();
require "views/template.php";
?>