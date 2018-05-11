<?php

namespace keymener\myblog\controller;

use keymener\myblog\core\Authentication;
use keymener\myblog\core\TwigLaunch;
use keymener\myblog\model\UserManager;

/**
 * Description of AdminController
 *
 * @author Keigo Matsunaga <keigo.matsunaga@gmail.com>
 */
class BackController
{

    public function login()
    {
        if (isset($_POST['username']) AND isset($_POST['password'])) {

            $auth = new Authentication($_POST['username'], $_POST['password']);

            if ($auth->checkPassword()) {

                $this->home();
            } else {
                $twig = TwigLaunch::twigLoad();
                echo $twig->render('backend/login.twig', array('message' => true));
            }
        }
    }

    public function home()
    {

        if (isset($_SESSION['auth'])) {
            $twig = TwigLaunch::twigLoad();
            echo $twig->render('backend/home.twig', array('message' => false));
        } else {
            $twig = TwigLaunch::twigLoad();
            echo $twig->render('backend/login.twig', array('message' => false));
        }
    }

    public function logout()
    {
        session_destroy();
        $twig = TwigLaunch::twigLoad();
        echo $twig->render('backend/login.twig', array('p' => null));
    }

    public function posts()
    {
        if (isset($_SESSION['auth'])) {
            $twig = TwigLaunch::twigLoad();
            echo $twig->render('backend/home.twig', array('message' => false));
        } else {
            $twig = TwigLaunch::twigLoad();
            echo $twig->render('backend/login.twig', array('message' => false));
        }
    }

    public function comments()
    {
        if (isset($_SESSION['auth'])) {
            $twig = TwigLaunch::twigLoad();
            echo $twig->render('backend/home.twig', array('message' => false));
        } else {
            $twig = TwigLaunch::twigLoad();
            echo $twig->render('backend/login.twig', array('message' => false));
        }
    }

    public function userManager()
    {
        if (isset($_SESSION['auth'])) {
            
            $manager = new UserManager();
            $users = $manager->getAllUsers();

            $twig = TwigLaunch::twigLoad();
            echo $twig->render('backend/user.twig', array('users' => $users));
        } else {
            $twig = TwigLaunch::twigLoad();
            echo $twig->render('backend/login.twig', array('message' => false));
        }
    }

}
