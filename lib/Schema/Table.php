<?php
/**
 * Created by PhpStorm.
 * User: mkkn
 * Date: 2015/04/03
 * Time: 16:50
 */
namespace Chatbox\Migrate\Schema;
use Chatbox\Migrate\Schema\Column;
use Chatbox\Arr;
use Chatbox\Container\PropertyContainerTrait;

abstract class Table {

    use PropertyContainerTrait;

    private $tableName; // tableName
    private $engine;
    /**
     * @var Column[]
     */
    private $columns = [];
    private $indices = [];
    private $primary = [];

    function __construct($name,array $data = [])
    {
        $data = [
            "tableName" => $name
        ]+$data;
        $this->setData($data);
        $this->configure();
    }

    #region GETTER

    public function getTableName(){
        return $this->tableName;
    }

    /**
     * @return mixed
     */
    public function getEngine()
    {
        return $this->engine;
    }

    /**
     * @return Column[]
     */
    public function getColumns()
    {
        return $this->columns;
    }

    /**
     * @param $key
     * @return Column
     */
    public function getColumn($key){
        return $this->columns[$key];
    }

    /**
     * @return array
     */
    public function getIndices()
    {
        return $this->indices;
    }

    /**
     * @return array
     */
    public function getPrimary()
    {
        return $this->primary;
    }

    #endregion

    public function configure(){

    }

    public function addColumn(Column $column){
        $this->columns[$column->getName()] = $column;
    }

    /**
     * 必ず全てのカラムが登録された後に実行すること
     * @param array $keys
     */
    public function setPrimary(array $keys)
    {
        $this->primary = $keys;
    }

    abstract public function getEntity();

    public function getMetadata(\Doctrine\Common\Persistence\Mapping\ClassMetadata $metadata){
        $pk = $this->getPrimary();

        $columns = $this->getColumns();

        if(count($pk) === 1){
            $pk = reset($pk);
            $type = $columns[$pk]->getType();
            unset($columns[$pk]);
            $metadata->mapField([
                'id' => true,
                'fieldName' => $pk,
                'type' => $type
            ]);
        }

        foreach($columns as $col){
            $data = [
                'fieldName' => $col->getName(),
                'type' => $col->getType(),
                'options' => [
    //                    'fixed' => true,
                    'comment' => $col->getComment()
                ],
            ];
            $col->getUnsigned() && ($data["options"]["unsigned"] = true);
            ($default = $col->getDefault()) && ($data["options"]["default"] = $default);
            $data["nullable"] = $col->getNullable();

            $metadata->mapField($data);
        }
    }


}