
<?php
// Démarrage de la temporisation de sortie
ob_start();
?>

<h1>AJOUTER UN ACTEUR</h1>
<div>
    <form action="traitement.php?action=add" method="post" enctype="multipart/form-data" class="movieForm">
        <div>
        <!-- attribut enctype=multipart/forma-data garantit que les données du formulaire sont codées en tant que données MIME en plusieurs parties (nécessaire pour upload grande qtt de données)-->
            <label for="fileUpload">Photo</label> 
            <input type="file" name="photo" id="fileUpload">
        </div>
        <div>
            <!-- chaque input dispose d'un attribut "name"
            -> va permettre à la requête de classer le contenu de la saisie dans des clés portant le nom choisi -->
            <label>Prénom</label>
            <input type="text" name="title"> 
        </div>
        <div>
            <label>Nom</label>
            <input type="text" name="title"> 
        </div>
        <div>
            <label>Genre</label>
            <input type="text" name="title"> 
        </div> 
        <div>
            <label>Date de naissance </label>
            <!-- possède attribut name -->
            <input type="date" name="birth_date"> 
        </div> 
        <div>     
            <!-- possède AUSSI attribut name : permettra de vérifier côté serveur que le formulaire a bien été validé par l'utilisateur -->
            <input type="submit" name="submit" value="Ajouter l'acteur">
        </div>    
    </form>
</div>
  


    <?php
$title = "Ajouter un nouvel acteur";
$content = ob_get_clean();
require "views/template.php";
?>
