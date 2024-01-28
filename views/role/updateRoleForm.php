<?php

ob_start();

?>

<div class=" background">
    <img src="./public/images/interstellar_banner.jpg" alt="background image">
</div>

<h1 style="margin-top:120px;">MODIFIER LE RÔLE</h1>


<form action="index.php?action=updateRole" method="post" class="personForm">

    <input type="hidden" name="id_role" value="<?= isset($role['id_role']) ? $role['id_role'] : ''; ?>">

    <label for="role_name">Nom du role:</label>

    <input type="text" name="role_name" id="role_name" required value="<?= isset($role['role_name']) ? $role['role_name'] : ''; ?>">

    <input type="submit" name="submit" value="Enregistrer">

</form>

<?php

$title = "Modifier un role";
$content = ob_get_clean();
require "views/template.php";
