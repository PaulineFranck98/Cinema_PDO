<?php

ob_start();
?>

<h1>Modifier un genre</h1>

<form action="index.php?action=updateGenre" method="post">

<input type="hidden" name="id_genre" value="<?= isset($genre['id_genre']) ? $genre['id_genre'] : ''; ?>">

    <label for="genre_name">Nom du Genre:</label>

    <input type="text" name="genre_name" id="genre_name" required value="<?=isset($genre['genre_name']) ? $genre['genre_name'] : ''; ?>">

    <input type="submit" name="submit" value="Enregistrer">
</form>

<?php

$title = "Modifier un Genre";
$content = ob_get_clean();
require "views/template.php";
