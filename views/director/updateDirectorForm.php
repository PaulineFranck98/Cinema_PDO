<?php

ob_start();

?>

<div>
    <?php

    ?>
    <form action="index.php?action=updateDirector&id=<?=$director['id_director']?>" method="post" enctype="multipart/form-data" class="movieForm">

        <div>
            <label for="fileUpload">Photo</label> 
            <input type="file" name="picture" id="fileUpload">
        </div>
        <div>
            <label>Prénom</label>
            <input type="text" name="first_name"  value="<?=isset($director['first_name'])? $director['first_name'] : ''; ?>">
        </div>
        <div>
            <label>Nom</label>
            <input type="text" name="last_name" id="last_name"  value="<?=isset($director['last_name']) ? $director['last_name'] : ''; ?>">
        </div>
        <div>
            <label>Genre</label>
            <input type="text" name="person_gender" id="person_gender"  value="<?=isset($director['person_gender']) ? $director['person_gender'] : ''; ?>">
        </div>
        <div>
            <input type="submit" name="submit" value="Enregistrer">
        </div>
    </form>
</div>

<?php
$title =  'Modifier un réalisateur';
$content = ob_get_clean();
require 'views/template.php';
?>
