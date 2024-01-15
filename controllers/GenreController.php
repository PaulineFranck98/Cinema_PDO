<?php

class GenreController{

    public function findAllGenres(){
        $dao = new DAO();

        $sql = "SELECT g.genre_name, g.id_genre, f.title, f.id_film, f.picture
        FROM genre g
        LEFT JOIN film_genre fg ON fg.genre_id = g.id_genre
        LEFT JOIN film f ON fg.film_id = f.id_film
        ORDER BY g.genre_name, f.title;
        
        ";
        
                
        $genres = $dao->executerRequete($sql);

        require "views/genre/listGenres.php";

    }

    public function findGenreByID($id) {
        $dao = new DAO();
        $sql = "SELECT g.genre_name, g.id_genre
                FROM genre g
                WHERE g.id_genre = :id";
    ;
    
        $sql1 ="SELECT g.genre_name, f.title, f.id_film, f.picture
                FROM genre g
                LEFT JOIN film_genre fg ON fg.genre_id = g.id_genre
                LEFT JOIN film f ON fg.film_id = f.id_film
                WHERE g.id_genre = :id";

        $params = [
            ':id' => $id,
        ];

        $genreDetail= $dao->executerRequete($sql, $params);
        $genreFilms = $dao->executerRequete($sql1, $params);

    
        require "views/genre/detailGenre.php";
    }
    

    public function addUpdateGenreForm(){

        $genre = [];
        if (isset($_GET['id'])){
            $id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
            if ($id !==false){
                $dao = new DAO();
                $sql = "SELECT * 
                        FROM genre 
                        WHERE id_genre = :id";
                $params = [':id' =>$id];
                $result = $dao->executerRequete($sql,$params);
                $genre = $result->fetch(PDO::FETCH_ASSOC);
            }
        }
        require "views/genre/addUpdateGenreForm.php";
    }

    public function addUpdateGenre(){

        if(isset($_POST['submit'])){
            //assainissement et validations des données du formulaire  
            $id_genre = filter_input(INPUT_POST, 'id_genre', FILTER_VALIDATE_INT);
            $genre_name = filter_input(INPUT_POST, 'genre_name', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

            // Validation des données (ajoutez vos propres validations)

            // Enregistrement du genre en base de données
            $dao = new DAO();
            
            if ($id_genre !== false) {
                // Mise à jour
                $sql = "UPDATE genre SET genre_name = :genre_name WHERE id_genre = :id_genre";
                $params = [':genre_name' => $genre_name, ':id_genre' => $id_genre];
            } else {
                // Ajout
                $sql = "INSERT INTO genre (genre_name) VALUES (:genre_name)";
                $params = [':genre_name' => $genre_name];
            }

            $dao->executerRequete($sql, $params);

            header("Location: index.php?action=listGenres");
            exit();
        }
    }
    
    
    public function deleteGenre() {

        if (isset($_POST['submit'])) {

            $id_genre = filter_input(INPUT_POST, 'id_genre', FILTER_VALIDATE_INT);

            if ($id_genre !== false) {

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