<?php

require 'vendor/autoload.php';

try {
    
    $router = new \keymener\myblog\controller\Router($_GET['url']);
    $instance = $router->callController();
    $method = $router->getAction();
    $id = $router->getVariable();
    
    call_user_func_array(array($instance, $method), array($id));
    
    
} catch (Exception $exc) {
    echo $exc->getMessage();
}
