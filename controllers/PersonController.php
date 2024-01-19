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

    public function deleteActor() {

        if (isset($_POST['submit'])) {
            $id_actor = filter_input(INPUT_POST, 'id_actor', FILTER_VALIDATE_INT);
    
            if ($id_actor) {
                $dao = new DAO();
    
                // Delete the actor record from the actor table
                $sqlDeleteActor = "DELETE FROM actor WHERE id_actor = :id_actor";
                $paramsDeleteActor = [':id_actor' => $id_actor];
                $dao->executerRequete($sqlDeleteActor, $paramsDeleteActor);
    
                // Redirect to the actor list page or any other desired location
                header("Location: index.php?action=listActors");
                exit();
            }
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


}
    