<?php

ob_start();
?>

<h1>Ajouter un genre</h1>

<form action="index.php?action=addGenre" method="post">


    <label for="genre_name">Nom du genre:</label>

    <input type="text" name="genre_name" id="genre_name">

    <input type="submit" name="submit" value="Enregistrer">
</form>

<?php

$title = "Ajouter un genre";
$content = ob_get_clean();
require "views/template.php";
