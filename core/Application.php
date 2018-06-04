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
        //parse the ini file to list all backend controllers
        $check = parse_ini_file('../config/sessionCheck.ini');
      
        //get the controller name
            $controller = $this->router->getController();
           
           
        // if it goes to frontend OR a user is allready logged, 
        // we can call the instance
        if (!in_array($controller, $check) || isset($_SESSION['userId'])) {
            

            // get the method name
            $method = $this->router->getAction();

            // get the variable
            $var = $this->router->getVariable();

            // get controller
            $instance = $this->container->get($controller);
                   
            $instance->$method($var);
        }else{
            $backController = $this->container->get('keymener\myblog\controller\BackController');
            $backController->login();
        }
    }
    

}
