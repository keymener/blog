<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace keymener\myblog\controller;

use keymener\myblog\core\Authentication;
use keymener\myblog\core\TwigLaunch;
use keymener\myblog\entity\User;
use keymener\myblog\model\UserManager;

/**
 * Description of UserController
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
        $manager = new UserManager;
        $manager->deleteUser($id);
        header("Location: /back/users");
    }

    public function addForm()
    {

        $twig = TwigLaunch::twigLoad();
        echo $twig->render('backend/addForm.twig', array('p' => null));
    }

    /**
     * add a user 
     */
    public function addUser()
    {
        if (isset($_POST)) {

            $manager = new UserManager;

//checks if the login already exists
            if ($manager->userExists($_POST['login'])) {
                $twig = TwigLaunch::twigLoad();
                echo $twig->render('backend/addForm.twig', array('alert' => 1));
            } else {
                $auth = new Authentication($_POST['login'], $_POST['password']);
                $user = new User($_POST);
                $manager->addUser($user);

                header("Location: /back/users");
            }
        }
    }

    public function modifyUser($id)
    {
        $manager = new UserManager();
        $user = $manager->getUserById($id);
      
      
        $twig = TwigLaunch::twigLoad();
        echo $twig->render('backend/addForm.twig', array('user' => $user));
    }

}
