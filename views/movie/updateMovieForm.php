
<?php
// Démarrage de la temporisation de sortie
ob_start();
?>
<div class=" background">
    <img src="./public/images/<?= $movie['banner'] ?>" alt="background image">
</div>

<img src="./public/images/<?= $movie['title_picture'] ?>" class="movie-title-update">
<div>
    <form action="index.php?action=updateMovie&id=<?=$movie['id_film']?>" method="post" enctype="multipart/form-data" class="movieForm">
        
        <div class="movieForm-div1">
            
            <div class="movieForm-div">

                <label>Titre</label>
                <input type="text" name="title" value="<?=isset($movie['title'])? $movie['title'] : '';?>"> 
            </div>

            <div class="movieForm-div">

                <label for="fileUpload">Affiche</label> 
                <input type="file" name="picture" id="fileUpload">

            </div>

            <div class="movieForm-div">

                <label for="fileUpload">Image de fond</label> 
                <input type="file" name="banner" id="fileUpload">

            </div>

            <div class="movieForm-div">

                <label for="fileUpload">Titre <small> (en png)</small></label> 
                <input type="file" name="title_picture" id="fileUpload">

            </div>

            <div class="movieForm-div">

                <label>Durée (en minutes)</label>
                <input type="number" min="0" step="any" name="duration" value="<?=isset($movie['duration'])? $movie['duration'] : '';?>"> 

            </div>
           
        </div>
        <div class="movieForm-div2">

            <div class="movieForm-div">

                <label>Synopsis </label>
                <textarea name="synopsis" oninput='this.style.height = "";this.style.height = this.scrollHeight + "px"'><?=isset($movie['synopsis'])? $movie['synopsis'] : '';?></textarea>  

            </div> 

            <div class="movieForm-div3">

                <div class="movieForm-div4">

                    <label>Réalisateur</label>
                    <select name="id_director">
                        <?php
                        $selectedDirectorID = $movie['director_id'];

                        while ($director = $directors->fetch()) {

                            $selected = ($director['id_director'] == $selectedDirectorID)? "selected" : "";
                            ?>  
                            <option value='<?=$director['id_director']?>'<?= $selected ?>><?=$director['director']?></option>
                            
                            <?php 
                        }
                        ?>
                    </select> 
                </div> 
            
                <div class="movieForm-div4">
                    <label>Genre</label>
                    <select name="id_genre">
                        <?php
                        $selectedGenreID = $movie['genre_id'];

                        while ($genre = $genres->fetch()) {

                            $selected = ($genre['id_genre'] == $selectedGenreID)? "selected" : "";
                            ?>  
                            <option value='<?=$director['id_genre']?>'<?= $selected ?>><?=$genre['genre_name']?></option>
                            
                            <?php 
                        }
                        ?>
                    </select>     
                </div> 
            </div>
            <div class="movieForm-div5">
        
                <div class="movieForm-div">

                    <label>Date de sortie </label>
                    <input type="date" name="release_date" value="<?= isset($movie['release_date']) ? date('Y-m-d', strtotime($movie['release_date'])) : ''; ?>"> 
                </div>

                <div class="movieForm-div"> 

                    <label>Age minimum</label>
                    <input type="number" min="0" step="any" name="age_min"  value="<?=isset($movie['age_min'])? $movie['age_min'] : '';?>"> 

                </div> 
            </div>

            <div>     
                <input type="submit" name="submit" value="Modifier le film">
            </div> 
            
        </div>   
    </form>
</div>
  


<?php
$title = "Ajouter un nouveau film";
$content = ob_get_clean();
require "views/template.php";
?>
