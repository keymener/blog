<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace keymener\myblog\core;

use keymener\myblog\model\UserManager;

/**
 * Description of Authentication
 *
 * @author Keigo Matsunaga <keigo.matsunaga@gmail.com>
 */
class Authentication
{

    private $username;
    private $password;

    public function __construct($username, $password)
    {

        $this->username = $username;
        $this->password = $password;
    }

    /**
     * Check if the typed password is ok
     * @param type $username
     * @param type $password
     * @return boolean
     */
    public function checkPassword()
    {

        $manager = new UserManager;

        // check if the user exists in database
        if ($manager->userExists($this->username)) {
            $user = $manager->getUser($this->username);

            if (password_verify($this->password, $user->getPassword())) {
                session_start();
                return true;
            } else {
                echo 'login ou mot de passe incorrect';
            }
        } else {
            echo 'login ou mot de passe incorrect';
        }
    }

    public function logout()
    {
        
    }

}
