<?php

ob_start();
?>

   <?php while ($movie = $film->fetch()) { 
    ?>
    <div>
    <figure>
            <img src="./public/images/<?= $movie['picture'] ?>" alt="picture of film : <?= $movie['title'] ?>">
        <figcaption>
            <strong><?= $movie['title'] ?></strong>
            <a href="index.php?action=casting&id=<?=$movie['id_film']?>">Casting</a>
        </figcaption>
    </figure>
    <p>Synopsis : <?= $movie['synopsis'] ?></p>
    <p>Durée du film : <?= $time ?></p>


    </div>
   <?php }
    ?>
   
<?php

$title = "Détails du film";
$content = ob_get_clean();
require "views/template.php";
?>