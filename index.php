<?php
session_start();
require 'vendor/autoload.php';

// create instance of Router and send the url
$router = new keymener\myblog\core\Router($_GET['url']);

// create an instance of php-di Container
$container = new \DI\Container;

// create instance of Application
$application = new keymener\myblog\core\Application($router, $container);

//run the application
$application->run();




