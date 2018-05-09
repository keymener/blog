<?php

namespace keymener\myblog\controller;

use keymener\myblog\core\Authentication;
use keymener\myblog\core\TwigLaunch;

/**
 * Description of AdminController
 *
 * @author Keigo Matsunaga <keigo.matsunaga@gmail.com>
 */
class BackController
{

    public function login()
    {
        $twig = TwigLaunch::twigLoad();
        echo $twig->render('backend/login.twig', array('p' => null));
    }

    public function auth()
    {

        if (isset($_POST['username']) AND isset($_POST['password'])) {

            $auth = new Authentication($_POST['username'], $_POST['password']);

            if ($auth->checkPassword()) {
                $twig = TwigLaunch::twigLoad();
                echo $twig->render('backend/home.twig', array('p' => null));
            }
        }
    }

    public function logout()
    {
        
        $twig = TwigLaunch::twigLoad();
        echo $twig->render('backend/login.twig', array('p' => null));
        
    }

}
