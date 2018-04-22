<?php

namespace keymener\myblog\router;

/**
 * Description of Router
 *
 * @author keyme
 */
class Router {

    private $_url;
    private $_controller;
    private $_id;

    const CONTROLLER_POSITION = 0;
    const ID_POSITION = 1;

    public function __construct($url) {

  
        $this->setUrl($url);
        $this->urlExplode();
       
       
    }

    private function urlExplode() {

        $urlArray = explode("/", $this->_url);

        if (isset($urlArray[self::CONTROLLER_POSITION])) {

            $this->setController($urlArray[self::CONTROLLER_POSITION]);
        }elseif (isset($urlArray[self::ID_POSITION])) {

            $this->setId($urlArray[self::ID_POSITION]);
        }
    }

    
    public function CallController() {

        $calledController = $this->getController();
        
        $controller = new $calledController();
        
       
    }

    private function getController() {
        return $this->_controller;
    }

    function getId() {
        return $this->_id;
    }

    private function getUrl() {

        return $this->_url;
    }

    private function setController($controller) {

        $controller = 'keymener\\myblog\\controller\\' . ucfirst($controller) . 'Controller';

        if (class_exists($controller)) {

            $this->_controller = $controller;
        } else {

            throw new \Exception('La classe ' . $controller . ' n\'existe pas.');
        }
    }

    private function setId($id) {
        
        $intId = (int)$id ;
        
        $this->_id = $intId;
    }

    private function setUrl($url) {

//        check if the url is like this: " /myblog/posts or /myblog/posts "
        if (preg_match('#^[a-z]*\/?[0-9]*$#', $url)) {
            $this->_url = $url;
        } else {
            throw new \Exception('mauvais format d\' url');
        }
    }

}
