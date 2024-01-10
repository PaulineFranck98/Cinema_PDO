<?php

class GenreController{

    public function findAllGenres(){
        $dao = new DAO();

        $sql = "SELECT g.genre_name, f.title, f.id_film, f.picture
        FROM genre g
        LEFT JOIN film_genre fg ON fg.genre_id = g.id_genre
        LEFT JOIN film f ON fg.film_id = f.id_film
        ORDER BY g.genre_name, f.title;
        
        ";
        
                
        $genres = $dao->executerRequete($sql);

        require "views/genre/listGenres.php";

    }
}