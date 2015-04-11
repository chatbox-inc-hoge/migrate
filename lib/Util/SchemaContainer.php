<?php
/**
 * Created by PhpStorm.
 * User: mkkn
 * Date: 2015/04/05
 * Time: 18:10
 */
namespace Chatbox\Migrate\Util;

use Chatbox\Migrate\Schema\Table;

abstract class SchemaContainer {

    use InstanceManager;

    protected $prefix;

    private $schemaFactories = [];
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