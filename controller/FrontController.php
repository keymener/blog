<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace keymener\myblog\controller;

/**
 * Description of FrontController
 *
 * @author Keigo Matsunaga <keigo.matsunaga@gmail.com>
 */
class FrontController
{
    private $mailer;
    
    public function __construct(\PHPMailer $mailer)
    {
        $this->mailer = $mailer;
        
    }
}
