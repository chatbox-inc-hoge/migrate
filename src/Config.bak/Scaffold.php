<?php
namespace Migrate\Config;
/**
 * Created by PhpStorm.
 * User: mkkn
 * Date: 2014/12/13
 * Time: 16:50
 */

class Scaffold extends Base{

    protected $type;

    /**
     * @param $tableName
     * @param $cols
     * @return \Migrate\Scaffold
     * @throws \Exception
     */
    public function forgeScaffold($tableName,$cols){
        if($this->type === "fuelphp_crud"){
            return new \Migrate\Scaffold\Fuelphp\Crud($tableName,$cols,$this);
        }else{
            throw new \Exception("unsupported scaffold type");
        }
    }
    /**
     * これはちょっと芋いなぁ…
     * @param $type
     */
    public function setType($type){
        $this->type = $type;
        return $this;
    }

    public function getType(){
        return $this->type;
    }

    public function getNamespace(){
        return $this->get("{$this->type}.namespace");
    }

    public function getPrefix(){
        return $this->get("{$this->type}.prefix");
    }

    public function getParentClass(){
        return $this->get("{$this->type}.parentClass");
    }

    public function getOutput(){
        return $this->get("{$this->type}.output");
    }


}
