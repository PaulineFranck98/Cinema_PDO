<?php

ob_start();

?>

<div>
    <h1 class="h1-genre">GENRES</h1>
    <a href="index.php?action=addGenreForm">Ajouter un Genre</a>
    <?php
    $currentGenre = null;
    while ($genre = $genres->fetch()) {
        if ($currentGenre !== $genre['genre_name']) {
            // var_dump($genre);
        ?>
</div>
<div style="margin-top:50px;">
<h2 class="genreh2">
    <a href="index.php?action=detailGenre&id=<?=$genre['id_genre']?>"><?= mb_strtoupper($genre['genre_name'])?></a>
</h2>
        <div class="films-grid1">
            <?php
                $currentGenre = $genre['genre_name'];
            }
                
            ?>
            <figure class="figure_films1">
                <a href="index.php?action=detailMovie&id=<?=$genre['id_film']?>">
                    <img src="./public/images/<?=$genre['picture']?>" alt="picture of film :<?=$genre['title']?>">
                </a>
                <figcaption>
                    <a href="index.php?action=detailMovie&id=<?=$genre['id_film']?>"><?=$genre['title']?></a>
                </figcaption>
            </figure>
            
    <?php
       
        
    }
    ?>
        </div>
</div>


<?php
$title = "Liste des genres";
$content = ob_get_clean();
require "views/template.php";

?>