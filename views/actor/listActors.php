<?php

ob_start();

?>


<div>
    <h1>ACTEURS</h1>
<div class="casting-grid">
    <?php
    while ($actor = $actors->fetch()) {
    ?>
        <figure class="casting-figures">
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

$title = "Liste des acteurs";
$content = ob_get_clean();
require "views/template.php";

?>
