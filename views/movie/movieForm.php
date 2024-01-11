
<?php
// Démarrage de la temporisation de sortie
ob_start();
?>

<h1>AJOUTER UN FILM</h1>
<div>
    <form action="traitement.php?action=add" method="post" enctype="multipart/form-data" class="movieForm">
        <div>
        <!-- attribut enctype=multipart/forma-data garantit que les données du formulaire sont codées en tant que données MIME en plusieurs parties (nécessaire pour upload grande qtt de données)-->
            <label for="fileUpload">Affiche</label> 
            <input type="file" name="photo" id="fileUpload">
        </div>
        <div>
            <!-- chaque input dispose d'un attribut "name"
            -> va permettre à la requête de classer le contenu de la saisie dans des clés portant le nom choisi -->
            <label> Titre </label>
            <input type="text" name="title"> 
        </div>
        <div>
            <label>Durée (en minutes)</label>
            <input type="number" min="0" step="any" name="duration"> 
        </div>  
        <div>
            <label>Synopsis </label>
            <input type="text" name="synopsis"> 
        </div> 
        <div>
            <label>Date de sortie </label>
            <input type="date" name="release_date"> 
        </div>
        <div>
            <label>Réalisateur</label>
            <select>
                <?php
                while ($director = $directors->fetch()) {
                    ?>  
                    <option><?=$director['director']?></option>
                    <?php 
                }
                ?>
            </select>  
            <input type="button" name="submit" value="Nouveau réalisateur">
        </div> 
        <div>
            <?php while ($genre = $genres->fetch()){
                ?>
                <input type="checkbox" name="synopsis">
                <label><?=$genre['genre_name']?></label>
                <?php
            }
            ?>
            <input type="button" name="submit" value="Nouveau genre"> 
        </div> 
        <div>     
            <input type="submit" name="submit" value="Ajouter le film">
        </div>    
    </form>
</div>
  


<?php
$title = "Ajouter un nouveau film";
$content = ob_get_clean();
require "views/template.php";
?>
