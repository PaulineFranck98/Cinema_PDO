<?php

ob_start();

?>


<div>
    <h1>RÉALISATEURS</h1>
    <a href="index.php?action=addDirectorForm">Ajouter un réalisateur</a>
<div class="casting-grid">
    <?php
    while ($director = $directors->fetch()) {
    ?>
        <figure class="casting-figures">
            <a href="index.php?action=directorDetail&id=<?=$director['id_director']?>">
                <img src="./public/images/<?= $director['picture'] ?>" alt="picture of director : <?=$director['director']?>">
            </a>
            <figcaption>
                <a href="#"><strong><?=$director['director']?></strong></a>
            </figcaption>
        </figure>
    <?php
    }
    ?>
</div>

<?php
$title = "Liste des réalisateurs";
$content = ob_get_clean();
require "views/template.php";

?>
