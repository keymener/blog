<?php

namespace keymener\myblog\controller;

use keymener\myblog\core\Authentication;
use keymener\myblog\core\TwigLaunch;
use keymener\myblog\entity\User;
use keymener\myblog\model\UserManager;

/**
 * User controller
 *
 * @author keymener
 */
class UserController
{

    private $user;
    private $userManager;
    private $twig;
    private $auth;
    private $csrf;

    public function __construct(
    User $user, UserManager $userManager, TwigLaunch $twig, Authentication $auth, \keymener\myblog\core\Csrf $csrf
    )
    {
        $this->user = $user;
        $this->userManager = $userManager;
        $this->twig = $twig;
        $this->auth = $auth;
        $this->csrf = $csrf;
    }

    /**
     * user managment page
     */
    public function home()
    {
        //csrf protection
        $token = $this->csrf->sessionRandom(5);

        $users = $this->userManager->getAllUsers();


        $twig = $this->twig->twigLoad();
        echo $twig->render('backend/user.twig', array(
            'users' => $users,
            'token' => $token
        ));
    }

    /**
     * delete usuer by its id
     * @param type $id
     */
    public function delete($id)
    {

        $this->userManager->deleteUser($id);
        header("Location: /back/users");
    }

    /**
     * user form
     */
    public function addForm()
    {
        //csrf protection
        $token = $this->csrf->sessionRandom(5);

        $twig = $this->twig->twigLoad();
        echo $twig->render('backend/addForm.twig', array(
            'action' => '/user/adduser',
            'button' => 'add',
            'token' => $token
        ));
    }

    /**
     * add user into database
     */
    public function addUser()
    {
        if (isset($_SESSION['token'], $_POST['token'], $_POST['firstname'], $_POST['lastname'], $_POST['login'])) {

            if ($_SESSION['token'] == $_POST['token']) {

                //checks if the login already exists, if yes return error
                if ($this->userManager->userExists($_POST['login'])) {
                    $twig = $this->twig->twigLoad();
                    echo $twig->render('backend/addForm.twig', array(
                        'alert' => 1,
                        'action' => '/user/adduser',
                        'button' => 'add'
                    ));
                } else {


                    //encrypt the password from post variable
                    $password = $this->auth->encrypt($_POST['password']);

                    // hydrate user entity
                    $this->user->hydrate($_POST);
                    $this->user->setPassword($password);

                    //add user into database
                    $this->userManager->addUser($this->user);

                    header("Location: /back/users");
                }
            } else {
                echo 'token ne match pas';
            }
        } else {
            echo 'il manque un paramètre post';
        }
    }

    /**
     * Modify a user using its ID
     * @param type $id
     */
    public function updateForm($id)
    {
        //csrf protection
        $token = $this->csrf->sessionRandom(5);

        $data = $this->userManager->getUserById($id);
        $this->user->hydrate($data);

        $twig = $this->twig->twigLoad();
        echo $twig->render('backend/addForm.twig', array(
            'user' => $this->user,
            'action' => '/user/update',
            'button' => 'modify',
            'token' => $token
        ));
    }

    /**
     * Update a user using POST method
     *
     */
    public function update()
    {
        if (isset($_SESSION['token'], $_POST['token']) && !empty($_POST['id'])) {

            if ($_SESSION['token'] == $_POST['token']) {

                $this->user->hydrate($_POST);

                // check if the user changes the password
                if (empty($_POST['password'])) {
                    //this will change all but not the password
                    $this->userManager->updateUser($this->user);
                } else {
                    // this will change all including password
                    $this->userManager->updateUser($this->user);

                    $this->user->setPassword($this->auth->encrypt($_POST['password']));
                    $this->userManager->updatePassword($this->user);
                }

                header("Location: /back/users");
            } else {
                echo 'token ne match pas';
            }
        } else {
            echo 'pas de token';
        }
    }

}
