<?php

ob_start();

?>


<div>
    <h1>Liste des acteurs</h1>
    <?php
    while ($actor= $actors->fetch()){ ?>
    <div>
        <p><strong><?=$actor['first_name']?> <?=$actor['last_name']?></strong></p>
    </div>
<?php }
?>
</div>

<?php
$title = "Liste des acteurs";
$content = ob_get_clean();
require "views/template.php";

?>
