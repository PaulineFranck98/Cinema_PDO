<?php

ob_start();
?>

<div class=" background">
    <img src="./public/images/interstellar_banner.jpg" alt="background image">
</div>
<h1 style="margin-top:120px;">AJOUTER UN GENRE</h1>

<form action="index.php?action=addGenre" class="personForm" method="post">


    <label for="genre_name">Nom du genre:</label>

    <input type="text" name="genre_name" id="genre_name">

    <input type="submit" name="submit" value="Enregistrer">
</form>

<?php

$title = "Ajouter un genre";
$content = ob_get_clean();
require "views/template.php";
