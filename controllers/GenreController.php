<?php

class GenreController{

    public function findAllGenres(){
        $dao = new DAO();

        $sql = "SELECT g.genre_name, g.id_genre, f.title, f.id_film, f.picture
        FROM genre g
        INNER JOIN film_genre fg ON fg.genre_id = g.id_genre
        INNER JOIN film f ON fg.film_id = f.id_film
        ORDER BY g.genre_name, f.title";
        
                
        $genres = $dao->executerRequete($sql);

        require "views/genre/listGenres.php";

    }

    public function findGenreByID($id) {
        $dao = new DAO();
        $sql = "SELECT g.genre_name, g.id_genre
                FROM genre g
                WHERE g.id_genre = :id";
    
    
        $sql1 ="SELECT g.genre_name, f.title, f.id_film, f.picture
                FROM genre g
                INNER JOIN film_genre fg ON fg.genre_id = g.id_genre
                INNER JOIN film f ON fg.film_id = f.id_film
                WHERE g.id_genre = :id";

        $params = [
            ':id' => $id,
        ];

        $genreDetail= $dao->executerRequete($sql, $params);
        $genreFilms = $dao->executerRequete($sql1, $params);

    
        require "views/genre/detailGenre.php";
    }
    
    public function addGenreForm(){
        
        require "views/genre/addGenreForm.php";   
    }

    public function addGenre(){

        $dao = new DAO();

        if(isset($_POST['submit'])){

            //sanitation and validation of form data  
            $id_genre = filter_input(INPUT_POST, 'id_genre', FILTER_VALIDATE_INT);

            $genre_name = filter_input(INPUT_POST, 'genre_name', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

            
            $sql = "INSERT INTO genre (genre_name) VALUES (:genre_name)";


            $param = [
                ':genre_name' => $genre_name 
            ];
         

            $dao->executerRequete($sql, $param);

            header("Location: index.php?action=listGenres");
            exit();
        }
    }


    public function updateGenreForm($id){
    
        $dao = new DAO();
        
        $sqlGenreDao = "SELECT * FROM genre WHERE id_genre = :id";

        $params = [':id' =>$id];

        $sqlGenre = $dao->executerRequete($sqlGenreDao,$params);
        
        $genre = $sqlGenre->fetch();
    
        
        require "views/genre/updateGenreForm.php";
    }

    public function updateGenre($id){

        $dao = new DAO();

        $sqlGenreDao = "SELECT * FROM genre WHERE id_genre = :id";

        $params = [':id' =>$id];

        $sqlGenre = $dao->executerRequete($sqlGenreDao,$params);
        
        $genre = $sqlGenre->fetch();

        if(isset($_POST['submit'])){

            //sanitation and validation of form data  
            $id_genre = filter_input(INPUT_POST, 'id_genre', FILTER_VALIDATE_INT);

            $genre_name = filter_input(INPUT_POST, 'genre_name', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

            
            $sql = "UPDATE genre SET genre_name = :genre_name WHERE id_genre = :id_genre";

            $param = [
                ':genre_name' => $genre_name,
                ':id_genre' => $id_genre
            ];
         

            $dao->executerRequete($sql, $param);

            header("Location: index.php?action=listGenres");
            exit();
        }
    }
    
    
    
    public function deleteGenre() {

        if (isset($_POST['submit'])) {

            $id_genre = filter_input(INPUT_POST, 'id_genre', FILTER_VALIDATE_INT);

            if ($id_genre) {

                $dao = new DAO();

                $sql = "DELETE FROM genre WHERE id_genre = :id_genre";

                $params = [':id_genre' => $id_genre];

                $dao->executerRequete($sql, $params);

                
                header("Location: index.php?action=listGenres");
                
                exit();
            }
        }
    }

}  

// } else {
//     // Ajout
//     $sql = "INSERT INTO genre (genre_name) VALUES (:genre_name)";
//     $params = [':genre_name' => $genre_name];
// }