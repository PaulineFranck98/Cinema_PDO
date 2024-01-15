<?php

class HomeController{
    
    public function homePage(){
        
        $dao = new DAO();

        $sql = "SELECT f.id_film,  f.title, DATE_FORMAT(f.release_date, '%d/%m/%Y'), f.picture
            FROM film f
            ORDER BY YEAR(f.release_date) DESC, MONTH(f.release_date) DESC, DAY(f.release_date) DESC
            LIMIT 3";
        $lastmovies = $dao->executerRequete($sql);
        
        require "views/home/homePage.php";
    }

}