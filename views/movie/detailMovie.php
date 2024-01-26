<?php

ob_start();
?>
<div>
    <?php

    while ($movie = $film->fetch()) { 
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
                        while ($films = $lastmovies->fetch()) {
                        ?>

                            <div class="carousel-item">
                                <a href="index.php?action=detailMovie&id=<?= $films['id_film'] ?>">
                                    <img src="./public/images/<?= $films['picture'] ?>" alt="picture of film : <?= $films['title'] ?>">
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