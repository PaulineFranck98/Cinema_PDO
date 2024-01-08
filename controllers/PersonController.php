<?php
require_once "bdd/DAO.php";

class PersonController{

    public function findAllActors(){
        $dao = new DAO();

        $sql = "SELECT p.id_person, p.first_name, p.last_name
                FROM person p INNER JOIN actor a
                ON p.id_person = a.person_id";
        $actors = $dao->executerRequete($sql);

        require "views/actor/listActors.php";

    }

    public function findAllDirectors(){
        $dao = new DAO();

        $sql = "SELECT p.first_name, p.last_name
                FROM person p INNER JOIN director d
                ON p.id_person = d.person_id";
        $directors = $dao->executerRequete($sql);

        require "views/director/listDirectors.php";

    }

}