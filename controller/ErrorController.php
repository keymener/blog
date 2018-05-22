<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace keymener\myblog\controller;

use keymener\myblog\core\TwigLaunch;

/**
 * Description of ErrorController
 *
 * @author Keigo Matsunaga <keigo.matsunaga@gmail.com>
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
