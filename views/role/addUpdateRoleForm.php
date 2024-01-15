<?php

ob_start();

// Check if an ID is provided in the URL (for updating)
if (isset($_GET['id'])) {

    $title = 'MODIFIER LE RÔLE'; 

} else {

    $title = 'AJOUTER UN ROLE';

}

?>


<h1><?=$title ?></h1>

<form action="index.php?action=addUpdateRole" method="post">

    <input type="hidden" name="id_role" value="<?= isset($role['id_role']) ? $role['id_role'] : ''; ?>">

    <label for="role_name">Nom du role:</label>

    <input type="text" name="role_name" id="role_name" required value="<?= isset($role['role_name']) ? $role['role_name'] : ''; ?>">

    <input type="submit" name="submit" value="Enregistrer">

</form>

<?php

$title = "Ajouter/Modifier un role";
$content = ob_get_clean();
require "views/template.php";
