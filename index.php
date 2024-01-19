<?php 
    // je demande l'accès aux fichiers 
    require_once "controllers/HomeController.php";
    require_once "controllers/PersonController.php";
    require_once "controllers/MovieController.php";
    require_once "controllers/GenreController.php";
    require_once "controllers/RoleController.php";
    // require_once "controllers/GenreController.php";
    // require_once "controllers/RoleController.php";

    // je crée des instances des controllers
    $homeCtrl = new HomeController();
    $personCtrl = new PersonController();
    $movieCtrl = new MovieController();
    $genreCtrl = new GenreController();
    $roleCtrl = new RoleController();
 
    // index.php va intercepter la requête HTTP et va orienter vers le bon controller et la bonne méthode 
    //  ex : index.php?action=listFilms
    // on passe ici par l'URL avec GET
    // si il y a le mot 'action' dans mon URL on switch
    if(isset($_GET['action'])){
        // si j'ai 'id' dans l'url ...
        $id = filter_input(INPUT_GET,"id", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        // var_dump($id); die;
        // alors on switch vers les différents 'action' possibles 
        switch($_GET['action']){
            // 1er case listFilms : pour avoir accès à listFilms, tu vas chercher $movieCtrl et va voir si listFilms existe 
            case "listFilms": $movieCtrl->findAllMovies(); 
            break; 
            case "listActors": $personCtrl->findAllActors();
            break;
            case "listDirectors": $personCtrl->findAllDirectors();
            break;
            case "listGenres": $genreCtrl->findAllGenres();
            break;
            case "detailMovie": $movieCtrl->findOneById($id);
            break;
            case "casting": $movieCtrl->showCasting($id);
            break;
            case "addCastingForm": $movieCtrl->addCastingForm($id);
            break;
            case "addCasting": $movieCtrl->addCasting($id);
            break;
            case "homePage" : $homeCtrl->homePage();
            break;
            case "actorDetail" : $personCtrl->findActorById($id);
            break;
            case "directorDetail" : $personCtrl->findDirectorById($id);
            break;
            case "addMovieForm" : $movieCtrl->addMovieForm();
            break;
            case "addMovie" : $movieCtrl->addMovie();
            break;
            case "updateMovie" : $movieCtrl->updateMovie($id);
            break;
            case "deleteMovie" : $movieCtrl->deleteMovie();
            break;
            case "updateMovieForm" : $movieCtrl->updateMovieForm($id);
            break;
            case "updateActorForm" : $personCtrl->updateActorForm($id);
            break;
            case "updateActor" : $personCtrl->updateActor($id);
            break;
            case "addActor" : $personCtrl->addActor();
            break;
            case "deleteActor" : $personCtrl->deleteActor();
            break;
            case "addActorForm" : $personCtrl->addActorForm();
            break;
            case "addDirector" : $personCtrl->addDirector();
            break;
            case "addDirectorForm" : $personCtrl->addDirectorForm();
            break;
            case "updateDirectorForm" : $personCtrl->updateDirectorForm($id);
            break;
            case "updateDirector" : $personCtrl->updateDirector($id);
            break;
            case "updateGenreForm" : $genreCtrl->updateGenreForm($id);
            break;
            case "updateGenre" : $genreCtrl->updateGenre($id);
            break;
            case "addGenre" : $genreCtrl->addGenre();
            break;
            case "addGenreForm" : $genreCtrl->addGenreForm();
            break;
            case "deleteGenre" : $genreCtrl->deleteGenre();
            break;
            case "detailGenre" : $genreCtrl->findGenreByID($id);
            break;
            case "updateRoleForm" : $roleCtrl->updateRoleForm($id);
            break;
            case "updateRole" : $roleCtrl->updateRole($id);
            break;
            case "addRoleForm" : $roleCtrl->addRoleForm();
            break;
            case "addRole" : $roleCtrl->addRole();
            break;
            case "deleteRole" : $roleCtrl->deleteRole();
            break;
            case "listRoles" : $roleCtrl->findAllRoles();
            break;
            
            


        
            default : $homeCtrl->homePage();
        }
        
    } else {
        //Si l'url de contient pas d'action enregistrer, ont fait appel au constructeur homepage, pour afficher la page d'acceuil par défaut
        $homeCtrl->homePage();
    }
    
    
       
    ?>

    <!-- définir la temporisation de sortie  -->


