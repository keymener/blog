<?php

namespace keymener\myblog\controller;

use keymener\myblog\core\TwigLaunch;
use keymener\myblog\model\PostManager;

/**
 * controller pour post
 *
 * @author keyme
 */
class PostController
{

    public function home()
    {

        $factory = new Factory;
        $manager = $factory->createManager('post');
        $posts = $manager->getAllPosts();



        $twig = TwigLaunch::twigLoad();
        echo $twig->render('frontend/allPosts.twig', array('posts' => $posts));
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

            header("location: /back/posts");
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
            $manager = $factory->createManager('post');
            $user = new User;
            $post = new \keymener\myblog\entity\Post($_POST);
            $post->setUserId($_SESSION['userId']);
            $post->setLastDate(date("Y-m-d H:i:s"));

            $manager->addPost($post);

            header("Location: /back/posts");
        } else {
            $twig = TwigLaunch::twigLoad();
            echo $twig->render('backend/login.twig', array('message' => false));
        }
    }

    public function modifyPost()
    {
        if (isset($_POS, $SESSION['userId'])
    }

}
