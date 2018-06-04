<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace keymener\myblog\model;

use keymener\myblog\entity\User;
use PDO;

/**
 * Description of UserManager
 *
 * @author Keigo Matsunaga <keigo.matsunaga@gmail.com>
 */
class UserManager
{

    private $db;


    public function __construct(Database $db)
    {
        $this->db = $db;
       
    }

    /**
     * Return an user object from the user table
     * @param type $login
     * @return User
     */
    public function getUser($login)
    {
        $req = $this->db->dbLaunch()->prepare('SELECT * FROM user WHERE login=:login');
        $req->bindValue(':login', $login, PDO::PARAM_STR);
        $req->execute();
        $result = $req->fetch(PDO::FETCH_ASSOC);
        $req->closeCursor();
        return $result;
    }

    public function getUserById($id)
    {
        $req = $this->db->dbLaunch()->prepare('SELECT * FROM user WHERE id=:id');
        $req->bindValue(':id', $id, PDO::PARAM_STR);
        $req->execute();
        $result = $req->fetch(PDO::FETCH_ASSOC);
        $req->closeCursor();
        return $result;
    }

    public function getAllUsers(): array
    {

        $req = $this->db->dbLaunch()->query('SELECT * FROM user');
        $users = $req->fetchall(PDO::FETCH_ASSOC);

        $req->closeCursor();
        return $users;
    }

    /**
     * Check if an user exists in the user table
     * @param User $user
     * @return boolean
     */
    public function userExists($login): bool
    {
        $db = $this->db->dbLaunch();
        $req = $db->prepare('SELECT * FROM user WHERE login=:login');
        $req->bindValue(':login', $login, PDO::PARAM_STR);
        $req->execute();

        if ($req->rowCount() == 1) {
            return true;
        } else {
            return false;
        }
    }

    public function deleteUser($id)
    {
        $req = $this->db->dbLaunch()->prepare('DELETE FROM user WHERE id=:id');
        $req->bindValue(':id', $id, PDO::PARAM_INT);
        $req->execute();
        $req->closeCursor();
    }

    public function addUser(User $user)
    {

        $req = $this->db->dbLaunch()->prepare('INSERT INTO user 
            ( lastname, firstname, login, password, email)
            VALUES
            (:lastname, :firstname, :login, :password, :email)
           ');
        $req->bindValue(':firstname', $user->getFirstname(), PDO::PARAM_STR);
        $req->bindValue(':lastname', $user->getLastname(), PDO::PARAM_STR);
        $req->bindValue(':login', $user->getLogin(), PDO::PARAM_STR);
        $req->bindValue(':email', $user->getEmail(), PDO::PARAM_STR);
        $req->bindValue(':password', $user->getPassword(), PDO::PARAM_STR);
        $req->execute();
        $req->closeCursor();
    }

    public function updateUser(User $user)
    {
        $req = $this->db->dbLaunch()->prepare('UPDATE user set '
                . 'firstname = :firstname, lastname = :lastname,'
                . ' login = :login, email = :email
                    WHERE 
                    id = :id');
        $req->bindValue(':id', $user->getId(), PDO::PARAM_INT);
        $req->bindValue(':firstname', $user->getFirstname(), PDO::PARAM_STR);
        $req->bindValue(':lastname', $user->getLastname(), PDO::PARAM_STR);
        $req->bindValue(':login', $user->getLogin(), PDO::PARAM_STR);
        $req->bindValue(':email', $user->getEmail(), PDO::PARAM_STR);


        $req->execute();
        $req->closeCursor();
    }

    public function updatePassword(User $user)
    {
        $req = $this->db->dbLaunch()->prepare('UPDATE user set password = :password
                    WHERE 
                    id = :id');
        $req->bindValue(':id', $user->getId(), PDO::PARAM_INT);
        $req->bindValue(':password', $user->getPassword(), PDO::PARAM_STR);

        $req->execute();
        $req->closeCursor();
    }
}
