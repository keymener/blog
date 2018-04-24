<?php

namespace keymener\myBlog\router;

/**
 * Description of Router
 *
 * @author keyme
 */
class Router
{

    private $_url;
    private $_controller;

    const CONTROLLER_POSITION = 0;

    public function __construct($url)
    {

        $this->setUrl($url);
        $this->setController();
    }

    /**
     * sets the controller from url
     * @throws \Exception
     */
    private function setController()
    {

        $controller = explode('/', $this->_url);
        $controller = trim($controller[self::CONTROLLER_POSITION]);
        if (isset($controller)) {

            $fullControllerName = 'keymener\\myblog\\controller\\' . $controller . 'Controller';

            if (class_exists($fullControllerName)) {

                $this->_controller = $fullControllerName;
            } else {

                $fullControllerName = 'keymener\\myblog\\controller\\IndexController';
                $this->_controller = $fullControllerName;
            }
        }
    }

    /**
     * calls the controller
     */
    public function callController()
    {

        $instance = new $this->_controller();

        return $instance;
    }

    private function setUrl($url)
    {

//        check if the url is like this: " /myblog/posts or /myblog/posts "
        if (preg_match('#^[a-z]*\/?[0-9]*$#', $url)) {
            $this->_url = $url;
        } else {
            throw new \Exception('mauvais format d\' url');
        }
    }

}
