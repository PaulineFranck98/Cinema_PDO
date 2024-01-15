<?php

ob_start();

// Check if an ID is provided in the URL (for updating)
if (isset($_GET['id'])) {

    $title = 'MODIFIER LE GENRE'; 

} else {

    $title = 'AJOUTER UN GENRE'; 
}
?>

<h1><?=$title?></h1>

<form action="index.php?action=addUpdateGenre" method="post">

<input type="hidden" name="id_genre" value="<?= isset($genre['id_genre']) ? $genre['id_genre'] : ''; ?>">

    <label for="genre_name">Nom du Genre:</label>

    <input type="text" name="genre_name" id="genre_name" required value="<?=isset($genre['genre_name']) ? $genre['genre_name'] : ''; ?>">

    <input type="submit" name="submit" value="Enregistrer">
</form>

<?php

$title = "Ajouter/Modifier un Genre";
$content = ob_get_clean();
require "views/template.php";
