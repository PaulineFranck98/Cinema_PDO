<?php

ob_start();

?>


<div>
    <h1>Liste des réalisateurs</h1>
    <?php
    while ($director= $directors->fetch()){ ?>
    <div>
        <p><strong><?=$director['first_name']?> <?=$director['last_name']?></strong></p>
    </div>
<?php }
?>
</div>

<?php
$title = "Liste des réalisateurs";
$content = ob_get_clean();
require "views/template.php";

?>
