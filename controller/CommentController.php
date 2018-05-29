<?php

namespace keymener\myblog\controller;

use keymener\myblog\core\TwigLaunch;
use keymener\myblog\entity\Comment;
use keymener\myblog\entity\Post;
use keymener\myblog\model\CommentManager;
use keymener\myblog\model\PostManager;

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
    private $postManager;
    private $post;

    public function __construct(
    Comment $comment, CommentManager $commentManager, TwigLaunch $twig, PostManager $postManager, Post $post
    )
    {
        $this->comment = $comment;
        $this->commentManager = $commentManager;
        $this->twig = $twig;
        $this->postManager = $postManager;
        $this->post = $post;
    }

    public function home()
    {
        $posts = $this->postManager->getAllPostsComments();

        echo $this->twig->twigLoad()->render('backend/comment.twig', [
            'posts' => $posts
                ]
        );
    }

    public function validate($postId, $message = null)
    {
   
        //post instance
        $data = $this->postManager->getPost($postId);
        $this->post->hydrate($data);

        //comments of this post
        $comments = $this->commentManager->getComments($postId);
        echo $this->twig->twigLoad()->render(
                'backend/postComment.twig', [
            'post' => $this->post,
            'comments' => $comments,
            'message' => $message
        ]);
    }

    public function commentValidate($id)
    {
        
        $data = $this->commentManager->getComment($id);
        $this->comment->hydrate($data);
   
        $this->comment->setPublished(true);
  
        $this->commentManager->update($this->comment);
        $message = 'validate';
  
        $this->validate($this->comment->getPost_id(), $message);
    }

}
