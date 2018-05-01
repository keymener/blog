<?php

namespace keymener\myblog\controller;

/**
 * controller pour post
 *
 * @author keyme
 */
class HomeController
{
    public function home()
    {
        
        
        $twig = \keymener\myblog\core\TwigLaunch::twigLoad();
        echo $twig->render('home.twig', array('a' => 'a' ));
    }
}
