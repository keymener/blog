<?php

namespace keymener\myblog\controller;

use keymener\myblog\core\CheckInput;
use keymener\myblog\core\Csrf;
use keymener\myblog\core\Mailer;
use keymener\myblog\core\TwigLaunch;
use keymener\myblog\entity\Comment;
use keymener\myblog\entity\Post;
use keymener\myblog\entity\User;
use keymener\myblog\model\CommentManager;
use keymener\myblog\model\PostManager;
use keymener\myblog\model\UserManager;
use keymener\myblog\core\Recaptcha;
use keymener\myblog\controller\ErrorController;

/**
 * post controller
 *
 * @author keymener
 */
class BlogController
{

    private $twig;
    private $mailer;
    private $myPost;
    private $comment;
    private $user;
    private $postManager;
    private $commentManager;
    private $userManager;
    private $csrf;
    private $check;
    private $recaptcha;
    private $errorsHandler;

    public function __construct(
        TwigLaunch $twig,
        PostManager $postManager,
        Post $myPost,
        Comment $comment,
        CommentManager $commentManager,
        Mailer $mailer,
        UserManager $userManager,
        User $user,
        Csrf $csrf,
        CheckInput $check,
        Recaptcha $recaptcha,
        ErrorController $errorsHandler
    ) {
        $this->twig = $twig;
        $this->mailer = $mailer;
        $this->myPost = $myPost;
        $this->comment = $comment;
        $this->postManager = $postManager;
        $this->commentManager = $commentManager;
        $this->userManager = $userManager;
        $this->user = $user;
        $this->csrf = $csrf;
        $this->check = $check;
        $this->recaptcha = $recaptcha;
        $this->errorsHandler = $errorsHandler;
    }

    /**
     * home page
     *
     * @param string $message
     */
    public
    function home(
        $message = null
    ) {
        //put the random into session for csrf
        $token = $this->csrf->sessionRandom(5);

        echo $this->twig->twigLoad()->render('frontend/home.twig', [
                'message' => $message,
                'token' => $token
            ]
        );
    }

    /**
     * get the posts page
     */
    public
    function posts()
    {
        $posts = $this->postManager->getAllPublished();


        echo $this->twig->twigLoad()
            ->render('frontend/posts.twig', array('posts' => $posts));
    }

    /**
     * get the single post page
     *
     * @param ing    $id
     * @param string $message
     */
    public
    function post(
        $id,
        $message = null
    ) {
        //put the random token into session for csrf
        $token = $this->csrf->sessionRandom(5);

        //post instance
        $data = $this->postManager->getPost($id);
        $this->myPost->hydrate($data);

        //user instance
        $dataUser = $this->userManager->getUserById($this->myPost->getUserId());
        $this->user->hydrate($dataUser);


        //comments of this post
        $comments = $this->commentManager->getOkComments($id);
        echo $this->twig->twigLoad()->render(
            'frontend/post.twig', [
            'post' => $this->myPost,
            'comments' => $comments,
            'message' => $message,
            'user' => $this->user,
            'token' => $token
        ]);
    }

    /**
     * add comment
     */
    public
    function add()
    {
        if (isset($_POST['content'], $_POST['postId'], $_SESSION['token'], $_POST['token'])) {

            //checks if token matches for csrf
            if ($_SESSION['token'] == $_POST['token']) {


                $this->comment->hydrate($_POST);
                $this->comment->setDateTime(date("Y-m-d H:i:s"));

                $this->commentManager->add($this->comment);

                $message = 'commentAdd';
                $this->post($this->comment->getPostId(), $message);
            } else {
                header('Location: /error/error/500');
            }
        } else {
            header('Location: /error/error/500');
        }
    }

      /**
     * send email
     */
public
function sendMail()
{


    if (!empty($_POST['name'])
        && !empty($_POST['userEmail'])
        && !empty($_POST['message'])
        && !empty($_SESSION['token'])
        && !empty($_POST['token'])
        && !empty($_POST['g-recaptcha-response'])
    ) {


        $response = $_POST['g-recaptcha-response'];

        $remoteip = $_SERVER['REMOTE_ADDR'];

        //try to run recaptcha function. catch errors when occurs
        try {

            $result = $this->recaptcha->recaptcha($response, $remoteip);

        } catch (\Exception $e) {
            $code = $e->getCode();
            $message = $e->getMessage();
            $this->errorsHandler->error($code, $message);
            die();
        }




        //checks if token matches for csrf
        if ($_SESSION['token'] == $_POST['token']) {

            //check result of recaptcha
            if(!$result){
                $this->home('reCaptcha');
            }

            //check size of name input
            if ($this->check->checkLenth($_POST['name'], 200)) {
                $name = $_POST['name'];
            } else {
                $this->home('nameLong');
            }

            //check input email
            if ($this->check->checkEmail($_POST['userEmail'])) {
                $userEmail = $_POST['userEmail'];
            } else {
                $this->home('formNok');
            }
            if ($this->check->checkLenth($_POST['message'], 500)) {
                $message = $_POST['message'];
            } else {
                $this->home('textLong');
            }

            if ($this->mailer->sendmail($name, $userEmail, $message)) {




            } else {


            }
        } else {

        }
    } else {
        header('Content-Type: application/json');
        echo json_encode([
            'status'=> 'error',
            'message'=> 'Veuillez valider tous les champs'
        ]);
    }
}

}
