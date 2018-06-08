<?php

namespace keymener\myblog\model;

use PDO;

/**
 * connection to database with pdo
 *
 * @author keymener
 */
class Database
{

    const DBHOST = 'localhost';
    const DBNAME = 'myblog';
    const DBUSER = 'root';
    const DBPASS = '';

    /**
     * instances a pdo object with our params
     * @return PDO
     */
    public function dbLaunch()
    {


        $db = new PDO('mysql:dbhost=' . self::DBHOST .
                ';dbname=' . self::DBNAME . ';'
                . 'charset=utf8', self::DBUSER, self::DBPASS);
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


        return $db;
    }
}
