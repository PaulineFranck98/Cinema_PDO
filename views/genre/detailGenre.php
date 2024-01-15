<?php
ob_start();
?>

<div>
    
    
    <div class="films-grid1">
        <?php while ($genre = $genreDetail->fetch()) : ?>
            
            <a href="index.php?action=addUpdateGenreForm&id=<?= $genre['id_genre'] ?>">Modifier</a>
            
            <form action="index.php?action=deleteGenre" method="post">
                <input type="hidden" name="id_genre" value="<?= $genre['id_genre'] ?>">
                <input type="submit" name="submit" value="Supprimer le Genre">
            </form>

            <h1 class="h1_detail"><?= mb_strtoupper($genre['genre_name']) ?></h1>
            <?php while ($film = $genreFilms->fetch()) : ?>
                <figure class="figure_films1">
                    <a href="index.php?action=detailMovie&id=<?= $film['id_film'] ?>">
                        <img src="./public/images/<?= $film['picture'] ?>" alt="picture of film: <?= $film['title'] ?>">
                    </a>
                    <figcaption>
                        <a href="index.php?action=detailMovie&id=<?= $film['id_film'] ?>"><?= $film['title'] ?></a>
                    </figcaption>
                </figure>
            <?php endwhile; ?>
        <?php endwhile; ?>
    </div>
</div>

<?php
$title = "Détail du Genre";
$content = ob_get_clean();
require "views/template.php";
?>
