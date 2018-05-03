<?php

namespace keymener\myblog\model;

/**
 * connection to database with pdo
 *
 * @author keyme
 */
abstract class DbConnect
{

    const DBNAME = 'myblog';
    const DBHOST = 'localhost';
    const DBUSER = 'root';
    const DBPASSWORD = '';

    protected $db;

    protected function dblaunch()
    {

        $dbname = self::DBNAME;
        $dbhost = self::DBHOST;
        $dbuser = self::DBUSER;
        $dbpwd = self::DBPASSWORD;

        $db = new \PDO('mysql:dbhost=' . $dbhost . ';dbname=' . $dbname . ';charset=utf8', $dbuser, $dbpwd);
        $db->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
        $this->setDb($db);
    }

    function getDb(): \PDO
    {
        return $this->db;
    }

    function setDb(\PDO $db)
    {
        $this->db = $db;
    }

}
