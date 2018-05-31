<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace keymener\myblog\core;

/**
 * Description of Email
 *
 * @author Keigo Matsunaga <keigo.matsunaga@gmail.com>
 */
class Email
{
    private $name;
    private $email;
    private $content;

    public function format()
    {
        return '<b>Nom et Prénom:</b> ' . $this->name . '<br />'
                . '<b>Email :</b> ' . $this->email . '<br />'
                . '<b>Message:</b><p>' . $this->content . '</p>';
    }


    public function setName($name)
    {
        $this->name = htmlentities($name);
    }

    public function setEmail($email)
    {
        $this->email = htmlentities($email);
    }

    public function setContent($content)
    {
        $this->content = htmlentities($content);
    }



}
