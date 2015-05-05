<?php
/**
 * Created by PhpStorm.
 * User: mkkn
 * Date: 2015/04/21
 * Time: 22:36
 */

namespace Chatbox\Migrate\Doctrine;

use Doctrine\DBAL\Types\Type;
use Doctrine\DBAL\Schema\Column;

trait BasicColumnTrait {

    // Numbers

    public function addInteger($name,array $options=[]){
        return $this->addColumn($name,Type::INTEGER,$options);
    }

    public function addInt($name,array $options=[]){
        return $this->addInteger($name,$options);
    }

    public function addBigint($name,array $options=[]){
        return $this->addColumn($name,Type::BIGINT,$options);
    }

    public function addSmallInt($name,array $options=[]){
        return $this->addColumn($name,Type::SMALLINT,$options);
    }

    public function addGUID($name,array $options=[]){
        return $this->addColumn($name,Type::GUID,$options);
    }

    public function addDecimal($name,array $options=[]){
        return $this->addColumn($name,Type::DECIMAL,$options);
    }

    public function addFloat($name,array $options=[]){
        return $this->addColumn($name,Type::FLOAT,$options);
    }

    // Bool

    public function addBoolean($name,array $options=[]){
        return $this->addColumn($name,Type::BOOLEAN,$options);
    }

    public function addBool($name,array $options=[]){
        return $this->addBoolean($name,$options);
    }

    // Time

    public function addDate($name,array $options=[]){
        return $this->addColumn($name,Type::DATE,$options);
    }

    public function addDatetime($name,array $options=[]){
        return $this->addColumn($name,Type::DATETIME,$options);
    }

    public function addDatetimez($name,array $options=[]){
        return $this->addColumn($name,Type::DATETIMETZ,$options);
    }

    public function addTime($name,array $options=[]){
        return $this->addColumn($name,Type::TIME,$options);
    }

    // TEXT/Big Data

    public function addString($name,array $options=[]){
        return $this->addColumn($name,Type::STRING,$options);
    }

    public function addText($name,array $options=[])
    {
        return $this->addColumn($name, Type::TEXT, $options);
    }

    public function addBinary($name,array $options=[]){
        return $this->addColumn($name,Type::BINARY,$options);
    }

    public function addBlob($name,array $options=[]){
        $this->addColumn($name,Type::BLOB,$options);
    }

    // Object

    public function addTArray($name,array $options=[]){
        return $this->addColumn($name,Type::TARRAY,$options);
    }

    public function addJsonArray($name,array $options=[]){
        return $this->addColumn($name,Type::JSON_ARRAY,$options);
    }

    public function addSimpleArray($name,array $options=[]){
        return $this->addColumn($name,Type::SIMPLE_ARRAY,$options);
    }

    public function addObject($name,array $options=[]){
        return $this->addColumn($name,Type::OBJECT,$options);
    }

    /**
     * @param $columnName
     * @param $typeName
     * @param array $options
     * @return Column
     */
    abstract public function addColumn($columnName, $typeName, array $options = array());
}