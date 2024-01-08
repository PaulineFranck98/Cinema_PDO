<?php

class HomeController{
    // normalement appelée 'index'
    public function homePage(){
        
        // cette fonction renvoie une vue, afin que l'utilisateur arrive sur le page d'accueil même en cas d'erreur 
        require "views/home/homePage.php"; 

    }

}