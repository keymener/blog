<?php

namespace keymener\myblog\core;

use Twig_Environment;
use Twig_Loader_Filesystem;

/**
 * Generate the twig view
 *
 * @author keymener
 */
class TwigLaunch
{

    const TWIGFILES = '../view';
    const TWIGTMP = 'tmp';

    /**
     * instances twig loader and twig environment
     * @return Twig_Environment
     */
    public static function twigLoad()
    {

        $loader = new Twig_Loader_Filesystem(self::TWIGFILES);
        $twig = new Twig_Environment($loader, array(
            'cache' => false
                
        ));

        return $twig;
    }
}
