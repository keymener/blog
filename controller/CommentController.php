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

    public function home($message = null)
    {
        $posts = $this->postManager->getAllPostsComments();

        echo $this->twig->twigLoad()->render('backend/comment.twig', [
            'posts' => $posts,
            'message' => $message
                ]
                );
    }

    public function add()
    {
        if (isset($_POST['content'], $_POST['post_id'])) {

            $this->comment->hydrate($_POST);
            $this->comment->setDateTime(date("Y-m-d H:i:s"));


            $this->commentManager->add($this->comment);

            header("location: /blog/post/" . $this->comment->getPost_id());
        }
    }

    public function validate($postId)
    {
        //post instance
        $data = $this->postManager->getPost($postId);
        $this->post->hydrate($data);

        //comments of this post
        $comments = $this->commentManager->getComments($postId);
        echo $this->twig->twigLoad()->render(
                'backend/postComment.twig', [
            'post' => $this->post,
            'comments' => $comments
        ]);
    }
    
    public function commentValidate($id)
    {
        $this->commentManager->publish($id);
        $message = 'validate';
        $this->home($message);
    }

}
