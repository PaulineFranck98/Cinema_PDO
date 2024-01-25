<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="public/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Nunito&display=swap" rel="stylesheet">
    <title><?= $title ?></title>
</head>
<body class="<?= (isset($currentPage) && $currentPage == 'personDetail') ? 'person-detail-body' : '' ?>">

    <header class="<?= strpos($content, 'class="h1_detail"') !== false ? 'hide-header' : '' ?>">
        
    
        <a href="#" class="logo">Imovies</a>
        <ul class="nav">
            <li><a href="index.php?action=detailMovie&id=6"><i class="fa-solid fa-house"></i></a></li>
            <li><a href='index.php?action=listFilms&id=8'>Films</a></li>
            <li><a href='index.php?action=listGenres'>Genres</a></li>
            <li><a href='index.php?action=listActors'>Acteurs</a></li>
            <li><a href='index.php?action=listDirectors'>Réalisateurs</a></li>
            <li><a href='index.php?action=addMovieForm'>Ajouter</a></li>
        </ul>
        <div class="search">
            <input type="text" placeholder="Rechercher"/>
            <i class="fa-solid fa-magnifying-glass"></i>
        </div>
    </header>

    <main>

        <?= $content ?>

    </main>


    <footer>
        <!-- <span>Ceci est un footer</span> -->
    </footer>
    
    <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>

    <script src="https://kit.fontawesome.com/d004286c36.js" crossorigin="anonymous"></script>
    <script src="public/script/script.js"></script>
    <script>
        $(document).ready(function(){
            $('.carousel').carousel();
        });
    </script>

</body>

</html>