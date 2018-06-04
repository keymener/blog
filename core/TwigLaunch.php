<?php

namespace keymener\myblog\core;

use Twig_Environment;
use Twig_Loader_Filesystem;

/**
 * Permet de generer le twig loader
 *
 * @author keyme
 */
class TwigLaunch
{

    const TWIGFILES = '../view';
    const TWIGTMP = 'tmp';

    public static function twigLoad()
    {

        $loader = new Twig_Loader_Filesystem(self::TWIGFILES);
        $twig = new Twig_Environment($loader, array(
            'cache' => false
                //'auto_reload' => true
        ));

        return $twig;
    }
}
