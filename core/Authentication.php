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

    private $userManager;

    public function __construct(UserManager $userManager)
    {
        $this->userManager = $userManager;
    }

    /**
     * Check if the typed password is ok
     * @param type $username
     * @param type $password
     * @return boolean
     */
    public function checkPassword($username = null, $password = null)
    {
//        // check if the user exists in database
//        if ($this->userManager->userExists($username)) {
//            $user = $this->userManager->getUser(username);
//
//            if (password_verify($password, $user->getPassword())) { {
//                    $_SESSION['userId'] = $user->getId();
//                    $_SESSION['username'] = $user->getFirstname();
//                }
//
//                return true;
//            }
//        }
        
        echo 'toto';
    }

    public function encrypt($password)
    {
        $encryptedPassword = password_hash($password, PASSWORD_DEFAULT);
        return $encryptedPassword;
    }

    public function logout()
    {
        session_destroy();
    }

}
