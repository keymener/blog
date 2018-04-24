<?php

namespace keymener\myblog\model;

/**
 * post entity
 *
 * @author keyme
 */
class Post
{

    private $_int;
    private $_title;
    private $_chapeau;
    private $_content;
    private $_lastDate;
    private $_published;
    private $_adminUser;

    public function __construct(array $data)
    {
        $this->hydrate($data);
    }

    private function hydrate($data)
    {
        foreach ($data as $key => $value) {

            $method = 'set' . ucfirst($key);
            if (method_exists(__CLASS__, $method)) {

                $this->$method($value);
            }
        }
    }

    function getInt()
    {
        return $this->_int;
    }

    function getTitle()
    {
        return $this->_title;
    }

    function getChapeau()
    {
        return $this->_chapeau;
    }

    function getContent()
    {
        return $this->_content;
    }

    function getLastDate()
    {
        return $this->_lastDate;
    }

    function getPublished()
    {
        return $this->_published;
    }

    function getAdminUser()
    {
        return $this->_adminUser;
    }

    function setInt($int)
    {
        $this->_int = $int;
    }

    function setTitle($title)
    {
        $this->_title = $title;
    }

    function setChapeau($chapeau)
    {
        $this->_chapeau = $chapeau;
    }

    function setContent($content)
    {
        $this->_content = $content;
    }

    function setLastDate($lastDate)
    {

        if (preg_match('#^\d{4}-\d{2}-\d{2} \d{2}:\d{2}:\d{2}$#', $lastDate)) {
            $this->_lastDate = $lastDate;
        }
    }

    function setPublished($published)
    {
        if (is_bool($published)) {
            $this->_published = $published;
        }
    }

    function setAdminUser($adminUser)
    {
        $this->_adminUser = $adminUser;
    }

}
