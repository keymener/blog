<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace keymener\myblog\core;

use DI\Container;

/**
 * Description of Application
 *
 * @author Keigo Matsunaga <keigo.matsunaga@gmail.com>
 */
class Application
{

    private $router;
    private $container;
   
    public function __construct(Router $router, Container $container)
    {
        $this->router = $router;
        $this->container = $container;
       
    }

    public function run()
    {
           
        
        //get the controller name
        $controller = $this->router->getController();

        // get the method name
        $method = $this->router->getAction();

        // get the variable
        $var = $this->router->getVariable();

        // call controller
        $instance = $this->container->get($controller);

        $instance->$method($var);
    }

}
