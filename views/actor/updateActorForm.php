<?php

ob_start();

?>

<h1 class="h1_detail">MODIFIER L'ACTEUR</h1>
<div>
   
    <form action="index.php?action=updateActor&id=<?=$actor['id_actor']?>" method="post" enctype="multipart/form-data" class="personForm">

        <div>
            <label for="fileUpload">Photo</label> 
            <input type="file" name="picture" id="fileUpload">
        </div>
        <div>
            <label>Prénom</label>
            <input type="text" name="first_name"  value="<?=isset($actor['first_name'])? $actor['first_name'] : ''; ?>">
        </div>
        <div>
            <label>Nom</label>
            <input type="text" name="last_name" id="last_name"  value="<?=isset($actor['last_name']) ? $actor['last_name'] : ''; ?>">
        </div>
        <div>
            <label>Genre</label>
            <input type="text" name="person_gender" id="person_gender"  value="<?=isset($actor['person_gender']) ? $actor['person_gender'] : ''; ?>">
        </div>
        <div>
            <input type="submit" name="submit" value="Enregistrer">
        </div>
    </form>
</div>

<?php
$title =  'Modifier un acteur';
$currentPage = 'personDetail';
$content = ob_get_clean();
require 'views/template.php';
?>
