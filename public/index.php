<?php
session_start();

use DI\Container;
use keymener\myblog\core\Application;
use keymener\myblog\core\Router;

require '../vendor/autoload.php';

// create instance of Router and send the url
$url = empty($_GET['url']) ? 'blog/home' : $_GET['url'];

$router = new Router($url);

// create an instance of php-di Container
$container = new Container;


// create instance of Application
$application = new Application($router, $container);

//run the application
$application->run();




