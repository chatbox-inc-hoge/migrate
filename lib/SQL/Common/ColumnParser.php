<?php
namespace Chatbox\Migrate\SQL\Common;
/**
 * Created by PhpStorm.
 * User: mkkn
 * Date: 2015/04/04
 * Time: 11:39
 */
use Chatbox\Traits\Facade;
use Chatbox\Migrate\Schema\Column;

abstract class ColumnParser {
    use Facade;

    /**
     * @var SQLGrammer
     */
    protected $grammer;

    function __construct()
    {
        $this->grammer = $this->getGrammer();
    }

    protected function quote($value){
        return $this->grammer->quote($value);
    }

    abstract protected function getGrammer();

    abstract protected function createTable(Column $column);



}