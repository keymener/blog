<?php


namespace keymener\myblog\controller;

use keymener\myblog\core\TwigLaunch;

/**
 * Error page controller
 *
 * @author keymener
 */
class ErrorController
{

    private $twig;

    public function __construct(TwigLaunch $twig)
    {
        $this->twig = $twig;
    }

    public function errorPage()
    {
        $twig = $this->twig->twigLoad();
        echo $twig->render('errorPage.twig', ['hide' => true]);
    }
}
