<?php

namespace keymener\myblog\controller;

use keymener\myblog\core\TwigLaunch;

/**
 * controller pour post
 *
 * @author keyme
 */
class FrontController
{

    private $twig;

    public function __construct(TwigLaunch $twig)
    {
        $this->twig = $twig;
    }

    public function home()
    {
        echo $this->twig->twigLoad()->render('frontend/home.twig', array(
            'a' => 'a')
        );
    }

}
