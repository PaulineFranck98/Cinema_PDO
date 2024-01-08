<?php

ob_start();
?>

<div>
    <h1>Casting</h1>
    <?php
    while ($actor = $castingActors->fetch()){ ?>
    <div>
        
        <p><strong><?=$actor['actor']?></strong></p>
        <span><?=$actor['role_name']?></span>
    </div>
<?php }
?>
</div>









<?php

$title = "Casting du film";
$content = ob_get_clean();
require "views/template.php";
?>