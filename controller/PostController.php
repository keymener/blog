<?php

namespace keymener\myblog\controller;

/**
 * controller pour post
 *
 * @author keyme
 */
class PostController
{

    public function __construct()
    {

        $this->getAllPosts();
    }

    private function getAllPosts()
    {

        $posts = new \keymener\myblog\model\PostManager();
        $posts = $posts->getAllPosts();


        $twig = \keymener\myblog\TwigLaunch::twigLoad();

        echo $twig->render('allPosts.twig', array('posts' => $posts));
    }

}
