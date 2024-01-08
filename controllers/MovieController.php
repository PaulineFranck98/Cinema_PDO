<?php
require_once "bdd/DAO.php";

class MovieController{

    public function findAllMovies(){
        // je peux instancier ici cette class grâce au require_once "bdd/DAO.php";
        // il va donc pouvoir utiliser le constructeur de Dao 
        $dao = new DAO();

        $sql = "SELECT f.id_film, f.title FROM film f";

        $films = $dao->executerRequete($sql);

        require "views/movie/listFilms.php"; 

    }
}