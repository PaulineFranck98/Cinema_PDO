<?php

ob_start();

?>

<h1 style="margin-top:120px;">AJOUTER UN RÉALISATEUR</h1>
<div>

    <form action="index.php?action=addDirector" method="post" enctype="multipart/form-data" class="personForm">


        <div>
            <label for="fileUpload">Photo</label> 
            <input type="file" name="picture" id="fileUpload">
        </div>
        <div>
            <label>Prénom</label>
            <input type="text" name="first_name">
        </div>
        <div>
            <label>Nom</label>
            <input type="text" name="last_name" id="last_name">
        </div>
        <div>
            <label>Genre</label>
            <input type="text" name="person_gender" id="person_gender">
        </div>
        <div>
            <input type="submit" name="submit" value="Enregistrer">
        </div>
    </form>
</div>

<?php
$title =  'Ajouter un nouveau réalisateur';
$content = ob_get_clean();
require 'views/template.php';
?>
