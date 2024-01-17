<?php

ob_start();

?>


<div>
    <h1>RÔLES</h1>
    <a href="index.php?action=addRoleForm">Ajouter un rôle</a>
    <div class="casting-grid">
    
        <ul>
            <?php
            while ($role = $roles->fetch()) {
                ?>  
                <li><?=$role['role_name']?> <a href="index.php?action=updateRoleForm&id=<?=$role['id_role']?>">Modifier le rôle</a></li>
                <?php
    
             }
             ?>
        </ul>
    </div>
</div>


<?php

$title = "Liste des rôles";
$content = ob_get_clean();
require "views/template.php";

?>
