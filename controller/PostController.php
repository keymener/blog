<?php

namespace keymener\myblog\controller;

use keymener\myblog\core\Factory;
use keymener\myblog\core\TwigLaunch;
use keymener\myblog\entity\Post;
use keymener\myblog\model\PostManager;

/**
 * controller pour post
 *
 * @author keyme
 */
class PostController
{

    private $post;
    private $postManager;
    private $twig;

    public function __construct(
    Post $post, PostManager $postManager, TwigLaunch $twig
    )
    {
        $this->post = $post;
        $this->postManager = $postManager;
        $this->twig = $twig;
    }

    /**
     * post managment page
     */
    public function home()
    {
        if (isset($_SESSION['userId'])) {


            $posts = $this->postManager->getAllPosts();
            $date = $this->postManager->getLastDate();

            echo $this->twig->render('backend/post.twig', array(
                'posts' => $posts,
                'lastDate' => $date)
            );
        } else {

            echo $this->twig->render('backend/login.twig', array(
                'message' => false)
            );
        }
    }

    public function getPost($id)
    {

        $post = $this->postManager->getPost($id);

        echo $this->twig->render('frontend/singlePost.twig', array(
            'post' => $post)
        );
    }

    public function deletePost($id)
    {
        if (isset($_SESSION['userId'])) {

            $this->postManager->deletePost($id);

            header("location: /post/home");
        } else {

            echo $this->twig->render('backend/login.twig', array(
                'message' => false)
            );
        }
    }

    public function postForm()
    {
        if (isset($_SESSION['userId'])) {

            echo $this->twig->render('backend/postForm.twig', array(
                'action' => '/post/addpost',
                'button' => 'add')
            );
        } else {

            echo $this->twig->render('backend/login.twig', array(
                'message' => false)
            );
        }
    }

    public function addPost()
    {

        if (isset($_POST, $_SESSION['userId'])) {


            $this->post($_POST);
            $this->post->setUserId($_SESSION['userId']);
            $this->post->setLastDate(date("Y-m-d H:i:s"));

            $this->postManager->addPost($this->post);

            header("Location: /post/home");
        } else {

            echo $this->twig->render('backend/login.twig', array(
                'message' => false)
            );
        }
    }

    public function modifyPost($id)
    {
        if (isset($_SESSION['userId'])) {

            $post = $this->post($this->postManager->getPost($id));


            echo $this->twig->render('backend/postForm.twig', array(
                'post' => $post,
                'action' => '/post/updatepost',
                'button' => 'modify'
            ));
        } else {

            echo $twig->twig->render('backend/login.twig', array(
                'message' => false)
            );
        }
    }

    public function publishPost($id)
    {
        if (isset($_SESSION['userId'])) {
            //get the post from database and add to constructor's instance
            $this->post($this->postManager->getPost($id));

            //set the value true to published
            $this->post->setPublished(true);

            // update to database
            $this->postManager->updatePost($this->post);

            // return to home view
            header("Location: /post/home");
        } else {

            echo $this->twig->render('backend/login.twig', array(
                'message' => false)
            );
        }
    }

    public function unpublishPost($id)
    {
        if (isset($_SESSION['userId'])) {

            //get the post from database and add to constructor's instance
            $this->post($this->postManager->getPost($id));

            // set the attribute to false for unpublish
            $this->post->setPublished(false);

            //update to database
            $this->postManager->updatePost($this->post);

            // return to home view
            header("Location: /post/home");
        } else {

            echo $this->twig->render('backend/login.twig', array(
                'message' => false)
            );
        }
    }

    public function updatePost($id)
    {
        if (isset($_SESSION['userId'], $_POST['id'])) {

            $this->post($_POST);
            $$this->post->setUserId($_SESSION['userId']);
            $this->post->setLastDate(date("Y-m-d H:i:s"));

            $this->postManager->updatePost($this->post);

            header("Location: /post/home");
        } else {

            echo $this->twig->render('backend/login.twig', array(
                'message' => false)
            );
        }
    }

}
