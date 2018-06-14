<?php



namespace keymener\myblog\core;

use DI\Container;


/**
 * get the router and instances the controller
 *
 * @author keymener
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

    /**
     * checks if the called controller needs authentication and instances it
     */
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
            $backController->logMe();
        }
    }
    

}
