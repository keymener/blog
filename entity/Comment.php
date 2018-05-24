<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace keymener\myblog\entity;

/**
 * Description of Comment
 *
 * @author Keigo Matsunaga <keigo.matsunaga@gmail.com>
 */
class Comment
{
    private $id;
    private $content;
    private $dateTime;
    private $pubished = false;
    private $post_id;
    private $user_id;
    
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

    public function getContent()
    {
        return $this->content;
    }

    public function getDateTime()
    {
        return $this->dateTime;
    }

    public function getPubished()
    {
        return $this->pubished;
    }

    public function getPost_id()
    {
        return $this->post_id;
    }

    public function getUser_id()
    {
        return $this->user_id;
    }

    public function setId($id)
    {
        $this->id = (int)$id;
    }

    public function setContent($content)
    {
        $this->content = $content;
    }

    public function setDateTime($dateTime)
    {
        $this->dateTime = $dateTime;
    }

    public function setPubished($pubished)
    {
        $this->pubished = (bool)$pubished;
    }

    public function setPost_id($post_id)
    {
        $this->post_id = (int)$post_id;
    }

    public function setUser_id($user_id)
    {
        $this->user_id = (int)$user_id;
    }


}
