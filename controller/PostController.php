<?php

namespace keymener\myblog\controller;


/**
 * controller pour post
 *
 * @author keyme
 */
class PostController extends MainController{

    
    public function getAllPosts() {

        $manager = new \keymener\myblog\model\PostManager();
        $allPosts = $manager->getAllPosts();
        $this->twig();
        $twig = $this->twig;
        $page = $twig->load('allPosts.twig');
        echo $page->render(array('posts' => $allPosts));
    }

}
