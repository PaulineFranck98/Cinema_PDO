<?php

ob_start();
?>


<h1>Casting </h1>
<div class="casting-grid">
    <?php
    while ($actor = $castingActors->fetch()) {
    ?>
        <figure class="casting-figures">
            <p><?=$actor['role_name']?></p>
            <a href="index.php?action=actorDetail&id=<?=$actor['id_actor']?>">
                <img src="./public/images/<?= $actor['picture'] ?>" alt="picture of actor : <?=$actor['actor']?>">
            </a>
            <figcaption>
                <a href="#"><strong><?=$actor['actor']?></strong></a>
            </figcaption>
        </figure>
    <?php
    }
    ?>
</div>


<?php

$title = "Casting du film";
$content = ob_get_clean();
require "views/template.php";
?>