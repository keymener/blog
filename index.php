<?php
session_start();
require 'vendor/autoload.php';

$router = new keymener\myblog\core\Router($_GET['url']);
$controller = $router->getController();
$action = $router->getAction();
$var = $router->getVariable();


$controllerInstance = new $controller();
call_user_func_array(array($controllerInstance, $action),array($var));
