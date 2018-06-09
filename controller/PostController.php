<?php

namespace keymener\myblog\controller;

use keymener\myblog\core\TwigLaunch;
use keymener\myblog\entity\Post;
use keymener\myblog\model\PostManager;

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

        // get all post from database
        $posts = $this->postManager->getAllPosts();

        //get last date
        $date = $this->postManager->getLastDate();


        //send it to view
        $twig = $this->twig->twigLoad();
        echo $twig->render('backend/post.twig', array(
            'posts' => $posts,
            'lastDate' => $date));
    }

    /**
     * get single post page
     * @param int $id
     */
    public function getPost($id)
    {

        $post = $this->postManager->getPost($id);

        $twig = $this->twig->twigLoad();
        echo $twig->render('frontend/singlePost.twig', array(
            'post' => $post));
    }

    /**
     * delete post
     * @param int $id
     */
    public function deletePost($id)
    {

        $this->postManager->deletePost($id);

        header("location: /post/home");
    }

    /**
     * post form
     */
    public function postForm()
    {

        $twig = $this->twig->twigLoad();
        echo $twig->render('backend/postForm.twig', array(
            'action' => '/post/addpost',
            'button' => 'add'));
    }

    /**
     * add post
     */
    public function addPost()
    {


        $this->post->hydrate($_POST);
        $this->post->setUserId($_SESSION['userId']);
        $this->post->setLastDate(date("Y-m-d H:i:s"));

        $this->postManager->addPost($this->post);

        header("Location: /post/home");
    }

    /**
     * update post
     * @param int $id
     */
    public function modifyPost($id)
    {

        $data = $this->postManager->getPost($id);

        $this->post->hydrate($data);


        $twig = $this->twig->twigLoad();
        echo $twig->render('backend/postForm.twig', array(
            'post' => $this->post,
            'action' => '/post/updatepost',
            'button' => 'modify'
        ));
    }

    /**
     * publish post
     * @param int $id
     */
    public function publishPost($id)
    {

        //get the post from database and hydrate isntance
        $data = $this->postManager->getPost($id);
        $this->post->hydrate($data);

        //set the value true to published
        $this->post->setPublished(true);

        // update to database
        $this->postManager->updatePost($this->post);

        // return to home view
        header("Location: /post/home");
    }

    /**
     * unpublish post
     * @param int $id
     */
    public function unpublishPost($id)
    {

        //get the post from database and hydrate isntance
        $data = $this->postManager->getPost($id);
        $this->post->hydrate($data);


        // set the attribute to false for unpublish
        $this->post->setPublished(false);

        //update to database
        $this->postManager->updatePost($this->post);

        // return to home view
        header("Location: /post/home");
    }

    /**
     * update post
     */
    public function updatePost()
    {
        if (isset($_POST['id'])) {
            $this->post->hydrate($_POST);

            $this->post->setUserId($_SESSION['userId']);
            $this->post->setLastDate(date("Y-m-d H:i:s"));

            $this->postManager->updatePost($this->post);

            header("Location: /post/home");
        }
    }

}
