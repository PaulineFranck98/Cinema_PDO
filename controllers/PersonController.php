<?php
require_once "bdd/DAO.php";

class PersonController{

    public function findAllActors(){
        $dao = new DAO();

        $sql = "SELECT a.id_actor, CONCAT(p.first_name,' ',p.last_name) AS actor, p.last_name, p.picture
                FROM person p INNER JOIN actor a
                ON p.id_person = a.person_id";
        $actors = $dao->executerRequete($sql);

        require "views/actor/listActors.php";

    }


    public function findActorById($id){

        $dao = new DAO();

        $sql = "SELECT CONCAT(p.first_name,' ',p.last_name) AS actor, p.picture AS actor_picture,  DATE_FORMAT(p.birth_date, '%d/%m/%Y') AS birth_date , p.person_gender
                FROM actor a
                INNER JOIN person p
                ON p.id_person = a.person_id
                WHERE id_actor = :id";

        $sql1 = "SELECT r.role_name, f.title, f.picture, f.id_film
                FROM casting c INNER JOIN film f
                ON c.film_id = f.id_film
                INNER JOIN actor a
                ON c.actor_id = a.id_actor
                INNER JOIN person p
                ON p.id_person = a.person_id
                INNER JOIN role r 
                ON c.role_id = r.id_role
                WHERE id_actor = :id";

        $params = [
            'id' => $id,
        ];

        $actorDetail = $dao->executerRequete($sql, $params);

        $actorFilms = $dao->executerRequete($sql1, $params);
        // var_dump($films); die();
        require "views/actor/actorDetail.php"; 

    }

    public function findAllDirectors(){
        $dao = new DAO();

        $sql = "SELECT CONCAT(p.first_name,' ',p.last_name) AS director, p.picture, d.id_director
                FROM person p INNER JOIN director d
                ON p.id_person = d.person_id";
        $directors = $dao->executerRequete($sql);

        require "views/director/listDirectors.php";
       

    }

    public function findDirectorById($id){
        $dao = new DAO();

        $sql="SELECT CONCAT(p.first_name,' ',p.last_name) AS director, p.picture,  DATE_FORMAT(p.birth_date,'%d/%m/%Y') AS birth_date , p.person_gender
              FROM director d
              INNER JOIN person p
              ON p.id_person = d.person_id
              WHERE id_director = :id";

        $sql1 ="SELECT f.id_film, f.title, f.picture
                FROM film f
                WHERE f.director_id = :id ";

        $params = [
            'id' => $id,
        ];


        $directorDetail = $dao->executerRequete($sql, $params);

        $directorFilms = $dao->executerRequete($sql1, $params);

        require "views/director/directorDetail.php";
    }

    public function addActorForm()
    {

        require "views/actor/addActorForm.php";
    }

    public function addActor(){

        die("You must ");
        $dao = new DAO();

        //

        // $sql="INSERT INTO person (first_name, last_name, person_gender, birth_date, picture)
        //       VALUES ('first_name','last_name','person_gender','birth_date','picture')";

        // $addActor = $dao->executerRequete($sql);

       
    }

}