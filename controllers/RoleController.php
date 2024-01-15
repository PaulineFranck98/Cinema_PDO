<?php

class RoleController{

    public function addUpdateRoleForm(){

        $role = [];
        if (isset($_GET['id'])){
            $id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
            if ($id !==false){
                $dao = new DAO();
                $sql = "SELECT * 
                        FROM role 
                        WHERE id_role = :id";
                $params = [':id' =>$id];
                $result = $dao->executerRequete($sql,$params);
                $role = $result->fetch(PDO::FETCH_ASSOC);
            }
        }
        require "views/role/addUpdateRoleForm.php";
    }

    public function addUpdateRole(){

        if(isset($_POST['submit'])){
            //assainissement et validations des données du formulaire  
            $id_role = filter_input(INPUT_POST, 'id_role', FILTER_VALIDATE_INT);
            $role_name = filter_input(INPUT_POST, 'role_name', FILTER_SANITIZE_FULL_SPECIAL_CHARS);


            // Enregistrement du genre en base de données
            $dao = new DAO();
            
            if ($id_role !== false) {
                // Mise à jour
                $sql = "UPDATE role SET role_name = :role_name WHERE id_role = :id_role";
                $params = [':role_name' => $role_name, ':id_role' => $id_role];
            } else {
                // Ajout
                $sql = "INSERT INTO role (role_name) VALUES (:role_name)";
                $params = [':role_name' => $role_name];
            }

            $dao->executerRequete($sql, $params);

            header("Location: index.php?action=homePage");
            exit();
        }
    }
    
    
    public function deleteRole() {

        if (isset($_POST['submit'])) {

            $id_role = filter_input(INPUT_POST, 'id_role', FILTER_VALIDATE_INT);

            if ($id_role !== false) {

                $dao = new DAO();

                $sql = "DELETE FROM role WHERE id_role = :id_role";

                $params = [':id_role' => $id_role];

                $dao->executerRequete($sql, $params);

                
                header("Location: index.php?action=homePage");
                
                exit();
            }
        }
    }

}

