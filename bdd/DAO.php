<!-- définition de DAO (d'abord def acronyme)-->
<!-- définition de PDO -->

<?php
// DAO permet de construire un objet pour me connecter grâce à PDO à ma base de données
class DAO{

    private $bdd;
    // fonction construct sert à donner une valeur à la propriété bdd, pour ce faire je crée l'instance PDO (class native) 
    public function __construct(){
        // demande host, puis nom base de données (dbname), charset, 'root' car pas nom d'utilisateur, et '' car pas de mdp
        $this->bdd = new PDO('mysql:host=localhost;dbname=cinemasql;charset=utf8', 'root', '');
    }

    function getBDD(){
        return $this->bdd;
    }
    // premier argument : requête que je veux exécuter (argument obligatoire) et les paramètres qui sont nuls de base 
    public function executerRequete($sql, $params = NULL){
        // si les paramètres sont nuls 
        if($params == NULL){
            // alors fait appel à la fonction query() --> native de php
            $resultat = $this->bdd->query($sql);
        }else{
            // si il y a des paramètres, alors fait appel à la fonction prepare()
            $resultat = $this->bdd->prepare($sql);
            $resultat->execute($params);
        }
        return $resultat; 
    }

}