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

/**
 * generate a error page
 * @param int $code
 */
    public function error($code)
    {

        //set the http status code
        http_response_code($code);
        
               
        if(!empty($this->codes[$code]))
        {

         $description = $this->codes[$code];  

         $twig = $this->twig->twigLoad();
         echo $twig->render('errorPage.twig', [''
             . 'hide' => true,
             'code' => $code,
             'description' =>$description
         ]);
     }else{
        
        $this->error(500);
        die();
    }
}

}
