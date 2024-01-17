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

        $sql = "SELECT f.id_film, f.title, f.picture, f.synopsis, DATE_FORMAT(f.release_date, '%d/%m/%Y') AS date 
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

    public function addMovieForm(){
        $dao = new DAO();

        $sqlDirector = "SELECT CONCAT(p.first_name,' ',p.last_name) AS director, d.id_director
        FROM person p INNER JOIN director d
        ON p.id_person = d.person_id";
        
        $sqlGenre = "SELECT g.genre_name, g.id_genre
                     FROM genre g";
                                    
              
        $directors = $dao->executerRequete($sqlDirector);

        $genres = $dao->executerRequete($sqlGenre);
        

      
        require "views/movie/addMovieForm.php";

        
    } 

    public function addMovie(){ 

        $dao = new DAO();


        if(isset($_POST['submit'])){
        
            $title = filter_input(INPUT_POST,"title",FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $duration = filter_input(INPUT_POST,"duration",FILTER_VALIDATE_INT);
            $synopsis = filter_input(INPUT_POST,"synopsis",FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $release_date = filter_input(INPUT_POST,"release_date",FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $director_id = filter_input(INPUT_POST,"id_director",FILTER_VALIDATE_INT);
            $genre_id = filter_input(INPUT_POST,"genre_id",FILTER_VALIDATE_INT);
            
            $picture ='';
            // $release_date = new DateTime($release_date_string);

            if(isset($_FILES['picture']) && $_FILES['picture']['error']==0){
                // Define allowed file extensions
                $allowed = [
                    "jpg" => "image/jpg",
                    "jpeg" => "image/jpeg",
                    "png" => "image/png",
                ];
                // Extract file details
                $filename = $_FILES['picture']['name'];
                
                $filetype = $_FILES['picture']['type'];
                
                $filesize = $_FILES['picture']['size'];
                
                // Get file extension and generate a unique file name using md5
                $extension = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
                
                $picture= md5($filename). ".". $extension;
                
                // Check for allowed file extensions and size limit
                if(!array_key_exists($extension, $allowed)) die("Erreur : extension non autorisée");
                
                $maxsize = 2 * 1024 * 1024;
                
                if($filesize > $maxsize) die("Erreur : taille de fichier trop lourde");
                
                // Check MIME type and proceed with file upload 
                if(in_array($filetype, $allowed)){
                    
                    //check if file exists
                    if (file_exists("public/images/" . $picture)) {
                        
                        echo $_FILES['picture']['name']. " existe déjà";
                        
                    }else {
                        
                        move_uploaded_file($_FILES['picture']['tmp_name'], "public/images/". $picture);
                        
                        
                        echo "Votre fichier a été téléchargé avec succès!";
                    }
                }else {
                    echo "Erreur : problème de téléchargement du fichier";
                }
            }else {
                
                echo "Erreur : " . $_FILES['picture']['error'];
                
            }   
            
            $sqlMovie = "INSERT INTO film (title,duration,synopsis,release_date,director_id, picture)
                        VALUES (:title,:duration,:synopsis,:release_date,:director_id, :picture)";

$paramsMovie = [
    ':title' => $title,
    ':duration' => $duration,
    ':synopsis' => $synopsis,
    ':release_date' => $release_date,
    ':director_id'=> $director_id,
    // ':genre_id'=> $genre_id,
    ':picture' => $picture,
];
// var_dump($paramsMovie);die();
// var_dump($title,$duration,$synopsis,$release_date,$director_id, $genre_id); die();

$dao->executerRequete($sqlMovie, $paramsMovie);
// var_dump($sqlMovie); die();

$film_id = $dao->getLastInsertId();

$sqlFilmGenre = "INSERT INTO film_genre (film_id, genre_id)
                             VALUES (:film_id, :genre_id)";
            
            $paramsFilmGenre = [
                ':film_id' => $film_id,
                ':genre_id' => $genre_id 
            ];

            $dao->executerRequete($sqlFilmGenre, $paramsFilmGenre);



          
           
            header("Location: index.php?action=listFilms");
            exit();
    
        }

    }


}
















// $filmId = filter_input(INPUT_POST,"film_id",FILTER_VALIDATE_INT);
// $actorId = filter_input(INPUT_POST,"actor_id",FILTER_VALIDATE_INT);
// $roleId = filter_input(INPUT_POST,"role_id",FILTER_VALIDATE_INT);

// $sqlCasting = "INSERT INTO casting (film_id, actor_id, role_id)
//             VALUES (:film_id, :actor_id, :role_id)";

// $paramsCasting = [
//     ':film_id' => $filmId,
//     ':actor_id' => $actorId,
//     ':role_id' => $roleId,
// ];

// $castingResult = $dao->executerRequete($sqlCasting, $paramsCasting);
