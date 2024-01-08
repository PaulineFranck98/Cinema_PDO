<?php

class GenreController{

    public function findAllGenres(){
        $dao = new DAO();

        $sql = "SELECT f.title, g.genre_name
        FROM film_genre fg INNER JOIN film f
        ON fg.film_id = f.id_film
        INNER JOIN genre g
        ON fg.genre_id = g.id_genre";
                
        $genres = $dao->executerRequete($sql);

        require "views/genre/listGenres.php";

    }
}