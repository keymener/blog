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
        if(isset($_POST['username']) AND isset($_POST['password'])){
            
          var_dump($_POST);
            
        }else{
            echo 'pas de login';
        }
            
    }
}
