<?php
require_once "bdd/DAO.php";

class MovieController{

    public function findAllMovies(){
        // je peux instancier ici cette class grâce au require_once "bdd/DAO.php";
        // il va donc pouvoir utiliser le constructeur de Dao 
        $dao = new DAO();

        $sql = "SELECT f.id_film, f.title, f.picture 
                FROM film f";

        $films = $dao->executerRequete($sql);
        // var_dump($films); die();
        require "views/movie/listFilms.php"; 
    }

  

    public function findOneById($id)
    {

        $dao = new DAO();

        $sql = "SELECT f.id_film, f.title, f.picture, f.synopsis
                FROM film f
                WHERE id_film = :id";

        //faire une deuxieme requete just avec la duree
        $sqlDuree = "SELECT f.duration
                     FROM film f
                     WHERE id_film = :id";

        $sql2 = "SELECT CONCAT(p.first_name,' ',p.last_name) AS director, p.picture, d.id_director, f.title, f.id_film
                        FROM person p INNER JOIN director d
                        ON p.id_person = d.person_id
                        INNER JOIN film f
                        ON d.id_director = f.director_id
                        WHERE id_film = :id";


        $sql3 = "SELECT a.id_actor, CONCAT(p.first_name,' ',p.last_name) AS actor, p.last_name, p.picture
        FROM person p INNER JOIN actor a
        ON p.id_person = a.person_id
        LIMIT 2";

        $params = [
            'id' => $id,
        ];

    
        $film = $dao->executerRequete($sql, $params);
        // instancier une variable avec la requete 
        $dureeFilmObject = $dao->executerRequete($sqlDuree, $params);
        
        $time = $this->durationMovie($dureeFilmObject);
        
        $filmDirector = $dao->executerRequete($sql2, $params);
        
        $mainActors = $dao->executerRequete($sql3);
        
        require "views/movie/detailMovie.php"; 
        
    }
    public function showCasting($id){

        $dao = new DAO();

        $sql = "SELECT CONCAT(p.first_name,' ',p.last_name) AS actor, a.id_actor, r.role_name, p.picture
                FROM casting c INNER JOIN film f
                ON c.film_id = f.id_film
                INNER JOIN actor a
                ON c.actor_id = a.id_actor
                INNER JOIN person p
                ON p.id_person = a.person_id
                INNER JOIN role r 
                ON c.role_id = r.id_role
                WHERE id_film = :id";

        $params = [
            'id' => $id,
        ];

        $castingActors = $dao->executerRequete($sql, $params);
        // var_dump($films); die();
        require "views/movie/casting.php"; 

    }
    public function durationMovie($dureeFilmObject)
    {

        //vu que c'est un objet il faut fetch
        // var_dump($dureeFilmObject);
        $dureeArray = $dureeFilmObject->fetch();
        // var_dump($dureeArray);
        //vu que c'est un array il faut chercher la bonne variable
        $duration = intVal($dureeArray['duration']);
       
        // var_dump($duration);
        $minutes = $duration ;
        $hours = (int)($minutes / 60) ; 
        $minute = $minutes % 60 ;

        if(!$hours){ 

            return $minute. " minutes." ;

        }else if($hours == 1){ 

            return  $hours. " heure et ". $minute. " minutes." ;

        }else{

            return  $hours. " heures et ". $minute. " minutes." ;

        }

    }

    public function showMovieForm(){
        $dao = new DAO();
    
        $sql = "SELECT CONCAT(p.first_name,' ',p.last_name) AS director, p.picture, d.id_director
                FROM person p INNER JOIN director d
                ON p.id_person = d.person_id
                ORDER BY director ";

    
        $sql1 = "SELECT g.id_genre, g.genre_name
                FROM genre g
                ORDER BY g.genre_name";

        $directors = $dao->executerRequete($sql);

        $genres = $dao->executerRequete($sql1);
        require "views/movie/movieForm.php";
        
    }

    public function addMovie(){ 
        $dao = new DAO();
        // die('ici');
        $title = filter_input(INPUT_POST,"title",FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $duration = filter_input(INPUT_POST,"duration",FILTER_VALIDATE_INT);
        $synopsis = filter_input(INPUT_POST,"synopsis",FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $release_date = filter_input(INPUT_POST,"release_date",FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $id_director = filter_input(INPUT_POST,"director",FILTER_VALIDATE_INT);

        // on doit recup toutes les données du formulaire

    }

    // public function showActorForm(){
    //     require "views/actor/actorForm.php";
    // }
    public function showDirectorForm(){
    
        require "views/director/directorForm.php";
    }


}