<?php

namespace keymener\myblog\controller;

use keymener\myblog\core\Mailer;
use keymener\myblog\core\TwigLaunch;
use keymener\myblog\entity\Comment;
use keymener\myblog\entity\Post;
use keymener\myblog\entity\User;
use keymener\myblog\model\CommentManager;
use keymener\myblog\model\PostManager;
use keymener\myblog\model\UserManager;

/**
 * post controller
 *
 * @author keymener
 */
class BlogController
{

    private $twig;
    private $mailer;
    private $post;
    private $comment;
    private $user;
    private $postManager;
    private $commentManager;
    private $userManager;
    

    public function __construct(
    TwigLaunch $twig, PostManager $postManager, Post $post, Comment $comment, CommentManager $commentManager, Mailer $mailer, UserManager $userManager, User $user
    )
    {
        $this->twig = $twig;
        $this->mailer = $mailer;
        $this->post = $post;
        $this->comment = $comment;
        $this->postManager = $postManager;
        $this->commentManager = $commentManager;
        $this->userManager = $userManager;
        $this->user = $user ;
        
        
    }

    /**
     * home page
     * @param string $message
     */
    public function home($message = null)
    {
        echo $this->twig->twigLoad()->render('frontend/home.twig', [
            'message' => $message
                ]
        );
    }

    /**
     * get the posts page
     */
    public function posts()
    {
        $posts = $this->postManager->getAllPublished();


        echo $this->twig->twigLoad()->render('frontend/posts.twig', array('posts' => $posts));
    }

    /**
     * get the single post page
     * @param ing $id
     * @param string $message
     */
    public function post($id, $message = null)
    {
        //post instance
        $data = $this->postManager->getPost($id);
        $this->post->hydrate($data);
        
        //user instance
        $dataUser = $this->userManager->getUserById($this->post->getUserId());
        $this->user->hydrate($dataUser);
        
     
        
        //comments of this post
        $comments = $this->commentManager->getOkComments($id);
        echo $this->twig->twigLoad()->render(
                'frontend/post.twig', [
            'post' => $this->post,
            'comments' => $comments,
            'message' => $message,
            'user' => $this->user
        ]);
    }

    /**
     * add comment
     */
    public function add()
    {
        if (isset($_POST['content'], $_POST['postId'])) {

            $this->comment->hydrate($_POST);
            $this->comment->setDateTime(date("Y-m-d H:i:s"));

            $this->commentManager->add($this->comment);

            $message = 'commentAdd';
            $this->post($this->comment->getPostId(), $message);
        }
    }

    /**
     * send email
     */
    public function sendMail()
    {
        if (isset($_POST['name'], $_POST['userEmail'], $_POST['message'])) {
            
            $name = $_POST['name'];
            $userEmail = $_POST['userEmail'];
            $message = $_POST['message'];
            
            if($this->mailer->sendmail($name, $userEmail, $message)){
                                
                $this->home('mailOk');
            }else{
                $this->home('mailNok');
            }
        }else{
            echo 'erreur';
        }
    }

}
