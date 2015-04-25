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
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Tools\Setup;

class Builder {

    /**
     * @var Connection
     */
    protected $con;

    function __construct(Connection $con)
    {
        $this->con = $con;
    }


    public function runSql($sql){
        $this->con->runSQL($sql);
    }

    public function createSchema(Schema $schema){
        return $schema->toSql($this->con->getPlatform());

    }

    public function dropSchema(Schema $schema){
        $visitor = new DropSchemaSqlCollector($this->con->getPlatform());
        $schema->visit($visitor);
        return $visitor->getQueries();
    }


}