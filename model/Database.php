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

    private $dbhost ;
    private $dbname ;
    private $dbuser ;
    private $dbpassword ;
    private $dbport ;

    public function __construct()
    {
        $config = parse_ini_file('../config/database.ini', true);
        $this->dbhost = $config['database']['dbhost'];
        $this->dbname = $config['database']['dbname'];
        $this->dbuser = $config['database']['dbuser'];
        $this->dbpassword = $config['database']['dbpassword'];
        $this->dbport = $config['database']['dbport'];
    }

    /**
     * instances a pdo object with our params
     * @return PDO
     */
    public function dbLaunch()
    {
        $dsn = 'mysql:host='.$this->dbhost.';port='.$this->dbport.';dbname='.$this->dbname.';charset=utf8';

        $db = new PDO($dsn , $this->dbuser, $this->dbpassword);
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


        return $db;
    }
}
