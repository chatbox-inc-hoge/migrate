<?php
/**
 * Created by PhpStorm.
 * User: mkkn
 * Date: 2015/04/03
 * Time: 16:50
 */
namespace Chatbox\Migrate\Schema;

class Index {

    protected $type;

    protected $name;

    protected $columns;

    function __construct($type, $name, $constraint=null, $unsigned=null, $autoIncrement=null)
    {
        $this->type = $type;
        $this->name = $name;
        $this->constraint = $constraint;
        $this->unsigned = $unsigned;
        $this->autoIncrement = $autoIncrement;
    }

    public function getName(){
        return $this->name;
    }


}