<?php
/**
 * Created by PhpStorm.
 * User: mkkn
 * Date: 2015/04/03
 * Time: 16:50
 */
namespace Chatbox\Migrate\Schema;
use Chatbox\Migrate\Schema\Column;

class Table {

    protected $name;
    protected $engine;
    protected $columns = [];
    protected $indices = [];

    function __construct($name)
    {
        $this->name = $name;
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

    public function addColumn(Column $column){
        $this->columns[$column->getName()] = $column;
    }



}