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

        $posts = new PostManager();
        $posts = $posts->getAllPosts();



        $twig = TwigLaunch::twigLoad();
        echo $twig->render('frontend/allPosts.twig', array('posts' => $posts));
    }

    public function getPost($id)
    {

        $post = new PostManager();
        $post = $post->getPost($id);

        $twig = TwigLaunch::twigLoad();
        echo $twig->render('frontend/singlePost.twig', array('post' => $post));
    }

    public function deletePost($id)
    {
        if (isset($_SESSION['userId'])) {
            $manager = new PostManager();
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
            $manager = new PostManager;

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

}
