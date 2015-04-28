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

class Seeder {

    /**
     * @var Connection
     */
    protected $con;

    function __construct(Connection $con)
    {
        $this->con = $con;
    }

    public function runSeeder(SeederInterface $seeder){
        $seeds = $seeder->getSeeds();
        $seeder->visit($this);
    }

    /**
     * 一行を挿入するレコード
     * @param $table
     * @param array $values
     */
    public function acceptRow($table,array $row){
        $qb = $this->con->getQueryBuilder();
        $query = $qb->insert($table);
        $i = 0;
        foreach($row as $name=>$value){
            $query->setValue($name,"?");
            $query->setParameter($i,$value);
            $i++;
        }
        $query->execute();
    }
    /**
     * 一行を挿入するレコード
     * @param $table
     * @param array $values
     */
    public function acceptRows($table,array $rows){
        foreach($rows as $row){
            $this->acceptRow($table,$row);
        }
    }


}