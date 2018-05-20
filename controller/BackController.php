<?php

namespace keymener\myblog\controller;

use keymener\myblog\core\Authentication;
use keymener\myblog\core\Factory;
use keymener\myblog\core\TwigLaunch;
use keymener\myblog\model\PostManager;
use keymener\myblog\model\UserManager;

/**
 * Description of AdminController
 *
 * @author Keigo Matsunaga <keigo.matsunaga@gmail.com>
 */
class BackController
{

    /**
     * login page
     */
    public function login()
    {
        if (isset($_POST['username']) and isset($_POST['password'])) {
            $auth = new Authentication($_POST['username'], $_POST['password']);

            if ($auth->checkPassword()) {
                $this->home();
            } else {
                $twig = TwigLaunch::twigLoad();
                echo $twig->render('backend/login.twig', array(
                    'message' => true
                ));
            }
        }
    }

    /**
     * home page of backend
     */
    public function home()
    {

        if (isset($_SESSION['userId'])) {
            $twig = TwigLaunch::twigLoad();
            echo $twig->render('backend/home.twig', array('message' => false));
        } else {
            $twig = TwigLaunch::twigLoad();
            echo $twig->render('backend/login.twig', array('message' => false));
        }
    }

    /**
     * logout
     */
    public function logout()
    {
        session_destroy();
        $twig = TwigLaunch::twigLoad();
        echo $twig->render('backend/login.twig', array('p' => null));
    }



    /**
     * comment managment page
     */
    public function comments()
    {
        if (isset($_SESSION['userId'])) {
            $twig = TwigLaunch::twigLoad();
            echo $twig->render('backend/home.twig', array('message' => false));
        } else {
            $twig = TwigLaunch::twigLoad();
            echo $twig->render('backend/login.twig', array('message' => false));
        }
    }

    /**
     * user managment page
     */
    public function users()
    {
        if (isset($_SESSION['userId'])) {
            $factory = new Factory;
            $manager = $factory->createManager('user');
            
            $users = $manager->getAllUsers();

            $twig = TwigLaunch::twigLoad();
            echo $twig->render('backend/user.twig', array('users' => $users,));
        } else {
            $twig = TwigLaunch::twigLoad();
            echo $twig->render('backend/login.twig', array('message' => false));
        }
    }

}
