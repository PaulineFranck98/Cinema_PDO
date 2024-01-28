<?php

ob_start();

?>


<div>
    <h1>RÔLES</h1>
    <div class="casting-grid">
        <a href="index.php?action=addRoleForm">Ajouter un rôle</a>
    
        <ul>
            <?php
            while ($role = $roles->fetch()) {
                ?>  
                <li style="color:white"><?=$role['role_name']?> <a href="index.php?action=updateRoleForm&id=<?=$role['id_role']?>">Modifier le rôle</a></li>
                
                <form action="index.php?action=deleteRole&id=<?=$role['id_role']?>" method="post">
                    
                    <input type="hidden" name="id_role" value="<?= $role['id_role'] ?>">
                    <input type="submit" name="submit" value="Supprimer le role">
                </form>

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
