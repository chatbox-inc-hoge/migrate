<?php
/**
 * Created by PhpStorm.
 * User: mkkn
 * Date: 2015/04/05
 * Time: 18:10
 */
namespace Chatbox\Migrate\Util;

use Chatbox\Migrate\Schema\Table;
use Chatbox\Traits\InstanceManager;
/**
 * 専用のEntity Managerを生成するクラス。
 * @package Chatbox\Migrate\Util
 */
abstract class SchemaContainer {

    use InstanceManager;

    protected $prefix;

    private $schemaFactories = [];
    /**
     * @var Table[]
     */
    private $result = [];

    function __construct($prefix=null)
    {
        if($prefix){
            $this->prefix = $prefix;
        }

        if(!$this->prefix){
            throw new \Exception("table prefix must be configured");
        }
        $this->configure();
    }

    abstract public function configure();

    protected function addSchema($name,$schema){
        if($schema instanceof Table){
            $this->result[$name] = $schema;
        }else if(is_callable($schema)){
            $this->schemaFactories[$name] = $schema;
        }else{
            throw new \Exception("invalid argument");
        }
    }

    /**
     * @param $name
     * @return Table
     * @throws \Exception
     */
    public function getSchema($name){
        if(isset($this->result[$name])){
            return $this->result[$name];
        }

        if(isset($this->schemaFactories[$name])){
            $result =  $this->schemaFactories[$name]();
            if($result instanceof Table){
                $this->result[$name] = $result;
                return $this->getSchema($name);
            }else{
                throw new \Exception("invalid return value");
            }
        }
        throw new \Exception("dont exist schema $name reffered");
    }

    protected function tableName($name){
        return "{$this->prefix}_$name";
    }

    public function getEntityClassMap(){
        $rtn = [];
        $tableKeys = array_merge(
            array_keys($this->result),
            array_keys($this->schemaFactories)
        );
        $tableKeys = array_unique($tableKeys);
        foreach($tableKeys as $key){
            $schema = $this->getSchema($key);
            $entityClass = $schema->getEntity();
            $entityClassName = get_class($entityClass);
            $rtn[$entityClassName] = $schema;
        }
        return $rtn;
    }

    /**
     * @return Table[]
     */
    public function toArray(){
        $rtn = [];
        foreach($this->schemaFactories as $key => $factory){
            $rtn[] = $this->getSchema($key);
        }
        return $rtn;
    }




}