<?php

namespace keymener\myblog\controller;

/**
 * Description of Router
 *
 * @author keyme
 */
class Router
{

    private $_controller;
    private $_action;
    private $_variable;
    private $_urlArray;

    const CONTROLLER_POSITION = 0;
    const ACTION_POSITION = 1;
    const VARIABLE_POSITION = 2;

    public function __construct($url)
    {
        $this->hydrate($url);
    }

    private function hydrate($url)
    {

        $this->setUrlArray($url);

        if (!empty($this->_urlArray[self::CONTROLLER_POSITION])) {
            $this->setController($this->_urlArray[self::CONTROLLER_POSITION]);
        } else {
            $this->setController('home');
            
        }
        if (!empty($this->_urlArray[self::ACTION_POSITION])) {
            $this->setAction($this->_urlArray[self::ACTION_POSITION]);
        }else{
            $this->setAction('home');
         
        }
        if (isset($this->_urlArray[self::VARIABLE_POSITION])) {
            $this->setVariable($this->_urlArray[self::VARIABLE_POSITION]);
        }else{
            $this->_urlArray[self::VARIABLE_POSITION] = null;
        }
    }

    public function callController()
    {
        $controller = new $this->_controller();
        return $controller;
        
     
    }

    //getters
    public function getAction()
    {
        return $this->_action;
    }

    public function getVariable()
    {
        return $this->_variable;
    }

    // setters

    function setUrlArray($url)
    {

        $urlArray = explode('/', $url);

        $this->_urlArray = $urlArray;
    }

    function setController($controller)
    {


        $controllerName = 'keymener\\myblog\\controller\\' . $controller . 'Controller';

        if (class_exists($controllerName)) {

            $this->_controller = $controllerName;
        } else {

            $this->_controller = 'keymener\\myblog\\controller\\HomeController';
        }
    }

    function setAction($action)
    {
        if (isset($action)) {

            $method = $action;

            if (method_exists($this->_controller, $method)) {

                $this->_action = $method;
            } else {

                throw new \Exception('method ' . $method . ' doesn\'t exists');
            }
        } else {

            $this->_action = null;
        }
    }

    function setVariable($variable)
    {
        $var = (int) $variable;
        $this->_variable = $var;
    }

}
