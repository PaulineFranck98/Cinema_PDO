<?php

ob_start();

?>

<div class=" background">
    <img src="./public/images/interstellar_banner.jpg" alt="background image">
</div>

<h1 style="margin-top:120px;">AJOUTER UN RÔLE</h1>

<form action="index.php?action=addRole" method="post" class="personForm">


    <label for="role_name">Nom du role:</label>

    <input type="text" name="role_name" id="role_name">

    <input type="submit" name="submit" value="Enregistrer">

</form>

<?php

$title = "Modifier un role";
$content = ob_get_clean();
require "views/template.php";
