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

    const DBHOST = 'yourdbhost';
    const DBNAME = 'yourdbname';
    const DBUSER = 'yourdbuser';
    const DBPASS = 'yourdbpassword';
    const DBPORT = 3306 ;

    /**
     * instances a pdo object with our params
     * @return PDO
     */
    public function dbLaunch()
    {
    	$dsn = 'mysql:host='.self::DBHOST.';port='.self::DBPORT.';dbname='.self::DBNAME.';charset=utf8';

        $db = new PDO($dsn , self::DBUSER, self::DBPASS);
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


        return $db;
    }
}
