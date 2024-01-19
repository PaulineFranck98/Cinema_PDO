
<?php
// Démarrage de la temporisation de sortie
ob_start();
?>

<h1>AJOUTER CASTING</h1>
<div>
    <form action="index.php?action=addCasting" method="post" enctype="multipart/form-data" class="movieForm">
        
    <input type="hidden" name="film_id" value="<?= $film_id ?>">

      
        <div>
            <label>Acteur</label>
            <select name="actor_id">
                <?php
                while ($actor = $actors->fetch()) {
                    ?>  
                    <option value='<?=$actor['id_actor']?>'><?=$actor['actor']?></option>
                    <?php var_dump($actor);?>
                    <?php 
                }
                ?>
            </select> 
        </div> 
        <div>
            <label>Rôle</label>
            <select name="role_id">
                <?php
                while ($role = $roles->fetch()) {
                    ?>  
                    <option value='<?=$role['id_role']?>'><?=$role['role_name']?></option>
                    <?php var_dump($role);?>
                    <?php 
                }
                ?>
            </select> 
        </div> 
        <div>     
            <input type="submit" name="submit" value="Ajouter casting">
        </div>    
    </form>
</div>
  


<?php
$title = "Ajouter un nouveau film";
$content = ob_get_clean();
require "views/template.php";
?>
