<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace keymener\myblog\model;

/**
 * Description of UserManager
 *
 * @author Keigo Matsunaga <keigo.matsunaga@gmail.com>
 */
class UserManager extends DbConnect
{

    public function __construct()
    {
        parent::dblaunch();
    }

    /**
     * Return an user object from the user table
     * @param type $login
     * @return \keymener\myblog\entity\User
     */
    public function getUser($login)
    {
        $req = $this->db->prepare('SELECT * FROM user WHERE login=:login');
        $req->bindValue(':login', $login, \PDO::PARAM_STR);
        $req->execute();
        $user = new \keymener\myblog\entity\User($req->fetch(\PDO::FETCH_ASSOC));
        $req->closeCursor();
        return $user;
    }

    public function getAllUsers()
    {
        $users = [];

        $req = $this->db->query('SELECT * FROM user');

        foreach ($req as $value) {

            $users[] = new \keymener\myblog\entity\User($value);
        }
        $req->closeCursor();
        return $users;
    }

    /**
     * Check if an user exists in the user table
     * @param \keymener\myblog\entity\User $user
     * @return boolean
     */
    public function userExists($login)
    {
        $req = $this->db->prepare('SELECT * FROM user WHERE login=:login');
        $req->bindValue(':login', $login, \PDO::PARAM_STR);
        $req->execute();

        if ($req->rowCount() == 1) {
            $user = new \keymener\myblog\entity\User($req->fetch(\PDO::FETCH_ASSOC));
            $req->closeCursor();
            return true;
        } else {
            return false;
        }
    }

}
