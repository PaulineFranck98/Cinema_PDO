<?php

ob_start();

// Check if an ID is provided in the URL (for updating)
if (isset($_GET['id'])) {

    $title = 'MODIFIER LE RÉALISATEUR';

} else {

    $title = 'AJOUTER UN RÉALISATEUR'; 

}
?>

<h1><?=$title?></h1>
<div>
    <form action="index.php?action=addUpdateDirector" method="post" enctype="multipart/form-data" class="movieForm">

        <input type="hidden" name="id_person" value="<?=isset($director['id_person']) ? $director['id_person'] : ''; ?>">
        
        
        <div>
            <label for="fileUpload">Photo</label> 
            <input type="file" name="picture" id="fileUpload">
        </div>
        <div>
            <label>Prénom</label>
            <input type="text" name="first_name" required value="<?=isset($director['person']['first_name'])? $director['person']['first_name'] : ''; ?>">
        </div>
        <div>
            <label>Nom</label>
            <input type="text" name="last_name" id="last_name" required value="<?=isset($director['person']['last_name']) ? $director['person']['last_name'] : ''; ?>">
        </div>
        <div>
            <label>Genre</label>
            <input type="text" name="person_gender" id="person_gender" required value="<?=isset($director['person']['person_gender']) ? $director['person']['person_gender'] : ''; ?>">
        </div>
        <div>
            <input type="submit" name="submit" value="Enregistrer">
        </div>
    </form>
</div>

<?php
$title =  'Modifier un réalisateur/Ajouter un nouveau réalisateur';
$content = ob_get_clean();
require 'views/template.php';
?>
