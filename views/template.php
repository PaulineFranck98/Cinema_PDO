<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="public/css/style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Nunito&display=swap" rel="stylesheet">
    <title><?= $title ?></title>
</head>
<body>
    <div id="container">
        <header>
            <nav>
                <ul>
                    <li><a href='index.php?action=homePage'>Accueil</a></li>
                    <li><a href='index.php?action=listFilms'>Films</a></li>
                    <li><a href='index.php?action=listActors'>Acteurs</a></li>
                    <li><a href='index.php?action=listDirectors'>Réalisateurs</a></li>
                    <li><a href='index.php?action=listGenres'>Genres</a></li>
                    <li><a href='index.php?action=movieForm'>Ajouter film</a></li>
                    <li><a href='index.php?action=addActorForm'>Ajouter acteur</a></li>
                    <li><a href='index.php?action=directorForm'>Ajouter réalisateur</a></li>
                </ul>
            </nav>
        </header>

        <main>
        <?= $content ?>
        </main>


        <footer>
            <!-- <span>Ceci est un footer</span> -->
        </footer>
    </div>
</body>
</html>