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

/**
 * Seed関連のSQL処理
 * @package Chatbox\Migrate\SQL
 */
class SeederProcessor {

    /**
     * @var Connection
     */
    protected $con;

    function __construct(Connection $con)
    {
        $this->con = $con;
    }

    /**
     * 複数行を挿入する処理
     * @param $table
     * @param array $values
     */
    public function insertRows($table,array $rows){
        foreach($rows as $row){
            $this->insertRow($table,$row);
        }
    }

    /**
     * 一行を挿入する処理
     * @param $table
     * @param array $values
     */
    protected function insertRow($table,array $row){
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
     * 行を削除する処理
     * @param $table
     * @param callable $cond
     */
    public function deleteRows($table,callable $cond=null){
        $qb = $this->con->getQueryBuilder();
        $query = $qb->delete($table);
        if($cond){
            $query = $cond($query);
        }
        $query->execute();
    }



}