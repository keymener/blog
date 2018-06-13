<?php

namespace keymener\myblog\controller;

use keymener\myblog\core\Csrf;
use keymener\myblog\core\TwigLaunch;
use keymener\myblog\entity\Comment;
use keymener\myblog\entity\Post;
use keymener\myblog\model\CommentManager;
use keymener\myblog\model\PostManager;

/**
 * comment controller
 *
 * @author keymener
 */
class CommentController
{

    private $comment;
    private $commentManager;
    private $twig;
    private $postManager;
    private $post;
    private $csrf;

    public function __construct(
    Comment $comment, CommentManager $commentManager, TwigLaunch $twig, PostManager $postManager, Post $post, Csrf $csrf
    )
    {
        $this->comment = $comment;
        $this->commentManager = $commentManager;
        $this->twig = $twig;
        $this->postManager = $postManager;
        $this->post = $post;
        $this->csrf = $csrf;
    }

    /**
     * main page
     */
    public function home()
    {
        //random token for csrf
        $token = $this->csrf->sessionRandom(5);

        $posts = $this->postManager->getAllPostsComments();

        echo $this->twig->twigLoad()->render('backend/comment.twig', [
            'posts' => $posts,
            'token' => $token
                ]
        );
    }

    /**
     * get single post page
     * @param int $postId
     * @param string $message
     */
    public function validate($postId, $message = null)
    {
        if (isset($_SESSION['token'], $_POST['token'])) {

            if ($_SESSION['token'] == $_POST['token']) {

                //random token for csrf
                $token = $this->csrf->sessionRandom(5);

                //post instance
                $data = $this->postManager->getPost($postId);
                $this->post->hydrate($data);

                //comments of this post
                $comments = $this->commentManager->getComments($postId);
                echo $this->twig->twigLoad()->render(
                        'backend/postComment.twig', [
                    'post' => $this->post,
                    'comments' => $comments,
                    'message' => $message,
                    'token' => $token
                ]);
            } else {
                echo 'token ne match pas';
            }
        } else {
            'pas de token';
        }
    }

    /**
     * comment validation
     * @param int $id
     */
    public function commentValidate($id)
    {
        if (isset($_SESSION['token'], $_POST['token'])) {

            if ($_SESSION['token'] == $_POST['token']) {
                
                $data = $this->commentManager->getComment($id);
                $this->comment->hydrate($data);

                $this->comment->setPublished(true);

                $this->commentManager->update($this->comment);
                $message = 'validate';

                $this->validate($this->comment->getPostId(), $message);
            } else {
                echo 'token ne match pas';
            }
        } else {
            'pas de token';
        }
    }

}
