<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace keymener\myblog\controller;

/**
 * Description of UserController
 *
 * @author keyme
 */
class UserController
{

    public function login()
    {
        $twig = \keymener\myblog\core\TwigLaunch::twigLoad();
        echo $twig->render('login.twig', array('p' => null));
    }

    public function checkPassword()
    {

//        var_dump(password_hash($_POST['password'], PASSWORD_DEFAULT));

        if (isset($_POST['username']) AND isset($_POST['password'])) {

            $manager = new \keymener\myblog\model\UserManager;
            
            // check if the user exists in database
            if ($manager->userExists($_POST['username'])) {
                $user = $manager->getUser($_POST['username']);

                if (password_verify($_POST['password'], $user->getPassword())) {

                    $twig = \keymener\myblog\core\TwigLaunch::twigLoad();
                    echo $twig->render('admin.twig', array('p' => null));
                } else {
                    echo 'login ou mot de passe incorrect';
                }
            }else{
                echo 'utilisateur inexistant';
            }
                
        } else {
            echo 'pas de login';
        }
    }

}
