<?php
/**
 * Created by PhpStorm.
 * User: mkkn
 * Date: 2015/04/04
 * Time: 14:55
 */

namespace Chatbox\Migrate\Schema;

use Chatbox\Migrate\Schema\Column;

trait BasicColumnTrait {

    /** @return Column */
    protected function colId($name,$autoIncrement=null,array $data=[]){
        return $this->createColumn([
            "type" => "INT",
            "name" => "$name",
            "unsigned" => true,
            "autoIncrement" => $autoIncrement
        ],$data);
    }

    /** @return Column */
    protected function colUnsignedInt($name,array $data=[]){
        return $this->createColumn([
            "type" => "INT",
            "name" => "$name",
            "unsigned" => true
        ],$data);
    }
    /** @return Column */
    protected function colInt($name,array $data=[]){
        return $this->createColumn([
            "type" => "INT",
            "name" => "$name",
        ],$data);
    }
    /** @return Column */
    protected function colBool($name,array $data=[]){
        return $this->createColumn([
            "type" => "TINYINT",
            "name" => "$name",
            "unsigned" => true
        ],$data);
    }

    /** @return Column */
    protected function colString($name,$constraint=255,array $data=[]){
        return $this->createColumn([
            "type" => "VARCHAR",
            "name" => "$name",
            "constraint" => $constraint
        ],$data);
    }

    /** @return Column */
    protected function colText($name,array $data=[]){
        return $this->createColumn([
            "type" => "TEXT",
            "name" => "$name",
        ],$data);
    }
    /** @return Column */
    protected function colDate($name,array $data=[]){
        return $this->createColumn([
            "type" => "DATE",
            "name" => "$name",
        ],$data);
    }
    /** @return Column */
    protected function colDatetime($name,array $data=[]){
        return $this->createColumn([
            "type" => "DATETIME",
            "name" => "$name",
        ],$data);
    }

    private function createColumn($data,$optionalData){
        $data = $data + $optionalData;
        return $this->addColumn(new Column($data));
    }

    protected function colCreatedAt($name = "created_at"){
        return $this->colDatetime("created_at");
    }
    protected function colUpdatedAt($name = "updated_at"){
        return $this->colDatetime("updated_at");
    }

    protected function setSurrogateKey($name="id"){
        $this->colId($name,true);
        $this->setPrimary([$name]);
    }

    protected function setDatetime(){
        $this->colCreatedAt();
        $this->colUpdatedAt();
    }


    abstract public function addColumn(Column $column);
    abstract public function setPrimary(array $keys);

}