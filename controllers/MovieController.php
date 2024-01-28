<?php
require_once "bdd/DAO.php";

class MovieController{

    // public function findAllMovies(){
    //     // je peux instancier ici cette class grâce au require_once "bdd/DAO.php";
    //     // il va donc pouvoir utiliser le constructeur de Dao 
    //     $dao = new DAO();

    //     $sql = "SELECT f.id_film, f.title, f.picture 
    //             FROM film f";

    //     $films = $dao->executerRequete($sql);
    //     // var_dump($films); die();
    //     require "views/movie/listFilms.php"; 
    // }

  

    public function findOneById($id)
    {

        $dao = new DAO();

        $sql = "SELECT f.id_film, f.title, f.picture, f.synopsis, DATE_FORMAT(f.release_date, '%Y') AS date, f.banner, f.title_picture, f.age_min 
                FROM film f
                WHERE id_film = :id";

        //faire une deuxieme requete just avec la duree
        $sqlDuree = "SELECT f.duration
                     FROM film f
                     WHERE id_film = :id";
        
        $sqlLastfilms = "SELECT f.id_film,  f.title, DATE_FORMAT(f.release_date, '%Y') AS date, f.picture
            FROM film f
            ORDER BY YEAR(f.release_date) DESC, MONTH(f.release_date) DESC, DAY(f.release_date) DESC
            LIMIT 3";

      

        $params = [
            'id' => $id,
        ];


        $film = $dao->executerRequete($sql, $params);
        // instancier une variable avec la requete 
        $dureeFilmObject = $dao->executerRequete($sqlDuree, $params);

        $time = $this->durationMovie($dureeFilmObject);
        $lastmovies = $dao->executerRequete($sqlLastfilms);
       
        // $filmDirector = $dao->executerRequete($sql2, $params);
        
        // $mainActors = $dao->executerRequete($sql3, $params);
        
        require "views/movie/detailMovie.php";
        
        
    }
    public function findOneMovieById($id)
    {

        $dao = new DAO();

        $sql = "SELECT f.id_film, f.title, f.picture, f.synopsis, DATE_FORMAT(f.release_date, '%Y') AS date, f.banner, f.title_picture, f.age_min 
                FROM film f
                WHERE id_film = :id";

        //faire une deuxieme requete just avec la duree
        $sqlDuree = "SELECT f.duration
                     FROM film f
                     WHERE id_film = :id";
        

        $sqlFilms = "SELECT f.id_film,  f.title, DATE_FORMAT(f.release_date, '%Y') AS date, f.picture
            FROM film f
            ORDER BY YEAR(f.release_date) DESC, MONTH(f.release_date) DESC, DAY(f.release_date) DESC";

        $params = [
            'id' => $id,
        ];


        $movieDetail = $dao->executerRequete($sql, $params);
        // instancier une variable avec la requete 
        $dureeFilmObject = $dao->executerRequete($sqlDuree, $params);

        $time = $this->durationMovie($dureeFilmObject);
    
        $films= $dao->executerRequete($sqlFilms);
        // $filmDirector = $dao->executerRequete($sql2, $params);
        
        // $mainActors = $dao->executerRequete($sql3, $params);
        
      
        require "views/movie/listFilms.php"; 
        
    }

    public function deleteMovie($id) {

        $dao = new DAO();
        
        if (isset($_POST['submit'])) {
            $id = filter_input(INPUT_POST, 'id_film', FILTER_VALIDATE_INT);
        
            $sql = "DELETE FROM film WHERE id_film = :id_film";

            $params = [':id_film' => $id];

            $dao->executerRequete($sql, $params);
    
            
            header("Location: index.php?action=listFilms");
            exit();
        }
       
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

    public function addCastingForm(){


        $dao = new DAO();
        // SQL query to select actor details
        $sqlActors = "SELECT a.id_actor, CONCAT(p.first_name,' ',p.last_name) AS actor, p.last_name, p.picture
                FROM person p INNER JOIN actor a
                ON p.id_person = a.person_id";
        // execute SQL query
        $actors = $dao->executerRequete($sqlActors);


        $sqlRoles = "SELECT * FROM role r
        ORDER BY r.role_name";


        $roles = $dao->executerRequete($sqlRoles);


        $sqlFilms = "SELECT f.title, f.id_film FROM film f
                    ORDER BY f.title";
       
        $films = $dao->executerRequete($sqlFilms);
       
        require "views/movie/addCastingForm.php";
    }
   


   
    public function addCasting(){


        $dao = new DAO();
   
        if (isset($_POST['submit'])) {
            // Retrieve data from the form submission
            $actor_id = filter_input(INPUT_POST, 'actor_id', FILTER_VALIDATE_INT);
            $role_id = filter_input(INPUT_POST, 'role_id', FILTER_VALIDATE_INT);
            $film_id = filter_input(INPUT_POST, 'film_id', FILTER_VALIDATE_INT); // Retrieve film_id
   
            // Insert casting information into the casting table
            $sqlCasting = "INSERT INTO casting (film_id, actor_id, role_id)
                           VALUES (:film_id, :actor_id, :role_id)";
           
            $paramsCasting = [
                ':film_id' => $film_id,
                ':actor_id' => $actor_id,
                ':role_id' => $role_id,
            ];
   
            $dao->executerRequete($sqlCasting, $paramsCasting);
   
            // Redirect back to the movie's casting page
            header("Location: index.php?action=showCasting&id=" . $film_id);
            exit();
        }
   
     
    }

    // public function updateCastingForm($id){
    //     $dao = new DAO();

    //     $sqlFilmDao = 'SELECT *FROM film WHERE id_film = :id';
        
    //     $param = [':id'=>$id];
        
    //     $sqlFilm = $dao->executerRequete($sqlFilmDao,$param);

    //     $sqlActors = "SELECT a.id_actor, CONCAT(p.first_name,' ',p.last_name) AS actor, p.last_name, p.picture
    //     FROM person p INNER JOIN actor a
    //     ON p.id_person = a.person_id";
    //     // execute SQL query
    //     $actors = $dao->executerRequete($sqlActors);


    //     $sqlRoles = "SELECT * FROM role r
    //     ORDER BY r.role_name";


    //     $roles = $dao->executerRequete($sqlRoles);


    //     require "views/movie/updateCastingForm.php";
    // }

    // public function updateCasting($id){

    //     $dao = new DAO();

    
    //     if (isset($_POST['submit'])) {
    //         // Retrieve data from the form submission
    //         $actor_id = filter_input(INPUT_POST, 'actor_id', FILTER_VALIDATE_INT);
    //         $role_id = filter_input(INPUT_POST, 'role_id', FILTER_VALIDATE_INT);
            
    //         $sqlUpdateCasting = "UPDATE casting
    //                             SET actor_id = :actor_id,
    //                                 role_id = :role_id
    //                             WHERE film_id = :film_id";

    //         $paramsUpdateCasting = [
    //             ':actor_id' => $actor_id,
    //             ':role_id' => $role_id,
    //             ':film_id'=> $id
    //         ];

    //         $dao->executerRequete($sqlUpdateCasting,$paramsUpdateCasting);
        
    //     }
    // }
    

    
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

        }else{ 

            return  $hours. "h". $minute;

        // }else{

        //     return  $hours. " heures et ". $minute. " minutes." ;

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
            $age_min = filter_input(INPUT_POST,"age_min",FILTER_VALIDATE_INT);

            $picture = '';
            $banner = '';
            $title_picture = '';
            
            // Function to process image upload
            function processImageUpload($fieldName) {
                if(isset($_FILES[$fieldName]) && $_FILES[$fieldName]['error'] == 0) {
                    $allowed = ["jpg" => "image/jpg", "jpeg" => "image/jpeg", "png" => "image/png"];
                    $filename = $_FILES[$fieldName]['name'];
                    $filetype = $_FILES[$fieldName]['type'];
                    $filesize = $_FILES[$fieldName]['size'];
                    $extension = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
                    $newFilename = md5($filename) . "." . $extension;
            
                    if(!array_key_exists($extension, $allowed)) die("Erreur : extension non autorisée.");
                    $maxsize = 2 * 1024 * 1024;
                    if($filesize > $maxsize) die("Erreur : taille de fichier trop lourde.");
            
                    if(!file_exists("public/images/" . $newFilename)) {
                        move_uploaded_file($_FILES[$fieldName]['tmp_name'], "public/images/" . $newFilename);
                    } else {
                        echo $_FILES[$fieldName]['name'] . " existe déjà.";
                    }
                    return $newFilename;
                }
                return null;
            }
            
            // Process 'picture'
            $picture = processImageUpload('picture');
            
            // Process 'banner'
            $banner = processImageUpload('banner');
            
            // Process 'title_picture'
            $title_picture = processImageUpload('title_picture');
            
           
            
            
            $sqlMovie = "INSERT INTO film (title,duration,synopsis,release_date,director_id, picture, banner, title_picture, age_min)
                        VALUES (:title,:duration,:synopsis,:release_date,:director_id, :picture, :banner, :title_picture, :age_min)";

            $paramsMovie = [
                ':title' => $title,
                ':duration' => $duration,
                ':synopsis' => $synopsis,
                ':release_date' => $release_date,
                ':director_id'=> $director_id,
                ':picture' => $picture,
                ':banner' => $banner,
                ':title_picture'=> $title_picture,
                ':age_min'=> $age_min
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

        public function updateMovieForm($id){
            $dao = new DAO();

            $sqlMovieDao = 'SELECT *FROM film WHERE id_film = :id';
            $param = [':id'=>$id];
            $sqlMovie = $dao->executerRequete($sqlMovieDao,$param);

            $movie = $sqlMovie->fetch();

            $sqlDirector = "SELECT CONCAT(p.first_name,' ',p.last_name) AS director, d.id_director
                            FROM person p INNER JOIN director d
                            ON p.id_person = d.person_id";
            
            $sqlGenre = "SELECT g.genre_name, g.id_genre
                         FROM genre g";
                                        
                  
            $directors = $dao->executerRequete($sqlDirector);
    
            $genres = $dao->executerRequete($sqlGenre);
            
    
          
            require "views/movie/updateMovieForm.php";
    
            
        } 

    

    public function updateMovie($id){ 

        $dao = new DAO();

        $sqlMovieDao = 'SELECT * FROM film WHERE id_film =:id';
        $param = [':id' => $id];
        $sqlMovie = $dao->executerRequete($sqlMovieDao,$param);
        
        $movie = $sqlMovie->fetch();
                                    

        if(isset($_POST['submit'])){
        
            $title = filter_input(INPUT_POST,"title",FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $duration = filter_input(INPUT_POST,"duration",FILTER_VALIDATE_INT);
            $synopsis = filter_input(INPUT_POST,"synopsis",FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $release_date = filter_input(INPUT_POST,"release_date",FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $director_id = filter_input(INPUT_POST,"id_director",FILTER_VALIDATE_INT);
            $genre_id = filter_input(INPUT_POST,"genre_id",FILTER_VALIDATE_INT);
            $age_min = filter_input(INPUT_POST,"age_min",FILTER_VALIDATE_INT);
            
            $picture = $movie['picture'];
            $banner = $movie['banner'];
            $title_picture = $movie['title_picture'];
            
            // Function to process image upload
            function processImageUpload($fieldName) {
                if(isset($_FILES[$fieldName]) && $_FILES[$fieldName]['error'] == 0) {
                    $allowed = ["jpg" => "image/jpg", "jpeg" => "image/jpeg", "png" => "image/png"];
                    $filename = $_FILES[$fieldName]['name'];
                    $filetype = $_FILES[$fieldName]['type'];
                    $filesize = $_FILES[$fieldName]['size'];
                    $extension = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
                    $newFilename = md5($filename) . "." . $extension;
            
                    if(!array_key_exists($extension, $allowed)) die("Erreur : extension non autorisée.");
                    $maxsize = 2 * 1024 * 1024;
                    if($filesize > $maxsize) die("Erreur : taille de fichier trop lourde.");
            
                    if(!file_exists("public/images/" . $newFilename)) {
                        move_uploaded_file($_FILES[$fieldName]['tmp_name'], "public/images/" . $newFilename);
                    } else {
                        echo $_FILES[$fieldName]['name'] . " existe déjà.";
                    }
                    return $newFilename;
                }
                return null;
            }
            
            // Process 'picture'
            $picture = processImageUpload('picture');
            
            // Process 'banner'
            $banner = processImageUpload('banner');
            
            // Process 'title_picture'
            $title_picture = processImageUpload('title_picture');
            
           
            
            $sqlUpdateMovie = "UPDATE film
                        SET title = :title,
                            duration = :duration,
                            synopsis = :synopsis,
                            release_date = :release_date,
                            director_id = :director_id,
                            picture = :picture,
                            banner = :banner,
                            title_picture = :title_picture,
                            age_min = :age_min
                        WHERE id_film = :id_film";

            $paramsUpdateMovie = [
                ':title' => $title,
                ':duration' => $duration,
                ':synopsis' => $synopsis,
                ':release_date' => $release_date,
                ':director_id'=> $director_id,
                ':picture' => $picture,
                ':banner' => $banner,
                ':title_picture' => $title_picture,
                ':age_min' => $age_min,
                ':id_film' => $id
            ];
            // var_dump($paramsMovie);die();
            // var_dump($title,$duration,$synopsis,$release_date,$director_id, $genre_id); die();

            $dao->executerRequete($sqlUpdateMovie, $paramsUpdateMovie);
            // var_dump($sqlMovie); die();

            // update film_genre
            
            $sqlUpdateFilmGenre = "UPDATE film_genre 
                            SET genre_id = :genre_id
                            WHERE film_id = :film_id";
                            
            $paramsUpdateFilmGenre = [
                ':genre_id' => $genre_id, 
                ':film_id' => $id,
            ];

            $dao->executerRequete($sqlUpdateFilmGenre, $paramsUpdateFilmGenre);

            // var_dump($genre_id); die();
           
            header("Location: index.php?action=listFilms");
            exit();
    
        }

    }

    // public function deleteMovie() {

    //     if (isset($_POST['submit'])) {
    //         $id_film = filter_input(INPUT_POST, 'id_film', FILTER_VALIDATE_INT);
    
    //         if ($id_film) {
    //             $dao = new DAO();
                
    //             $sqlDeleteFilmGenre = "DELETE FROM film_genre WHERE film_id = :id_film";
    //             $paramsDeleteFilmGenre = [':id_film' => $id_film];
    //             $dao->executerRequete($sqlDeleteFilmGenre, $paramsDeleteFilmGenre); 

    //             // Delete the movie record from the database
    //             $sqlDeleteMovie = "DELETE FROM film WHERE id_film = :id_film";
    //             $paramsDeleteMovie = [':id_film' => $id_film];
    //             $dao->executerRequete($sqlDeleteMovie, $paramsDeleteMovie);
    
    //             // Redirect to the movie list page
    //             header("Location: index.php?action=listFilms");
    //             exit();
    //         }
    //     }
    // }
    

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
