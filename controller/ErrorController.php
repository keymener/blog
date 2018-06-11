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
    private $codes;

    public function __construct(TwigLaunch $twig)
    {
        $this->twig = $twig;
        $this->codes = parse_ini_file('../config/errors.ini');
    }


    public function error($code)
    {
        $parameter = 'code'.$code;

        if(isset($this->codes[$parameter]))
        {

         $description = $this->codes['$code'];  

         $twig = $this->twig->twigLoad();
         echo $twig->render('errorPage.twig', [''
             . 'hide' => true,
             'code' => $code,
             'description' =>$description
         ]);
     }else{
        
        echo $twig->render('errorPage.twig', ['hide' => true]);
    }
}

}
