<?php
/**
 * Created by PhpStorm.
 * User: mkkn
 * Date: 2015/04/04
 * Time: 11:36
 */
namespace Chatbox\Migrate\SQL;

use Chatbox\Migrate\Schema\Table;

class TableQuery {

    const INDEX_PRIMARY = 1;

    protected $columnParser;
    protected $br;

    function __construct()
    {
        $this->columnParser = new \Chatbox\Migrate\SQL\MySQL\ColumnParser();
        $this->br = PHP_EOL;
    }

    public function dropTable(Table $table,$if_exists=true){
        $sql  = "DROP TABLE ";
        $sql .= ($if_exists)?"IF EXISTS ":"";
        $sql .= $this->columnParser->quote($table->getName());
        $sql .= ";{$this->br}";
        return $sql;
    }

    public function createTable(Table $table,$if_not_exists=true)
    {
        $statement = [];
        foreach($table->getColumns() as $column){
            $statement[] = $this->columnParser->createTable($column);
        }
        if($table->getPrimary()){
            $statement[] = $this->indexStatement("pkIndex",$table->getPrimary(),static::INDEX_PRIMARY);
        }

        $br = $this->br;

        $sql  = 'CREATE TABLE ';
        $sql .= $if_not_exists ? 'IF NOT EXISTS ' : '';
        $sql .= $this->columnParser->quote($table->getName()).' (';
        $sql .= "$br    ".implode($statement,",$br    ");

        $sql .= "$br);$br";

//        if($engine = $table->getEngine()){
//            $sql .= "ENGINE = $engine";
//        }
        return $sql;
    }

    protected function indexStatement($name,array $columns,$type){
        if($type === static::INDEX_PRIMARY){
            $sql = "PRIMARY KEY $name ";
            $columns = array_map(function($val){
                return $this->columnParser->quote($val);
            },$columns);
            $sql .= "(".implode($columns,",").")";
            return $sql;
        }else{
            throw new Exception("unknown index type");
        }



    }



}