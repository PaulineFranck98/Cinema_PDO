
<?php
// Démarrage de la temporisation de sortie
ob_start();
?>

<h1 style="margin-top:120px;">AJOUTER UN FILM</h1>
<div>
    <form action="index.php?action=addMovie" method="post" enctype="multipart/form-data" class="movieForm">
        <div class="movieForm-div1">
            <div class="movieForm-div">
            
                <label>Titre</label>
                <input type="text" name="title"> 

            </div>

            <div class="movieForm-div">

                <label for="fileUpload">Affiche</label> 
                <input type="file" name="picture" id="fileUpload">

            </div>
            <div class="movieForm-div">

                <label for="fileUpload">Image de fond</label> 
                <input type="file" name="background_picture" id="fileUpload">

            </div>
            <div class="movieForm-div">

                <label for="fileUpload">Titre <small> (en png)</small></label> 
                <input type="file" name="title_png" id="fileUpload">

            </div>

            <div class="movieForm-div">

                <label>Durée <small>(en minutes)</small></label>
                <input type="number" min="0" step="any" name="duration"> 

            </div>  
        </div>
        <div class="movieForm-div2">
            <div class="movieForm-div">

                <label>Synopsis </label>
                <textarea name="synopsis" oninput='this.style.height = "";this.style.height = this.scrollHeight + "px"'></textarea> 

            </div> 

            <div class="movieForm-div">

                <label>Date de sortie </label>
                <input type="date" name="release_date"> 

            </div>

            <div class="movieForm-div3">
                <div class="movieForm-div4">
                    <label>Réalisateur</label>
                    <select  name="id_director">
                        <?php
                        while ($director = $directors->fetch()) {
                            ?>  
                            <option value='<?=$director['id_director']?>'><?=$director['director']?></option>
                            
                            <?php 
                        }
                        ?>
                    </select> 
                </div>
             
        
                <div class="movieForm-div4">
                    <label>Genre</label>
                    <select name="id_genre">
                        <?php while ($genre = $genres->fetch()){
                            ?>
                            <option value='<?=$genre['id_genre']?>'><?=$genre['genre_name']?></option>
                            <?php
                        }
                        ?>
                    </select>
                </div>
            </div> 
            <div>     
                <input type="submit" name="submit" value="Ajouter le film">
            </div>  
        </div>  
    </form>
</div>
  


<?php
$title = "Ajouter un nouveau film";
$content = ob_get_clean();
require "views/template.php";
?>
