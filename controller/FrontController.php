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
    public function home()
    {
                
        $twig = TwigLaunch::twigLoad();
        echo $twig->render('frontend/home.twig', array('a' => 'a' ));
    }
}
