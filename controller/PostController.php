<?php

namespace keymener\myblog\controller;

/**
 * controller pour post
 *
 * @author keyme
 */
class PostController
{

    public function home()
    {

        $posts = new \keymener\myblog\model\PostManager();
        $posts = $posts->getAllPosts();



        $twig = \keymener\myblog\core\TwigLaunch::twigLoad();
        echo $twig->render('allPosts.twig', array('posts' => $posts));
    }

    public function getPost($id)
    {

        $post = new \keymener\myblog\model\PostManager();
        $post = $post->getPost($id);

        $twig = \keymener\myblog\core\TwigLaunch::twigLoad();
        echo $twig->render('singlePost.twig', array('post' => $post));
    }
}
