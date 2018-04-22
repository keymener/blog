<?php

require 'vendor/autoload.php';

try {

    $router = new \keymener\myblog\router\Router($_GET['url']);
    $router->CallController();
    
    
    
} catch (Exception $exc) {
    echo $exc->getMessage();
}
