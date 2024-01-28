<?php

ob_start();

?>
<div class=" background">
                <img src="./public/images/interstellar_banner.jpg" alt="background image">
        </div>
<h1 style="margin-top:120px;">AJOUTER UN ACTEUR</h1>
<div>
    
    <form action="index.php?action=addActor" method="post" enctype="multipart/form-data" class="personForm">

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
$title =  'Ajouter un nouvel acteur';
$content = ob_get_clean();
require 'views/template.php';
?>
