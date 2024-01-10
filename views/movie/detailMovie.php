<?php

ob_start();
?>

<?php while ($movie = $film->fetch()) { 
    ?>
    <h1 class="h1_detail"><?= mb_strtoupper($movie['title']) ?></h1>
    <div class="detail-container">
        <figure>
            <img src="./public/images/<?= $movie['picture'] ?>" alt="picture of film : <?= $movie['title'] ?>">
            <figcaption>
                <a href="index.php?action=casting&id=<?=$movie['id_film']?>">Casting</a>
            </figcaption>
        
        </figure>
        <div class="detail-aside">
            <p>Synopsis : <br><br> <?= $movie['synopsis'] ?></p>
            <p class="border"></p>
            <p>Durée du film : <?= $time ?></p>

        </div>
    </div>
   <?php }
    ?>
   
<?php

$title = "Détails du film";
$content = ob_get_clean();
require "views/template.php";
?>