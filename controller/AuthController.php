<?php

namespace keymener\myblog\controller;

use keymener\myblog\core\Authentication;
use keymener\myblog\core\CheckInput;
use keymener\myblog\core\Csrf;
use keymener\myblog\core\TwigLaunch;
use keymener\myblog\entity\User;
use keymener\myblog\model\UserManager;

/**
 * authentication class
 *
 * @author Keigo Matsunaga <keigo.matsunaga@gmail.com>
 */
class AuthController
{

    private $twig;
    private $auth;
    private $user;
    private $userManager;
    private $csrf;
  

    public function __construct(TwigLaunch $twig, Authentication $auth, User $user, UserManager $userManager, Csrf $csrf)
    {
        $this->twig = $twig;
        $this->auth = $auth;
        $this->user = $user;
        $this->userManager = $userManager;
        $this->csrf = $csrf;
       
    }

    public function logMe($message = null)
    {

        //generate token csrf
        $token = $this->csrf->sessionRandom(5);

        $twig = $this->twig->twigLoad();
        echo $twig->render('backend/login.twig', array(
            'message' => $message,
            'token' => $token
        ));
    }

    public function login()
    {
        if (isset($_POST['username'], $_POST['password'], $_SESSION['token'], $_POST['token']) && $this->userManager->userExists($_POST['username'])) {

     
            if ($_SESSION['token'] == $_POST['token']) {

                $pwd = $_POST['password'];
                $login = $_POST['username'];

                // get all info from user
                $dataUser = $this->userManager->getUser($login);

                // hydrate the instance user with all info
                $this->user->hydrate($dataUser);


                //compare password
                if ($this->auth->checkPassword($pwd, $this->user->getPassword())) {
                    $_SESSION['userId'] = $this->user->getId();
                    $_SESSION['username'] = $this->user->getFirstname();
                    //generate token csrf


                    header('Location:/back/home');
                } else {
                    $message = 'error';
                    $this->logMe($message);
                }
            } else {
                header('Location: /error/error/500');
            }
        } else {
            $message = 'error';
            $this->logMe($message);
        }
    }

}
