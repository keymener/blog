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

    private $twig;
    private $auth;
   

    public function __construct(TwigLaunch $twig, Authentication $auth)
    {
        $this->twig = $twig;
        $this->auth = $auth;
    }

    /**
     * login page
     */
    public function login()
    {
//        if (isset($_POST['username']) and isset($_POST['password'])) {
//
////            $auth = $this->auth($_POST['username'], $_POST['password']);
//
//            if ($auth->checkPassword()) {
//                $this->home();
//            } else {
//                $twig = $this->twig->twigLoad();
//                echo $twig->render('backend/login.twig', array(
//                    'message' => true
//                ));
//            }
//        }
    }

//
    /**
     * home page of backend
     */
    public function home()
    {

        if (isset($_SESSION['userId'])) {

            $twig = $this->twig->twigLoad();
            echo $twig->render('backend/home.twig', array('message' => false));
        } else {
            $twig = $this->twig->twigLoad();
            echo $twig->render('backend/login.twig', array('message' => false));
        }
    }

//
//    /**
//     * logout
//     */
//    public function logout()
//    {
//        session_destroy();
//        $twig = $this->twig->twigLoad();
//        echo $twig->render('backend/login.twig', array('p' => null));
//    }
//
//    /**
//     * comment managment page
//     */
//    public function comments()
//    {
//        if (isset($_SESSION['userId'])) {
//            $twig = $this->twig->twigLoad();
//            echo $twig->render('backend/home.twig', array('message' => false));
//        } else {
//            $twig = $this->twig->twigLoad();
//            echo $twig->render('backend/login.twig', array('message' => false));
//        }
//    }
//
//    /**
//     * user managment page
//     */
//    public function users()
//    {
//        if (isset($_SESSION['userId'])) {
//
//            $users = $this->userManager->getAllUsers();
//
//            $twig = $this->twig->twigLoad();
//            echo $twig->render('backend/user.twig', array('users' => $users,));
//        } else {
//            $twig = $this->twig->twigLoad();
//            echo $twig->render('backend/login.twig', array('message' => false));
//        }
//    }
}
