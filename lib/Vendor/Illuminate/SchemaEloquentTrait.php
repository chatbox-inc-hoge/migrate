<?php
namespace Chatbox\Migrate\Vendor\Illuminate;
/**
 * Created by PhpStorm.
 * User: mkkn
 * Date: 2015/04/26
 * Time: 23:51
 */

use Chatbox\Migrate\Doctrine\Schema;

/**
 * Class SchemeEloquentTrait
 * @package Chatbox\Migrate\Vendor\Illuminate
 */
trait SchemaEloquentTrait {

    protected function setup(){
        $schema = $this->getSchema();
        $schema->getColumns();
        $this->table = $schema->getName();
        if(!$this->fillable){
            foreach($schema->getColumns() as $column){
                $this->fillable[] = $column->getName();
            }
        }
    }

    /**
     * @return Schema
     */
    abstract protected function getSchema();
}