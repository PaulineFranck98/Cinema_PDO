<?php

ob_start();

// Check if an ID is provided in the URL (for updating)
// if (isset($_GET['id'])) {

// //     $title = 'MODIFIER L\'ACTEUR';
//     $action = "index.php?action=updateActor&id=".$actor['actor']['id_actor'];

// } else {

//     $title = 'AJOUTER UN ACTEUR';
//     $action = "index.php?action=addUpdateActor";
// }

?>




<div>
    <?php

    // var_dump($actor);
    ?>
    <form action="index.php?action=updateActor&id=<?=$actor['id_actor']?>" method="post" enctype="multipart/form-data" class="movieForm">

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
$title =  'Modifier un acteur/Ajouter un nouvel acteur';
$content = ob_get_clean();
require 'views/template.php';
?>
