
<?php
// Démarrage de la temporisation de sortie
ob_start();
?>

<h1>MODIFIER UN FILM</h1>
<div>
    <form action="index.php?action=updateMovie&id=<?=$movie['id_film']?>" method="post" enctype="multipart/form-data" class="movieForm">
        
        <div>
        
            <label>Titre</label>
            <input type="text" name="title" value="<?=isset($movie['title'])? $movie['title'] : '';?>"> 

        </div>

        <div>

            <label for="fileUpload">Affiche</label> 
            <input type="file" name="picture" id="fileUpload">

        </div>

        <div>

            <label>Durée (en minutes)</label>
            <input type="number" min="0" step="any" name="duration" value="<?=isset($movie['duration'])? $movie['duration'] : '';?>"> 

        </div>  

        <div>

            <label>Synopsis </label>
            <input type="text" name="synopsis" value="<?=isset($movie['synopsis'])? $movie['synopsis'] : '';?>"> 

        </div> 

        <div>

            <label>Date de sortie </label>
            <input type="date" name="release_date" value="<?= isset($movie['release_date']) ? date('Y-m-d', strtotime($movie['release_date'])) : ''; ?>"> 
        </div>

        <div>
            <label>Réalisateur</label>
            <select name="id_director">
                <?php
                $selectedDirectorID = $movie['director_id'];
                while ($director = $directors->fetch()) {
                    $selected = ($director['id_director'] == $selectedDirectorID)? "selected" : "";
                    ?>  
                    <option value='<?=$director['id_director']?>'<?= $selected ?>><?=$director['director']?></option>
                     <?php var_dump($director);?>
                    <?php 
                }
                ?>
            </select> 
        </div> 
    
        <div>
            <?php while ($genre = $genres->fetch()){

                ?>
                <input type="checkbox" name="genre_id" value='<?=$genre['id_genre']?>'>
                <label><?=$genre['genre_name']?></label>
                <?php
            }
            ?>
        </div> 
        <div>     
            <input type="submit" name="submit" value="Modifier le film">
        </div>    
    </form>
</div>
  


<?php
$title = "Ajouter un nouveau film";
$content = ob_get_clean();
require "views/template.php";
?>
