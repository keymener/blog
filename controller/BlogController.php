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
class BlogController
{

    private $twig;
    private $postManager;
    private $post;
    private $comment;
    private $commentManager;

    public function __construct(
    TwigLaunch $twig, PostManager $postManager, Post $post, Comment $comment, CommentManager $commentManager
    )
    {
        $this->twig = $twig;
        $this->postManager = $postManager;
        $this->post = $post;
        $this->comment = $comment;
        $this->commentManager = $commentManager;
    }

    public function home()
    {
        echo $this->twig->twigLoad()->render('frontend/home.twig', [
            'message' => null
                ]
        );
    }

    public function posts()
    {
        $posts = $this->postManager->getAllPublished();


        echo $this->twig->twigLoad()->render('frontend/posts.twig', array('posts' => $posts));
    }

    public function post($id, $message = null)
    {
        //post instance
        $data = $this->postManager->getPost($id);
        $this->post->hydrate($data);

        //comments of this post
        $comments = $this->commentManager->getOkComments($id);
        echo $this->twig->twigLoad()->render(
                'frontend/post.twig', [
            'post' => $this->post,
            'comments' => $comments,
            'message' => $message
        ]);
    }

    public function add()
    {
        if (isset($_POST['content'], $_POST['post_id'])) {

            $this->comment->hydrate($_POST);
            $this->comment->setDateTime(date("Y-m-d H:i:s"));

            $this->commentManager->add($this->comment);

            $message = 'commentAdd';
            $this->post($this->comment->getPost_id(), $message);
        }
    }

}
