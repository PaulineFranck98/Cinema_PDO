
<?php
// Démarrage de la temporisation de sortie
ob_start();
?>

<h1>AJOUTER UN ACTEUR</h1>
<div>
    <form action="index.php?action=addActor" method="post" enctype="multipart/form-data" class="movieForm">
        <div>
        <!-- attribut enctype=multipart/forma-data garantit que les données du formulaire sont codées en tant que données MIME en plusieurs parties (nécessaire pour upload grande qtt de données)-->
            <label for="fileUpload">Photo</label> 
            <input type="file" name="photo" id="fileUpload">
        </div>
        <div>
            <label>Prénom</label>
            <input type="text" name="first_name"> 
        </div>
        <div>
            <label>Nom</label>
            <input type="text" name="last_name"> 
        </div>
        <div>
            <label>Genre</label>
            <input type="text" name="person_gender"> 
        </div> 
        <div>
            <label>Date de naissance </label>
           
            <input type="date" name="birth_date"> 
        </div> 
        <div>     
            <input type="submit" name="submit" value="Ajouter l'acteur">
        </div>    
    </form>
</div>
  


    <?php
$title = "Ajouter un nouvel acteur";
$content = ob_get_clean();
require "views/template.php";
?>
