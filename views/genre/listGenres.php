<?php

ob_start();

?>


<div>
    <h1>Liste des genres</h1>
    <?php
    while ($genre= $genres->fetch()){ ?>
    <div>
        <p><strong><?=$genre['genre_name']?> : <?=$genre['title']?></strong></p>
    </div>
<?php }
?>
</div>

<?php
$title = "Liste des genres";
$content = ob_get_clean();
require "views/template.php";

?>