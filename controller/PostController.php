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
}
