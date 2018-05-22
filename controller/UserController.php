<?php

namespace keymener\myblog\controller;

use keymener\myblog\core\Authentication;
use keymener\myblog\core\Factory;
use keymener\myblog\core\TwigLaunch;
use keymener\myblog\entity\User;
use keymener\myblog\model\UserManager;

/**
 * User controller
 *
 * @author keyme
 */
class UserController
{

    private $user;
    private $userManager;
    private $twig;
    private $auth;

    public function __construct(
    User $user, UserManager $userManager, TwigLaunch $twig, Authentication $auth)
    {
        $this->user = $user;
        $this->userManager = $userManager;
        $this->twig = $twig;
        $this->auth = $auth;
    }

    /**
     * delete usuer by its id
     * @param type $id
     */
    public function deleteUser($id)
    {
        if (isset($_SESSION['userId'])) {

            $this->userManager->deleteUser($id);
            header("Location: /back/users");
        } else {
            $twig = $this->twig->twigLoad();
            echo $twig->render('backend/login.twig', array('message' => false));
        }
    }

    public function addForm()
    {
        if (isset($_SESSION['userId'])) {
            $twig = $this->twig->twigLoad();
            echo $twig->render('backend/addForm.twig', array(
                'action' => '/user/adduser',
                'button' => 'add'
            ));
        } else {
            $twig = $this->twig->twigLoad();
            echo $twig->render('backend/login.twig', array('message' => false));
        }
    }

    /**
     * add a user
     */
    public function addUser()
    {

        if (isset($_POST, $_SESSION['userId'])) {

//checks if the login already exists
            if ($this->userManager->userExists($_POST['login'])) {
                $twig = $this->twig->twigLoad();
                echo $twig->render('backend/addForm.twig', array(
                    'alert' => 1,
                    'action' => '/user/adduser',
                    'button' => 'add'
                ));
            } else {
                $auth = $this->auth($_POST['login'], $_POST['password']);

                //encrypt the password from post variable
                $_POST['password'] = $auth->encrypt($_POST['password']);
                $user = $this->user($_POST);
                $this->userManager->addUser($user);

                header("Location: /back/users");
            }
        } else {
            $twig = $this->twig->twigLoad();
            echo $twig->render('backend/login.twig', array('message' => false));
        }
    }

    /**
     * Modify a user using its ID
     * @param type $id
     */
    public function modifyUser($id)
    {
        if (isset($_SESSION['userId'])) {
         
            $this->user($manager->getUserById($id));


            $twig = $this->twig->twigLoad();
            echo $twig->render('backend/addForm.twig', array(
                'user' => $user,
                'action' => '/user/updateuser',
                'button' => 'modify'
            ));
        } else {
            $twig = $this->twig->twigLoad();
            echo $twig->render('backend/login.twig', array('message' => false));
        }
    }

    /**
     * Update a user using POST method
     *
     */
    public function updateUser()
    {

        if (isset($_POST['id'], $_SESSION['userId'])) {
            $user = $this->user($_POST);

        
// check if the user changes the password
            if (empty($_POST['password'])) {
                //this will change all but not the password
                $this->userManager->updateUser($user);
            } else {
                // this will change all including password
                $this->userManager->updateUser($user);
                
                $this->user->setPassword($this->auth->encrypt($_POST['password']));
                $this->userManager->updatePassword($this->user);
            }

            header("Location: /back/users");
        }
    }

}
