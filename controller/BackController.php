<?php

namespace keymener\myblog\controller;

use keymener\myblog\core\Authentication;
use keymener\myblog\core\Csrf;
use keymener\myblog\core\TwigLaunch;
use keymener\myblog\entity\User;
use keymener\myblog\model\UserManager;

/**
 * this is where the admin part is begining
 *
 * @author keymener
 */
class BackController
{

    private $twig;
    private $auth;
    private $userManager;

    public function __construct(TwigLaunch $twig, Authentication $auth, UserManager $userManager)
    {
        $this->twig = $twig;
        $this->auth = $auth;

        $this->userManager = $userManager;
    }

//
    /**
     * home page of backend
     */
    public function home()
    {
        $twig = $this->twig->twigLoad();
        echo $twig->render('backend/home.twig', array(
            'message' => false));
    }

    /**
     * logout
     */
    public function logout()
    {
        $this->auth->logout();
        $twig = $this->twig->twigLoad();

        header('Location:/auth/logme');
    }

    /**
     * comment managment page
     */
    public function comments()
    {

        $twig = $this->twig->twigLoad();
        echo $twig->render('backend/home.twig', array('message' => false));
    }

    /**
     * user managment page
     */
    public function users()
    {

        $users = $this->userManager->getAllUsers();

        $twig = $this->twig->twigLoad();
        echo $twig->render('backend/user.twig', array('users' => $users,));
    }

}
