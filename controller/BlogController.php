<?php

namespace keymener\myblog\controller;

use keymener\myblog\core\TwigLaunch;
use keymener\myblog\entity\Post;
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
    private $post;

    public function __construct(
    TwigLaunch $twig, PostManager $postManager, Post $post, )
    {
        $this->twig = $twig;
        $this->postManager = $postManager;
        $this->post = $post ;
    }

    public function home()
    {
        echo $this->twig->twigLoad()->render('frontend/home.twig', array(
            'a' => 'a'));
    }

    public function posts()
    {
        $posts = $this->postManager->getAllPublished();


        echo $this->twig->twigLoad()->render('frontend/posts.twig', array('posts' => $posts));
    }
    
    public function post($id)
    {
        $data = $this->postManager->getPost($id);
        $this->post->hydrate($data);
            
        echo $this->twig->twigLoad()->render('frontend/post.twig', array('post' => $this->post));
    }
    
    public function comment($postId)
    {
        
    }

}
