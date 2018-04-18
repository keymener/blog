<?php

require 'vendor/autoload.php';

$loader = new Twig_Loader_Filesystem('view');
$twig = new Twig_Environment($loader, array(
    'cache' => 'tmp',
));



try {
   
    \keymener\myblog\controller\postController::add() ;
    
    
    
    
   
} catch (Exception $exc) {
    echo $exc->getMessage();
}
