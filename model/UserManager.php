<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace keymener\myblog\model;

/**
 * Description of UserManager
 *
 * @author Keigo Matsunaga <keigo.matsunaga@gmail.com>
 */
class UserManager extends DbConnect
{
    public function __construct()
    {
        $this->dblaunch();
    }
}
