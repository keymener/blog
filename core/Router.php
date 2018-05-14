<?php

namespace keymener\myblog\core;

/**
 * get an url and you can call the controller , action and variable
 *
 * @author keyme
 */
class Router
{

    private $controller;
    private $action;
    private $variable;
    private $urlArray;

    const CONTROLLER_POSITION = 0;
    const ACTION_POSITION = 1;
    const VARIABLE_POSITION = 2;
    const PREFIX = 'keymener\\myblog\\controller\\';

    public function __construct($url)
    {
        $this->hydrate($url);
    }

    private function hydrate($url)
    {

        $this->setUrlArray($url);

        if (!empty($this->urlArray[self::CONTROLLER_POSITION])) {
            $this->setController($this->urlArray[self::CONTROLLER_POSITION]);
        } else {
            $this->setController('front');
        }
        if (!empty($this->urlArray[self::ACTION_POSITION])) {
            $this->setAction($this->urlArray[self::ACTION_POSITION]);
        } else {
            $this->setAction('home');
        }
        if (isset($this->urlArray[self::VARIABLE_POSITION])) {
            $this->setVariable($this->urlArray[self::VARIABLE_POSITION]);
        } else {
            $this->urlArray[self::VARIABLE_POSITION] = null;
        }
    }

    //public getters
    public function getController()
    {
        return $this->controller;
    }

    public function getAction()
    {
        return $this->action;
    }

    public function getVariable()
    {
        return $this->variable;
    }

    // private setters

    private function setUrlArray($url)
    {

        $urlArray = explode('/', $url);

        $this->urlArray = $urlArray;
    }

    private function setController($controller)
    {


        $controllerName = self::PREFIX . ucfirst($controller) . 'Controller';

        if (class_exists($controllerName)) {
            $this->controller = $controllerName;
        } else {
            $this->controller = self::PREFIX . 'FrontController';
        }
    }

    private function setAction($action)
    {
        if (isset($action)) {
            $method = $action;


            if ($this->controller == self::PREFIX . 'FrontController') {
                $this->action = 'home';
            } elseif (method_exists($this->controller, $method)) {
                $this->action = $method;
            } else {
                throw new \Exception('method ' . $method . ' doesn\'t exists');
            }
        }
    }

    private function setVariable($variable)
    {
        $var = (int) $variable;
        $this->variable = $var;
    }

}
