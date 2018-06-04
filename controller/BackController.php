<?php

namespace keymener\myblog\controller;

use keymener\myblog\core\Authentication;
use keymener\myblog\core\TwigLaunch;
use keymener\myblog\entity\User;
use keymener\myblog\model\CommentManager;
use keymener\myblog\model\UserManager;

/**
 * Description of AdminController
 *
 * @author Keigo Matsunaga <keigo.matsunaga@gmail.com>
 */
class BackController
{

    private $twig;
    private $auth;
    private $user;
    private $userManager;
    private $commentManager;

    public function __construct(TwigLaunch $twig, Authentication $auth, User $user, UserManager $userManager, CommentManager $commentManager)
    {
        $this->twig = $twig;
        $this->auth = $auth;
        $this->user = $user;
        $this->userManager = $userManager;
        $this->commentManager = $commentManager;
    }

    /**
     * login page
     */
    public function login()
    {
        if (isset($_POST['username'], $_POST['password']) && $this->userManager->userExists($_POST['username'])) {

            $pwd = $_POST['password'];


            // get all info from user
            $dataUser = $this->userManager->getUser($_POST['username']);

            // hydrate the instance user with all info
            $this->user->hydrate($dataUser);


            //compare password
            if ($this->auth->checkPassword($pwd, $this->user->getPassword())) {
                $_SESSION['userId'] = $this->user->getId();
                $_SESSION['username'] = $this->user->getFirstname();

                $this->home();
            } else {
                $twig = $this->twig->twigLoad();
                echo $twig->render('backend/login.twig', array(
                    'message' => 'error'
                ));
            }
        } else {
            $twig = $this->twig->twigLoad();
            echo $twig->render('backend/login.twig', array(
                'message' => 'empty'
            ));
        }
    }

//
    /**
     * home page of backend
     */
    public function home()
    {



//            $countComments = $this->commentManager->countAllWaitComment();

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
        echo $twig->render('backend/login.twig', array('p' => null));
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
