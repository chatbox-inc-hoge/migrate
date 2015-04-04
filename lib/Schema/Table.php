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

class Table {

    use PropertyContainerTrait;

    protected $name;
    protected $engine;
    protected $columns = [];
    protected $indices = [];

    function __construct($name,array $data = [])
    {
        $data = [
            "name" => $name
        ]+$data;
        $this->setData($data);
        $this->configure();
    }

    #region GETTER

    public function getName(){
        return $this->name;
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
     * @return array
     */
    public function getIndices()
    {
        return $this->indices;
    }

    #endregion

    public function configure(){

    }

    public function addColumn(Column $column){
        $this->columns[$column->getName()] = $column;
    }



}