<?php
/**
 * Created by PhpStorm.
 * User: mkkn
 * Date: 2015/04/05
 * Time: 3:26
 */

namespace Chatbox\Migrate\Command\Config;

use Chatbox\Migrate\Command\Config;
use Chatbox\Migrate\Schema\Table;

use Chatbox\Migrate\Util\SchemaContainer;
use Chatbox\Migrate\SQL\CreateTable;


class TableConfig {

    protected $groups = [];

    protected $alias = [];


    function __construct(Config $config)
    {
        $data = $config->getItem("table");
        if(isset($data["include"])){
            $include = $data["include"];
            unset($data["include"]);
            foreach($include as $key=>$tables){
                $this->createGroup($key);
                $this->parseTables($key,$tables);
            }
        }
        foreach($data as $key=>$tables){
            $this->createGroup($key);
            $this->parseTables($key,$tables);
        }
    }

    public function parseTables($key,$tables){
        if($tables instanceof SchemaContainer){
            return $this->parseTables($key,$tables->toArray());
        }elseif(is_array($tables)){
            foreach($tables as $table){
                $this->addTable($key,$table);
            }
        }else{
            throw new \Exception("invalid argument supplied");
        }

    }

    public function createGroup($groupName){
        if(isset($this->groups[$groupName])){
            throw new \Exception("the group $groupName is already created");
        }else{
            $this->groups[$groupName] = [];
        }
    }

    public function addTable($groupName,$data){
        if(isset($this->groups[$groupName])){
            if($data instanceof Table){
                $this->groups[$groupName][] = $data;
            }else{
                throw new \Exception("unsupported type value supplied");
            }
        }else{
            throw new \Exception("the group $groupName doesnt exits");
        }
    }

    /**
     * @param $groupName
     * @return Table[]
     */
    public function getGroup($groupName){
        if(isset($this->groups[$groupName])){
            return $this->groups[$groupName];
        }else{
            throw new \Exception("the group $groupName doesnt exits");
        }
    }

//    public function getGroupSql($groupName){
//        $sql = "";
//        foreach($this->getGroup($groupName) as $table){
//            $parser = new CreateTable();
//            $sql .= $parser->sql($table);
//        }
//        return $sql;
//    }

    public function describe(){
        $lines = [];
        foreach($this->groups as $groupName => $tables){
            $tables = $this->getGroup($groupName);
            $tableDescribe = [];
            foreach($tables as $table){
                $tableDescribe[] = $table->getName();
            }
            $lines[] = "[$groupName] ".implode($tableDescribe,"/");
        }
        return implode($lines,PHP_EOL);
    }


}