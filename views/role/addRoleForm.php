<?php

ob_start();

?>


<h1>Ajouter un rôle</h1>

<form action="index.php?action=addRole" method="post">


    <label for="role_name">Nom du role:</label>

    <input type="text" name="role_name" id="role_name">

    <input type="submit" name="submit" value="Enregistrer">

</form>

<?php

$title = "Modifier un role";
$content = ob_get_clean();
require "views/template.php";
