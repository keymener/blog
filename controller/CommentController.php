<?php

namespace keymener\myblog\controller;

use keymener\myblog\core\TwigLaunch;
use keymener\myblog\entity\Comment;
use keymener\myblog\model\CommentManager;

/**
 * controller pour post
 *
 * @author keyme
 */
class CommentController
{

    private $comment;
    private $commentManager;
    private $twig;

    public function __construct(Comment $comment, CommentManager $commentManager, TwigLaunch $twig)
    {
        $this->comment = $comment;
        $this->commentManager = $commentManager;
        $this->twig = $twig;
    }
    
    public function add()
    {
        if(isset($_POST['content'], $_POST['post_id'])){
            
            $this->comment->hydrate($_POST);
            $this->comment->setDateTime(date("Y-m-d H:i:s"));
            
            
            $this->commentManager->add($this->comment);
            
            header("location: /blog/post/".$this->comment->getPost_id());
            
        }
    }

}
