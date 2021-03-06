<?php

namespace keymener\myblog\entity;

/**
 * post entity
 *
 * @author keymener
 */
class Post
{

    private $id;
    private $title;
    private $chapeau;
    private $content;
    private $lastDate;
    private $published;
    private $userId;

  

    public function hydrate($data)
    {
        foreach ($data as $key => $value) {
            $method = 'set' . ucfirst($key);
            if (method_exists(__CLASS__, $method)) {
                $this->$method($value);
            }
        }
    }

    public function getId()
    {
        return $this->id;
    }

    public function getTitle()
    {
        return $this->title;
    }

    public function getChapeau()
    {
        return $this->chapeau;
    }

    public function getContent()
    {
        return $this->content;
    }

    public function getLastDate()
    {
        return $this->lastDate;
    }

    public function getPublished()
    {
        return $this->published;
    }

    public function getUserId()
    {
        return $this->userId;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function setTitle($title)
    {
        $this->title = $title;
    }

    public function setChapeau($chapeau)
    {
        $this->chapeau = $chapeau;
    }

    public function setContent($content)
    {
        $this->content = $content;
    }

    public function setLastDate($lastDate)
    {

        if (preg_match('#^\d{4}-\d{2}-\d{2} \d{2}:\d{2}:\d{2}$#', $lastDate)) {
            $this->lastDate = $lastDate;
        }
    }

    public function setPublished($published)
    {

        $this->published = (bool)$published;
    }

    public function setUserId($user)
    {
        $this->userId = $user;
    }
}
