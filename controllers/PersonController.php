<?php
require_once "bdd/DAO.php";

class PersonController{
    // Method to find all actors 
    public function findAllActors(){
        $dao = new DAO();
        // SQL query to select actor details
        $sql = "SELECT a.id_actor, CONCAT(p.first_name,' ',p.last_name) AS actor, p.last_name, p.picture
                FROM person p INNER JOIN actor a
                ON p.id_person = a.person_id";
        // execute SQL query 
        $actors = $dao->executerRequete($sql);

        require "views/actor/listActors.php";

    }

    // Method to find a specific actor by their ID
    public function findActorById($id){

        $dao = new DAO();

        // SQL query to select details of a specific actor
        $sql = "SELECT CONCAT(p.first_name,' ',p.last_name) AS actor, p.picture AS actor_picture,  DATE_FORMAT(p.birth_date, '%d/%m/%Y') AS birth_date , p.person_gender, a.id_actor, p.id_person, a.person_id
                FROM actor a
                INNER JOIN person p
                ON p.id_person = a.person_id
                WHERE id_actor = :id";

        // SQL queri to get films of a specific actor
        $sql1 = "SELECT r.role_name, f.title, f.picture, f.id_film, p.id_person
                FROM casting c INNER JOIN film f
                ON c.film_id = f.id_film
                INNER JOIN actor a
                ON c.actor_id = a.id_actor
                INNER JOIN person p
                ON p.id_person = a.person_id
                INNER JOIN role r 
                ON c.role_id = r.id_role
                WHERE id_actor = :id";

        //parameters for the SQL query 
        $params = [
            'id' => $id,
        ];

        //Execute the queries and store results
        $actorDetail = $dao->executerRequete($sql, $params);

        $actorFilms = $dao->executerRequete($sql1, $params);
        // var_dump($films); die();
        require "views/actor/actorDetail.php"; 

    }

    // Method to find all directors
    public function findAllDirectors(){
        $dao = new DAO();

        $sql = "SELECT CONCAT(p.first_name,' ',p.last_name) AS director, p.picture, d.id_director
                FROM person p INNER JOIN director d
                ON p.id_person = d.person_id";
        $directors = $dao->executerRequete($sql);

        require "views/director/listDirectors.php";
       

    }

    // Method to fin specific director by their id 
    public function findDirectorById($id){
        $dao = new DAO();

        // SQL query to select details of a specific director
        $sql="SELECT CONCAT(p.first_name,' ',p.last_name) AS director, p.picture,  DATE_FORMAT(p.birth_date,'%d/%m/%Y') AS birth_date , p.person_gender, d.id_director
              FROM director d
              INNER JOIN person p
              ON p.id_person = d.person_id
              WHERE id_director = :id";

        // SQL query to get films directed by the specific director
        $sql1 ="SELECT f.id_film, f.title, f.picture
                FROM film f
                WHERE f.director_id = :id ";


        // Parameters for the SQL query
        $params = [
            'id' => $id,
        ];

        // Execute the queries and store the results
        $directorDetail = $dao->executerRequete($sql, $params);

        $directorFilms = $dao->executerRequete($sql1, $params);

        require "views/director/directorDetail.php";
    }




    public function updateActorForm($id)
    {

        //on cherche l'acteur en fonction de son id en bdd et inner join person
        // fecth et on renvoie actor sur la vue
        $dao = new DAO();

        $sqlActorDao = 'SELECT * FROM actor a INNER JOIN person p on p.id_person = a.person_id WHERE id_actor = :id';

        $param = [':id'=>$id];

        $sqlActor =  $dao->executerRequete($sqlActorDao, $param);
        $actor = $sqlActor->fetch();

        require "views/actor/updateActorForm.php";
    }


    public function updateActor($id)
    {
        
        $dao = new DAO();

        $sqlActorDao = 'SELECT * FROM actor a INNER JOIN person p on p.id_person = a.person_id WHERE id_actor = :id';

        $param = [':id'=>$id];

        $sqlActor =  $dao->executerRequete($sqlActorDao, $param);
        $actor = $sqlActor->fetch();

        if(isset($_POST['submit'])){
            
            $id_person = $actor['person_id'];
            $first_name = filter_input(INPUT_POST, 'first_name', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $last_name = filter_input(INPUT_POST, 'last_name', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $person_gender = filter_input(INPUT_POST, 'person_gender', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    
            $picture = $actor['picture'];

            // var_dump($id, $first_name, $last_name, $person_gender, $id_person, $picture); die;
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

            $sqlPerson = "UPDATE person
            SET first_name = :first_name, 
                last_name = :last_name, 
                person_gender = :person_gender, 
                picture = :picture 
                WHERE id_person = :id_person";

            // $paramsPerson[':id_person'] = $id_person;
            $paramsPerson = [
                ':first_name'=> $first_name, 
                ':last_name'=> $last_name, 
                ':person_gender'=> $person_gender, 
                ':picture'=> $picture,
                ':id_person'=>$id_person
            ];


            $result= $dao->executerRequete($sqlPerson, $paramsPerson);
            // var_dump($result); die();
            header("Location: index.php?action=homePage");
            exit();

        }
    }
    public function updateDirectorForm($id)
    {

        $dao = new DAO();

        $sqlDirectorDao = 'SELECT * FROM director d INNER JOIN person p on p.id_person = d.person_id WHERE id_director = :id';

        $param = [':id'=>$id];

        $sqlDirector =  $dao->executerRequete($sqlDirectorDao, $param);
        $director = $sqlDirector->fetch();

        require "views/director/updateDirectorForm.php";
    }


    public function updateDirector($id)
    {
        if($id == ''){
            echo 'vide';
        }
        
        $dao = new DAO();

        $sqlDirectorDao = 'SELECT * FROM director d INNER JOIN person p on p.id_person = d.person_id WHERE id_director = :id';

        $param = [':id'=>$id];

        $sqlDirector =  $dao->executerRequete($sqlDirectorDao, $param);
        
        $director = $sqlDirector->fetch();

        if(isset($_POST['submit'])){
            
            $id_person = $director['person_id'];
            $first_name = filter_input(INPUT_POST, 'first_name', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $last_name = filter_input(INPUT_POST, 'last_name', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $person_gender = filter_input(INPUT_POST, 'person_gender', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    
            $picture = $director['picture'];

            // var_dump($id, $first_name, $last_name, $person_gender, $id_person, $picture); die;
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

            $sqlPerson = "UPDATE person
            SET first_name = :first_name, 
                last_name = :last_name, 
                person_gender = :person_gender, 
                picture = :picture 
                WHERE id_person = :id_person";

            // $paramsPerson[':id_person'] = $id_person;
            $paramsPerson = [
                ':first_name'=> $first_name, 
                ':last_name'=> $last_name, 
                ':person_gender'=> $person_gender, 
                ':picture'=> $picture,
                ':id_person'=>$id_person
            ];


            $result= $dao->executerRequete($sqlPerson, $paramsPerson);
            // var_dump($result); die();
            header("Location: index.php?action=homePage");
            exit();

        }
    }





    public function addActorForm(){
        
        require "views/actor/addActorForm.php";   
    }

    public function addActor(){

    $dao = new DAO();
   
  

        if(isset($_POST['submit'])){
            
            
            $first_name = filter_input(INPUT_POST, 'first_name', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $last_name = filter_input(INPUT_POST, 'last_name', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $person_gender = filter_input(INPUT_POST, 'person_gender', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    
            $picture = '';

            // var_dump($id, $first_name, $last_name, $person_gender, $id_person, $picture); die;
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

           // Insert the new actor into the database
           $sqlPerson = "INSERT INTO person (first_name, last_name, person_gender, picture) 
           VALUES (:first_name, :last_name, :person_gender, :picture)";

            $paramsPerson = [
                ':first_name' => $first_name,
                ':last_name' => $last_name,
                ':person_gender' => $person_gender,
                ':picture' => $picture
            ];

            $dao->executerRequete($sqlPerson, $paramsPerson);
        
            // Get the ID of the inserted person
            $person_id = $dao->getLastInsertId();
            
            // Insert data into the 'actor' table with the person_id
            $sqlActor = "INSERT INTO actor (person_id) 
                          VALUES (:person_id)";
            
            $paramsActor = [
                ':person_id' => $person_id
                // Add more parameters as needed
            ];
            
            $dao->executerRequete($sqlActor, $paramsActor);
            
            // Redirect to the desired page after inserting
            header("Location: index.php?action=homePage");
            exit();


        }
    }
    public function addDirectorForm(){
        
        require "views/director/addDirectorForm.php";   
    }

    public function addDirector(){

    $dao = new DAO();
   
  

        if(isset($_POST['submit'])){
            
            
            $first_name = filter_input(INPUT_POST, 'first_name', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $last_name = filter_input(INPUT_POST, 'last_name', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $person_gender = filter_input(INPUT_POST, 'person_gender', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    
            $picture = '';

            // var_dump($id, $first_name, $last_name, $person_gender, $id_person, $picture); die;
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

           // Insert the new person into the database
           $sqlPerson = "INSERT INTO person (first_name, last_name, person_gender, picture) 
           VALUES (:first_name, :last_name, :person_gender, :picture)";

            $paramsPerson = [
            ':first_name' => $first_name,
            ':last_name' => $last_name,
            ':person_gender' => $person_gender,
            ':picture' => $picture
            ];

            $dao->executerRequete($sqlPerson, $paramsPerson);
        
            // Get the ID of the inserted person
            $person_id = $dao->getLastInsertId();
            
            // Insert data into the 'director' table with the person_id
            $sqlDirector = "INSERT INTO director (person_id) 
                          VALUES (:person_id)";
            
            $paramsDirector = [
                ':person_id' => $person_id
                // Add more parameters as needed
            ];
            
            $dao->executerRequete( $sqlDirector, $paramsDirector);
            
            // Redirect to the desired page after inserting
            header("Location: index.php?action=homePage");
            exit();


        }
    }

    
    

    public function addUpdateDirectorForm(){

        // Initialize an array to store actor data
        $director = [];

        // Check if an actor ID is provided in the GET request
        if (isset($_GET['id'])) {

            // retrieve and validate the ID from GET request
            $id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
            
            // If a valid ID is provided
            if ($id) {

                $dao = new DAO();

                // SQL query to retrieve 'person' data related to the director
                $sqlPerson = "SELECT p.* FROM person p
                              INNER JOIN director d ON p.id_person = d.person_id
                              WHERE d.id_director = :id";

                 // Parameters for the SQL query
                $params = [
                    ':id'=>$id
                ];

                // Execute the query
                $resultPerson = $dao->executerRequete($sqlPerson, $params);

                // Fetch the result and store in array (PDO::FETCH_ASSOC  instructs the fetch() method to return the current row as an associative array)
                $director['person'] = $resultPerson->fetch(PDO::FETCH_ASSOC);


                // SQL query to retrieve 'director' data
                $sqlDirector = "SELECT * FROM director d WHERE id_director = :id";

                $params= [
                    ':id'=>$id
                ];

                // Execute the query
                $resultDirector = $dao->executerRequete($sqlDirector, $params);

                // Fetch the result and store in the 'director' array
                $director['director'] = $resultDirector->fetch(PDO::FETCH_ASSOC);
               
            }
        }
        
        require "views/director/addUpdateDirectorForm.php";
    }
    
    
    public function addUpdateDirector(){
        if(isset($_POST['submit'])){
            
            $id_person = filter_input(INPUT_POST,'id_person', FILTER_VALIDATE_INT);
            $id_director = filter_input(INPUT_POST,'id_director', FILTER_VALIDATE_INT);
            $first_name = filter_input(INPUT_POST, 'first_name', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $last_name = filter_input(INPUT_POST, 'last_name', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $person_gender = filter_input(INPUT_POST, 'person_gender', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    
        
    
            if(isset($_FILES['picture']) && $_FILES['picture']['error']==0){
                //définit les extensions autorisées
                $allowed = [
                    "jpg" => "image/jpg",
                    "jpeg" => "image/jpeg",
                    "png" => "image/png",
                ];
                // spécifie le nom original du fichier et le set dans la variable $filename
                $filename = $_FILES['picture']['name'];
                // spécifie le type MIME fichier --> (Multipurpose Internet Mail Extensions) est un standard permettant d'indiquer la nature et le format d'un document
                $filetype = $_FILES['picture']['type'];
                // spécifie la taille du fichier (en octets) et le set dans la variable $filesize
                $filesize = $_FILES['picture']['size'];
                
                // récupère/retourne l'extension du fichier : (filepath : chemin d'accès au fichier)
                $extension = strtolower(pathinfo($filename, PATHINFO_EXTENSION));

                // md5() retourne la chaîne (nom photo) sous la forme d'un nombre hexadécimal de 32 caractères
                // permet de créer un ID unique pour l'image téléchargée et ainsi éviter les failles d'upload
                $picture= md5($filename). ".". $extension;
        

                if(!array_key_exists($extension, $allowed)) die("Erreur : extension non autorisée");
                // vérifie la taille du fichier 2Mb max
                $maxsize = 2 * 1024 * 1024;
                if($filesize > $maxsize) die("Erreur : taille de fichier trop lourde");

                //vérifie le type MIME du fichier 
                if(in_array($filetype, $allowed)){
                    // vérifie si le fichier existe dans le répertoire upload avant de le télécharger 
                    if (file_exists("public/images/" . $picture)) {
                        echo $_FILES['picture']['name']. " existe déjà";
                    }else {
                        // enregistre le fichier téléchargé dans le répertoire "upload"
                        move_uploaded_file($_FILES['picture']['tmp_name'], "public/images/". $picture);
                        //$_FILES['photo']['tmp_name'] spécifie le nom temporaire, y compris le chemin complet qui est assigné au fichier une fois qu'il a été uploadé sur le serveur

                        echo "Votre fichier a été téléchargé avec succès!";
                    }
                }else {
                    echo "Erreur : problème de téléchargement du fichier";
                }
            }else {
                // spécifie le ode d'erreur ou d'état associé à l'upload du fichier, par exemple 0 s'il n'y a pas d'erreur
                echo "Erreur : " . $_FILES['picture']['error'];

            }   
    
            $dao = new DAO();
    
     
            if($id_person){
                // update person
                $sqlPerson = "UPDATE person 
                              SET first_name = :first_name, 
                                  last_name = :last_name, 
                                  person_gender = :person_gender, 
                                  picture = :picture 
                              WHERE id_person = :id_person";

                
                $paramsPerson = [
                    ':first_name'=> $first_name, 
                    ':last_name'=> $last_name, 
                    ':person_gender'=> $person_gender, 
                    ':picture'=> $picture,
                    ':id_person'=>$id_person
                    
                ];
    
    
                $dao->executerRequete($sqlPerson, $paramsPerson);

            }else {
                // insert new person
                $sqlPerson = "INSERT INTO person (first_name, last_name, person_gender, picture) 
                              VALUES (:first_name, :last_name, :person_gender, :picture)";
            
            $paramsPerson = [
                ':first_name'=> $first_name, 
                ':last_name'=> $last_name, 
                ':person_gender'=> $person_gender, 
                ':picture'=> $picture
               
                
            ];
                $dao->executerRequete($sqlPerson, $paramsPerson);

                $id_person = $dao->getLastInsertId();
            }   
                // check if director exists or insert new director
            if ($id_director) {
                    // director already exists, no need to update the director table
                 
            } else {
                    // insert into director
                    $sqlInsertDirector = "INSERT INTO director (person_id) 
                                       VALUES (:id_person)";
                    
                    $paramsInsertDirector = [
                        ':id_person' => $id_person
                        
                    ];
                
                    $dao->executerRequete($sqlInsertDirector, $paramsInsertDirector);
                
            }
           
            header("Location: index.php?action=homePage");
            exit();
        }
    }

}
    