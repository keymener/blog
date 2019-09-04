<?php

namespace keymener\myblog\controller;

use DI\Annotation\Inject;
use keymener\myblog\core\CheckInput;
use keymener\myblog\core\Csrf;
use keymener\myblog\core\JsonFlashResponse;
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
    private $jsonFlashResponse;

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
        ErrorController $errorsHandler,
        JsonFlashResponse $jsonFlashResponse

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
        $this->jsonFlashResponse = $jsonFlashResponse;
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


        if (!empty($_REQUEST['name'])
            && !empty($_REQUEST['userEmail'])
            && !empty($_REQUEST['message'])
            && !empty($_SESSION['token'])
            && !empty($_REQUEST['token'])
//            && !empty($data['g-recaptcha-response'])
        ) {
            $this->jsonFlashResponse->getResponse('warning',
                'Veuillez remplir tous les champs du formulaire');
        }

        $name = $_REQUEST['name'];
        $message = $_REQUEST['message'];
        $sessionToken = $_SESSION['token'];
        $clientToken = $_REQUEST['token'];


//            $response = $_POST['g-recaptcha-response'];
//
//            $remoteip = $_SERVER['REMOTE_ADDR'];
//
//            //try to run recaptcha function. catch errors when occurs
//            try {
//
//                $result = $this->recaptcha->recaptcha($response, $remoteip);
//
//            } catch (\Exception $e) {
//                $code = $e->getCode();
//                $message = $e->getMessage();
//                $this->errorsHandler->error($code, $message);
//                die();
//            }


        //checks if token matches for csrf
        if ($sessionToken !== $clientToken) {
            $this->jsonFlashResponse->getResponse('danger',
                'Il y a un problème avec le forumlaire');
        }

        //check result of recaptcha
//                if (!$result) {
//                    $this->jsonFlashResponse->getResponse('warning',
//                        'Problème avec le captcha');
//                }

        //check size of name input
        if (!$this->check->checkLenth($name, 200)) {

            $this->jsonFlashResponse->getResponse('warning',
                'Le nom est trop long');
        }

        //check input email
        if (!$this->check->checkEmail($email)) {

            $this->jsonFlashResponse->getResponse('warning',
                'l\'email est mal saisie');
        }
        if (!$this->check->checkLenth($message, 500)) {

            $this->jsonFlashResponse->getResponse('warning',
                'Le texte ne doit pas dépasser 500 carractères');
        }

        if ($this->mailer->sendmail($name, $email, $message)) {
            $this->jsonFlashResponse->getResponse('success',
                'Le message a bien été envoyé');

        } else {
            $this->jsonFlashResponse->getResponse('danger',
                'Il y a eu un probmèe lors de l\' envoi du message, veuillez reesayer ulterieurment');

        }


    }

}
