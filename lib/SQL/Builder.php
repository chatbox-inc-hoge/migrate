<?php
namespace Chatbox\Migrate\SQL;
/**
 * Created by PhpStorm.
 * User: mkkn
 * Date: 2015/04/21
 * Time: 21:33
 */

use Doctrine\DBAL\Schema\Visitor\DropSchemaSqlCollector;
use Chatbox\Migrate\Doctrine\Schema;

class Builder {

    /**
     * @var \Doctrine\DBAL\Connection
     */
    protected $con;
    /**
     * @var \Doctrine\DBAL\Platforms\AbstractPlatform
     */
    protected $platform;

    function __construct($con)
    {
        $this->con = \Doctrine\DBAL\DriverManager::getConnection($con);
        $this->platform = $this->con->getDatabasePlatform();
    }

    public function runSql($sql){
        $this->con->executeQuery($sql);
    }

    public function createSchema(Schema $schema){
        return $schema->toSql($this->platform);

    }

    public function dropSchema(Schema $schema){
        $visitor = new DropSchemaSqlCollector($this->platform);
        $schema->visit($visitor);
        return $visitor->getQueries();
    }


}