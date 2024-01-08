<!DOCTYPE html>
<html lang="en">
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
                    <li><a href='index.php?action=homePage'>Page d'accueil</a></li>
                    <li><a href='index.php?action=listFilms'>Liste des films</a></li>
                    <li><a href='index.php?action=listActors'>Liste des acteurs</a></li>
                    <li><a href='index.php?action=listDirectors'>Liste des réalisateurs</a></li>
                    <li><a href='index.php?action=listGenres'>Liste des genres</a></li>
                </ul>
            </nav>
        </header>

        <main>
        <?= $content ?>
        </main>


        <footer>
            <span>Ceci est un footer</span>
        </footer>
    </div>
</body>
</html>