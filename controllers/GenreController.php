<?php

class GenreController{

    public function findAllGenres(){
        $dao = new DAO();

        $sql = "SELECT g.genre_name
                FROM genre g";
                
        $genres = $dao->executerRequete($sql);

        require "views/genre/listGenres.php";

    }
}