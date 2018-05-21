<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace keymener\myblog\core;

/**
 * Description of Factory
 *
 * @author Keigo Matsunaga <keigo.matsunaga@gmail.com>
 */
class Factory
{

    const DBNAME = 'myblog';
    const DBHOST = 'localhost';
    const DBUSER = 'root';
    const DBPASSWORD = '';

    public function createManager($managerName)
    {
        $db = new \keymener\myblog\model\Database(self::DBNAME, self::DBHOST, self::DBUSER, self::DBPASSWORD);
        
        $managerName = '\\keymener\\myblog\\model\\' . ucfirst($managerName) . 'Manager';

        return new $managerName($db);
    }

}
