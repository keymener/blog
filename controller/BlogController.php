<?php

namespace keymener\myblog\controller;

use keymener\myblog\core\TwigLaunch;
use keymener\myblog\model\PostManager;

/**
 * controller pour post
 *
 * @author keyme
 */
class BlogController
{

    private $twig;
    private $postManager;

    public function __construct(
    TwigLaunch $twig, PostManager $postManager)
    {
        $this->twig = $twig;
        $this->postManager = $postManager;
    }

    public function home()
    {
        echo $this->twig->twigLoad()->render('frontend/home.twig', array(
            'a' => 'a'));
    }

    public function post()
    {
        $posts = $this->postManager->getAllPublished();


        echo $this->twig->twigLoad()->render('frontend/post.twig', array('posts' => $posts));
    }

}
