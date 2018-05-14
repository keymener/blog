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
        $manager = new UserManager;
        $manager->deleteUser($id);
        header("Location: /back/users");
    }

    public function addForm()
    {

        $twig = TwigLaunch::twigLoad();
        echo $twig->render('backend/addForm.twig', array(
            'action' => '/user/adduser',
            'button' => 'add'
        ));
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
                echo $twig->render('backend/addForm.twig', array(
                    'alert' => 1,
                    'action' => '/user/adduser',
                    'button' => 'add'
                ));
            } else {
                $auth = new Authentication($_POST['login'], $_POST['password']);
                $user = new User($_POST);
                $manager->addUser($user);

                header("Location: /back/users");
            }
        }
    }

    /**
     * Modify a user using its ID
     * @param type $id
     */
    public function modifyUser($id)
    {
        $manager = new UserManager();
        $user = $manager->getUserById($id);


        $twig = TwigLaunch::twigLoad();
        echo $twig->render('backend/addForm.twig', array(
            'user' => $user,
            'action' => '/user/updateuser',
            'button' => 'modify'
        ));
    }
    
/**
 * Update a user using POST method
 * 
 */
    public function updateUser()
    {
        if (isset($_POST['id'])) {

            $user = new User($_POST);

            $manager = new UserManager();
            $manager->updateUser($user);

            header("Location: /back/users");
        }
    }

}
