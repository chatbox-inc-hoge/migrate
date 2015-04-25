<?php
/**
 * Created by PhpStorm.
 * User: mkkn
 * Date: 2015/04/25
 * Time: 4:35
 */

namespace Chatbox\Migrate\SQL;


class Connection {

    /**
     * @var \Doctrine\DBAL\Connection
     */
    protected $con;

    function __construct($con)
    {
        $this->con = \Doctrine\DBAL\DriverManager::getConnection($con);
    }

    public function getPlatform(){
        return $this->con->getDatabasePlatform();
    }

    public function runSQL($sql){
        $this->con->executeQuery($sql);
    }

    /**
     * get dbal query builder
     * http://doctrine-dbal.readthedocs.org/en/latest/reference/query-builder.html
     * @return \Doctrine\DBAL\Query\QueryBuilder
     */
    public function getQueryBuilder()
    {
        return $this->con->createQueryBuilder();
    }
}

