
<?php
// DAO (Data Access Object) is a design pattern that provides an abstract interface to a database.
// It allows for a single point of interaction between the application and the database, 
// and it can be used to centralize the database access logic.

class DAO{
    
    private $bdd;
  
    public function __construct(){

        // PDO (PHP Data Objects) is a database access layer providing a uniform method of access to multiple databases 
        // new PDO instance to connect to the MySQL database
        //DSN (Data Source Name) specifying the database type, host, database name, and charset.
        $this->bdd = new PDO('mysql:host=localhost;dbname=cinemasql;charset=utf8', 'root', ''); 
    }

    // Method to get the PDO database connection instance
    function getBDD(){

        return $this->bdd;
    }

    // Method to execute a SQL query.
    public function executerRequete($sql, $params = NULL){

        // If no parameters are provided
        if($params == NULL){
            // use the query() method for simple SQL execution
            $resultat = $this->bdd->query($sql);
        }else{
            // If parameters are provided, use prepare() method
            $resultat = $this->bdd->prepare($sql);

            $resultat->execute($params);
        }
        return $resultat; 
    }

    // Method to get the last inserted ID in the database.
    public function getLastInsertId(){
        // Returns the ID of the last inserted row
        return $this->bdd->lastInsertId();
    }

}