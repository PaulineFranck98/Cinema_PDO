
<?php
// Démarrage de la temporisation de sortie
ob_start();
?>

<h1>AJOUTER UN FILM</h1>
<div>
    <form action="index.php?action=addMovie" method="post" enctype="multipart/form-data" class="movieForm">
        <div class="film-form">
            <label> Titre </label>
            <input type="text" name="title"> 
        </div>
        <div class="film-form">
            <label for="fileUpload">Affiche</label> 
            <input type="file" name="photo" id="fileUpload">
        </div>
        <div class="film-form">
            <label>Durée (en minutes)</label>
            <input type="number" min="0" step="any" name="duration"> 
        </div>  
        <div class="film-form">
            <label>Synopsis </label>
            <input type="text" name="synopsis"> 
        </div> 
        <div class="film-form">
            <label>Date de sortie </label>
            <input type="date" name="release_date"> 
        </div>
        <div>
            <label>Réalisateur</label>
            <select name="director">
                <?php
                while ($director = $directors->fetch()) {
                    ?>  
                    <option value='<?=$director['id_director']?>'><?=$director['director']?></option>
                    <?php 
                }
                ?>
            </select>  
            <input type="button" name="submit" value="Nouveau réalisateur">
        </div> 
        <div>
            <?php while ($genre = $genres->fetch()){
                ?>
                <input type="checkbox" name="genre" value='<?=$genre['id_genre']?>'>
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
  
<!-- PDO::lastInsertId -->


<?php
$title = "Ajouter un nouveau film";
$content = ob_get_clean();
require "views/template.php";
?>
