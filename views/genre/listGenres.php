<?php

ob_start();

?>

<div>
    <h1 class="h1-genre">GENRES</h1>

    <?php
    $currentGenre = null;
    while ($genre = $genres->fetch()) {
        if ($currentGenre !== $genre['genre_name']) {
        ?>
</div>
<div style="margin-top:50px;">
        <h2 class="genreh2"><?=$genre['genre_name']?></h2>
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
                    <a href="index.php?action=detailMovie&id='<?=$genre['id_film']?>"><?=$genre['title']?></a>
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