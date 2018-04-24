<?php

require 'vendor/autoload.php';

try {

    $router = new \keymener\myblog\router\Router($_GET['url']);
    $router->callController();
} catch (Exception $exc) {
    echo $exc->getMessage();
}
