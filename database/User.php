<?php


namespace WebApp2\Database;

class User
{

    public function addUser($fname, $lname, $username, $email, $password, $role, $db) {

        $newPassword = password_hash($password, PASSWORD_DEFAULT);

        $sql = "INSERT INTO users (firstname, lastname, username, password, email, user_role_id)
                VALUES (:firstname, :lastname, :username, :password, :email, :role)";
        $pst = $db->prepare($sql);

        $pst->bindParam(":firstname", $fname);
        $pst->bindParam(":lastname", $lname);
        $pst->bindParam(":username", $username);
        $pst->bindParam(":password", $newPassword);
        $pst->bindParam(":role", $role);
        $pst->bindParam(":email", $email);
        $count = $pst->execute();
        return $count;
    }

    public function deleteUser($id, $db){

        $sql = "DELETE FROM users WHERE id = :id";
        $pst = $db->prepare($sql);
        $pst->bindParam(':id', $id);
        $count = $pst->execute();
        return $count;

    }

    public function findUserInfo ($db, $id){
        $sql = "SELECT users.id as id, users.firstname as firstname, users.lastname as lastname, users.username as username, users.password as password, users.email as
    email, user_roles.type as role FROM users inner join user_roles on users.user_role_id = user_roles.id where users.id = :id";
        $pst = $db->prepare($sql);
        //var_dump($id);
        $pst->bindParam(':id', $id);
        $count = $pst->execute();
        $result = $pst->fetch(\PDO::FETCH_OBJ);
        return $result;

    }

    public function isUserExists($db, $username, $password)
    {
        $sql = "SELECT * from users where username = :username";
        $pst = $db->prepare($sql);

        $pst->bindParam(':username', $username);
        $pst->execute();
        $results = $pst->fetch(\PDO::FETCH_OBJ);
        if ($results) {

//            var_dump($results);
            if (password_verify($password, $results->password)) {

                return true;

            }
        }
        return false;
    }

    public function findUser($db, $username, $password)
    {
        $sql = "SELECT * from users where username = :username";
        $pst = $db->prepare($sql);

        $pst->bindParam(':username', $username);
        if ($pst->execute()) {
            $results = $pst->fetch(\PDO::FETCH_OBJ);
//            var_dump($results);
            if (password_verify($password, $results->password)) {

                return $results;

            }
        }
        return null;
    }

    public function getUserRoles($dbcon) {
        $sql = "SELECT * FROM user_roles";
        $pdostm = $dbcon->prepare($sql);
        $pdostm->execute();
        $days = $pdostm->fetchAll(\PDO::FETCH_OBJ);
        return $days;
    }

}
