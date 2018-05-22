<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace keymener\myblog\core;

/**
 * Description of Authentication
 *
 * @author Keigo Matsunaga <keigo.matsunaga@gmail.com>
 */
class Authentication
{

    /**
     * compare to string
     * @param type $username
     * @param type $password
     * @return boolean
     */
    public function checkPassword($userPassword, $basePassword): bool
    {

        if (password_verify($userPassword, $basePassword)) {
        
            return true;
            
        } else {
            return false;
        }
    }

    /**
     * return encrypted password
     * @param string $password
     * @return string
     */
    public function encrypt(string $password) : string
    {
        $encryptedPassword = password_hash($password, PASSWORD_DEFAULT);
        return $encryptedPassword;
    }

    public function logout()
    {
        session_destroy();
    }

}
