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

        $params = [
            'id' => $id,
        ];

        $film = $dao->executerRequete($sql, $params);
        // instancier une variable avec la requete 
        $dureeFilmObject = $dao->executerRequete($sqlDuree, $params);

        $time = $this->durationMovie($dureeFilmObject);
        
        require "views/movie/detailMovie.php"; 
        
    }
    public function showCasting($id){

        $dao = new DAO();

        $sql = "SELECT CONCAT(p.first_name,' ',p.last_name) AS actor, r.role_name
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
    


}