<?php

namespace keymener\myblog\controller;

/**
 * Permet de generer le twig loader
 *
 * @author keyme
 */
class MainController {

    const TWIGFILES = 'view';
    const TWIGTMP = 'tmp';

    protected $twig ;

    protected function twig() {
        $loader = new \Twig_Loader_Filesystem(self::TWIGFILES);
        $twig = new \Twig_Environment($loader, array(
            'cache' => self::TWIGTMP,
            'auto_reload' => true
        ));

        $this->setTwig($twig);
    }

    private function setTwig($twig) {
        $this->twig = $twig;
    }

}
