<?php

namespace keymener\myblog\controller;

use keymener\myblog\core\Factory;
use keymener\myblog\core\TwigLaunch;
use keymener\myblog\entity\Post;
use keymener\myblog\entity\User;

/**
 * controller pour post
 *
 * @author keyme
 */
class PostController
{

    /**
     * post managment page
     */
    public function home()
    {
        if (isset($_SESSION['userId'])) {
            $factory = new Factory;
            $manager = $factory->createManager('post');

            $posts = $manager->getAllPosts();
            $date = $manager->getLastDate();

            $twig = TwigLaunch::twigLoad();
            echo $twig->render('backend/post.twig', array(
                'posts' => $posts,
                'lastDate' => $date)
            );
        } else {
            $twig = TwigLaunch::twigLoad();
            echo $twig->render('backend/login.twig', array('message' => false));
        }
    }

    public function getPost($id)
    {

        $factory = new Factory;
        $manager = $factory->createManager('post');
        $post = $manager->getPost($id);

        $twig = TwigLaunch::twigLoad();
        echo $twig->render('frontend/singlePost.twig', array('post' => $post));
    }

    public function deletePost($id)
    {
        if (isset($_SESSION['userId'])) {
            $factory = new Factory;
            $manager = $factory->createManager('post');
            $manager->deletePost($id);

            header("location: /post/home");
        } else {
            $twig = TwigLaunch::twigLoad();
            echo $twig->render('backend/login.twig', array('message' => false));
        }
    }

    public function postForm()
    {
        if (isset($_SESSION['userId'])) {
            $twig = TwigLaunch::twigLoad();
            echo $twig->render('backend/postForm.twig', array(
                'action' => '/post/addpost',
                'button' => 'add'
            ));
        } else {
            $twig = TwigLaunch::twigLoad();
            echo $twig->render('backend/login.twig', array('message' => false));
        }
    }

    public function addPost()
    {

        if (isset($_POST, $_SESSION['userId'])) {
            $factory = new Factory;
            $postManager = $factory->createManager('post');

            $post = new Post($_POST);
            $post->setUserId($_SESSION['userId']);
            $post->setLastDate(date("Y-m-d H:i:s"));

            $postManager->addPost($post);

            header("Location: /post/home");
        } else {
            $twig = TwigLaunch::twigLoad();
            echo $twig->render('backend/login.twig', array('message' => false));
        }
    }

    public function modifyPost($id)
    {
        if (isset($_SESSION['userId'])) {

            $factory = new Factory;
            $manager = $factory->createManager('post');

            $post = $manager->getPost($id);

            $twig = TwigLaunch::twigLoad();
            echo $twig->render('backend/postForm.twig', array(
                'post' => $post,
                'action' => '/post/updatepost',
                'button' => 'modify'
            ));
        } else {
            $twig = TwigLaunch::twigLoad();
            echo $twig->render('backend/login.twig', array('message' => false));
        }
    }

    public function publishPost($id)
    {
        if (isset($_SESSION['userId'])) {

            $factory = new Factory;
            $manager = $factory->createManager('post'); // get the manager

            $post = $manager->getPost($id); // instance of post
            $post->setPublished(true);

            $manager->updatePost($post);

            header("Location: /post/home");
        } else {
            $twig = TwigLaunch::twigLoad();
            echo $twig->render('backend/login.twig', array('message' => false));
        }
    }

    public function unpublishPost($id)
    {
        if (isset($_SESSION['userId'])) {

            $factory = new Factory;
            $manager = $factory->createManager('post');

            $post = $manager->getPost($id); // get the instance of post
            $post->setPublished(false); // set the attribute to false for unpublish


            $manager->updatePost($post);

            header("Location: /post/home");
        } else {
            $twig = TwigLaunch::twigLoad();
            echo $twig->render('backend/login.twig', array('message' => false));
        }
    }

    public function updatePost($id)
    {
        if (isset($_SESSION['userId'], $_POST['id'])) {

            $factory = new Factory;
            $manager = $factory->createManager('post');

            $post = new Post($_POST); // instance of post 

            $manager->updatePost($post);

            header("Location: /post/home");
        } else {
            $twig = TwigLaunch::twigLoad();
            echo $twig->render('backend/login.twig', array('message' => false));
        }
    }

}
