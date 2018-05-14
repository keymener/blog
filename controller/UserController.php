<?php

namespace keymener\myblog\controller;

use keymener\myblog\core\Authentication;
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

    /**
     * delete usuer by its id
     * @param type $id
     */
    public function deleteUser($id)
    {
        if (isset($_SESSION['userId'])) {

            $manager = new UserManager;
            $manager->deleteUser($id);
            header("Location: /back/users");
        }
    }

    public function addForm()
    {
        if (isset($_SESSION['userId'])) {

            $twig = TwigLaunch::twigLoad();
            echo $twig->render('backend/addForm.twig', array(
                'action' => '/user/adduser',
                'button' => 'add'
            ));
        }
    }

    /**
     * add a user 
     */
    public function addUser()
    {

        if (isset($_POST, $_SESSION['userId'])) {

            $manager = new UserManager;

//checks if the login already exists
            if ($manager->userExists($_POST['login'])) {
                $twig = TwigLaunch::twigLoad();
                echo $twig->render('backend/addForm.twig', array(
                    'alert' => 1,
                    'action' => '/user/adduser',
                    'button' => 'add'
                ));
            } else {
                $auth = new Authentication($_POST['login'], $_POST['password']);

                //encrypt the password from post variable
                $_POST['password'] = $auth->encrypt($_POST['password']);
                $user = new User($_POST);
                $manager->addUser($user);

                header("Location: /back/users");
            }
        } else {
            $twig = TwigLaunch::twigLoad();
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
            $manager = new UserManager();
            $user = $manager->getUserById($id);


            $twig = TwigLaunch::twigLoad();
            echo $twig->render('backend/addForm.twig', array(
                'user' => $user,
                'action' => '/user/updateuser',
                'button' => 'modify'
            ));
        } else {
            $twig = TwigLaunch::twigLoad();
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

            $user = new User($_POST);

            $manager = new UserManager();
// check if the user changes the password
            if (empty($_POST['password'])) {
                //this will change all but not the password
                $manager->updateUser($user);
            } else {
                // this will change all including password
                $manager->updateUser($user);
                $manager->updatePassword($user);
            }

            header("Location: /back/users");
        }
    }

}
