<?php

class RoleController{

    public function findAllRoles(){

        $dao = new DAO();

        $sql = "SELECT * FROM role r
                ORDER BY r.role_name";
        $roles = $dao->executerRequete($sql);

        require "views/role/listRoles.php";

    }

    public function addRoleForm(){

        require "views/role/addRoleForm.php";

    }

    public function addRole(){

        $dao = new DAO();

        if(isset($_POST['submit'])){

            //sanitation and validation of form data   
            $id_role = filter_input(INPUT_POST, 'id_role', FILTER_VALIDATE_INT);

            $role_name = filter_input(INPUT_POST, 'role_name', FILTER_SANITIZE_FULL_SPECIAL_CHARS);


            $sql = "INSERT INTO role (role_name) VALUES (:role_name)";
            $params = [':role_name' => $role_name];
          

            $dao->executerRequete($sql, $params);

            header("Location: index.php?action=listRoles");
            exit();
        }

    }

    public function updateRoleForm($id){

        $dao = new DAO();

        $sqlRoleDao = "SELECT * FROM role WHERE id_role = :id";

        $params = [':id' => $id];

        $sqlRole = $dao->executerRequete($sqlRoleDao,$params);

        $role = $sqlRole->fetch();

        require "views/role/updateRoleForm.php";
    }

    public function updateRole($id){

        $dao = new DAO();
        
        $sqlRoleDao = "SELECT * FROM role WHERE id_role = :id";

        $params = [':id' => $id];

        $sqlRole = $dao->executerRequete($sqlRoleDao,$params);

        $role = $sqlRole->fetch();
        

        if(isset($_POST['submit'])){

            //sanitation and validation of form data   
            $id_role = filter_input(INPUT_POST, 'id_role', FILTER_VALIDATE_INT);

            $role_name = filter_input(INPUT_POST, 'role_name', FILTER_SANITIZE_FULL_SPECIAL_CHARS);


            $sql = "UPDATE role SET role_name = :role_name WHERE id_role = :id_role";

            $params = [
                ':role_name' => $role_name, 
                ':id_role' => $id_role
            ];
          

            $dao->executerRequete($sql, $params);

            header("Location: index.php?action=listRoles");
            exit();
        }
    }
    

    
    public function deleteRole() {

        if (isset($_POST['submit'])) {

            $id_role = filter_input(INPUT_POST, 'id_role', FILTER_VALIDATE_INT);

            if ($id_role) {

                $dao = new DAO();

                $sql = "DELETE FROM role WHERE id_role = :id_role";

                $params = [':id_role' => $id_role];

                $dao->executerRequete($sql, $params);

                
                header("Location: index.php?action=listRoles");
                
                exit();
            }
        }
    }

}

