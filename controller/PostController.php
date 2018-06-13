<?php

namespace keymener\myblog\controller;

use keymener\myblog\core\Csrf;
use keymener\myblog\core\TwigLaunch;
use keymener\myblog\entity\Post;
use keymener\myblog\model\PostManager;
use keymener\myblog\model\UserManager;

/**
 * post controller
 *
 * @author keymener
 */
class PostController
{

    private $post;
    private $postManager;
    private $twig;
    private $userManager;
    private $csrf;

    public function __construct(
    Post $post, PostManager $postManager, TwigLaunch $twig, UserManager $userManager, Csrf $csrf
    )
    {
        $this->post = $post;
        $this->postManager = $postManager;
        $this->twig = $twig;
        $this->userManager = $userManager;
        $this->csrf = $csrf;
    }

    /**
     * post managment page
     */
    public function home()
    {
        //random token for csrf
        $token = $this->csrf->sessionRandom(5);

        // get all post from database
        $posts = $this->postManager->getAllPosts();

        //get last date
        $date = $this->postManager->getLastDate();


        //send it to view
        $twig = $this->twig->twigLoad();
        echo $twig->render('backend/post.twig', array(
            'posts' => $posts,
            'lastDate' => $date,
            'token' => $token
        ));
    }

    /**
     * delete post
     * @param int $id
     */
    public function deletePost($id)
    {
        if (isset($_SESSION['token'], $_POST['token'])) {

            if ($_SESSION['token'] == $_POST['token']) {

                $this->postManager->deletePost($id);

                header("location: /post/home");
            } else {
                echo 'token ne match pas';
            }
        } else {
            'pas de token';
        }
    }

    /**
     * post form
     */
    public function postForm()
    {
        //random token for csrf
        $token = $this->csrf->sessionRandom(5);

        $twig = $this->twig->twigLoad();
        echo $twig->render('backend/postForm.twig', array(
            'action' => '/post/addpost',
            'button' => 'add',
            'token' => $token
        ));
    }

    /**
     * add post
     */
    public function addPost()
    {
        if (isset($_SESSION['token'], $_POST['token'])) {

            if ($_SESSION['token'] == $_POST['token']) {

                $this->post->hydrate($_POST);
                $this->post->setUserId($_SESSION['userId']);
                $this->post->setLastDate(date("Y-m-d H:i:s"));

                $this->postManager->addPost($this->post);

                header("Location: /post/home");
            } else {
                echo 'token ne match pas';
            }
        } else {
            'pas de token';
        }
    }

    /**
     * update post
     * @param int $id
     */
    public function modifyPost($id)
    {
        //random token for csrf
        $token = $this->csrf->sessionRandom(5);

        //post instance
        $data = $this->postManager->getPost($id);
        $this->post->hydrate($data);

        //user array
        $users = $this->userManager->getAllUsers();

        $twig = $this->twig->twigLoad();
        echo $twig->render('backend/postForm.twig', array(
            'post' => $this->post,
            'action' => '/post/updatepost',
            'button' => 'modify',
            'users' => $users,
            'token' => $token
        ));
    }

    /**
     * publish post
     * @param int $id
     */
    public function publishPost($id)
    {

        if (isset($_SESSION['token'], $_POST['token'])) {

            if ($_SESSION['token'] == $_POST['token']) {

                //get the post from database and hydrate isntance
                $data = $this->postManager->getPost($id);
                $this->post->hydrate($data);

                //set the value true to published
                $this->post->setPublished(true);

                // update to database
                $this->postManager->updatePost($this->post);

                // return to home view
                header("Location: /post/home");
            } else {
                echo 'token ne match pas';
            }
        } else {
            'pas de token';
        }
    }

    /**
     * unpublish post
     * @param int $id
     */
    public function unpublishPost($id)
    {
        if (isset($_SESSION['token'], $_POST['token'])) {

            if ($_SESSION['token'] == $_POST['token']) {

                //get the post from database and hydrate isntance
                $data = $this->postManager->getPost($id);
                $this->post->hydrate($data);


                // set the attribute to false for unpublish
                $this->post->setPublished(false);

                //update to database
                $this->postManager->updatePost($this->post);

                // return to home view
                header("Location: /post/home");
            } else {
                echo 'token ne match pas';
            }
        } else {
            'pas de token';
        }
    }

    /**
     * update post
     */
    public function updatePost()
    {

        if (isset($_SESSION['token'], $_POST['token']) && !empty($_POST['id'])) {

            if ($_SESSION['token'] == $_POST['token']) {

                $this->post->hydrate($_POST);

                $this->post->setUserId($_POST['userId']);
                $this->post->setLastDate(date("Y-m-d H:i:s"));

                $this->postManager->updatePost($this->post);

                header("Location: /post/home");
            } else {
                echo 'token ne match pas';
            }
        } else {
           echo 'pas de token';
        }
    }

}
