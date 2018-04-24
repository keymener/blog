<?php

namespace keymener\myblog;

/**
 * Permet de generer le twig loader
 *
 * @author keyme
 */
class TwigLaunch
{

    const TWIGFILES = __DIR__ . '/view';
    const TWIGTMP = __DIR__ . '/tmp';

    public static function twigLoad()
    {

        $loader = new \Twig_Loader_Filesystem(self::TWIGFILES);
        $twig = new \Twig_Environment($loader, array(
            'cache' => false
                //'auto_reload' => true
        ));

        return $twig;
    }

}
