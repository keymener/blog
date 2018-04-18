<?php

namespace keymener\myblog\model;

/**
 * post entity
 *
 * @author keyme
 */
class Post {

    private $_int;
    private $_title;
    private $_chapeau;
    private $_content;
    private $_lastdate;
    private $_published;

    public function __construct(array $data) {
        $this->hydrate($data);
    }

    private function hydrate($data) {
        foreach ($data as $key => $value) {

            $method = 'set' . ucfirst($key);
            if (method_exists(__CLASS__, $method)) {

                $this->$method($value);
            }
        }
    }

    function getInt() {
        return $this->_int;
    }

    function getTitle() {
        return $this->_title;
    }

    function getChapeau() {
        return $this->_chapeau;
    }

    function getContent() {
        return $this->_content;
    }

    function getLastdate() {
        return $this->_lastdate;
    }

    function getPublished() {
        return $this->_published;
    }

    function setInt($int) {
        $this->_int = $int;
    }

    function setTitle($title) {
        $this->_title = $title;
    }

    function setChapeau($chapeau) {
        $this->_chapeau = $chapeau;
    }

    function setContent($content) {
        $this->_content = $content;
    }

    function setLastdate($lastdate) {
        $this->_lastdate = $lastdate;
    }

    function setPublished($published) {
        $this->_published = $published;
    }

}
