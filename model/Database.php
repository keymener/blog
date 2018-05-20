<?php

namespace keymener\myblog\model;

use PDO;

/**
 * connection to database with pdo
 *
 * @author keyme
 */
class Database
{

    private $dbName;
    private $dbHost;
    private $dbUser;
    private $dbPassword;

    public function __construct($dbName, $dbHost, $dbUser, $dbPassword)
    {

        $this->dbName = $dbName;
        $this->dbHost = $dbHost;
        $this->dbUser = $dbUser;
        $this->dbPassword = $dbPassword;
    }

    public function dbLaunch()
    {


        $db = new PDO('mysql:dbhost=' . $this->dbHost . ';dbname=' . $this->dbName . ';charset=utf8', $this->dbUser, $this->dbPassword);
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


        return $db;
    }

}
