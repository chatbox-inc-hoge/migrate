<?php
/**
 * Created by PhpStorm.
 * User: mkkn
 * Date: 2015/04/03
 * Time: 16:50
 */
namespace Chatbox\Migrate\Schema;

use Chatbox\Arr;

class Column {

    protected $type;

    protected $name;

    protected $constraint;

    protected $unsigned;

    protected $default;

    protected $nullable;

    protected $autoIncrement;

    protected $comment;

    function __construct(array $data=[])
    {
        foreach($this as $key=>$value){
            if($value = Arr::get($data,$key)){
                $this->{$key} = $value;
            }
        }
    }

    # region Getters

    /**
     * @return mixed
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return null
     */
    public function getConstraint()
    {
        return $this->constraint;
    }

    /**
     * @return null
     */
    public function getUnsigned()
    {
        return $this->unsigned;
    }

    /**
     * @return null
     */
    public function getAutoIncrement()
    {
        return $this->autoIncrement;
    }

    /**
     * @return mixed
     */
    public function getDefault()
    {
        return $this->default;
    }

    /**
     * @return mixed
     */
    public function getNullable()
    {
        return $this->nullable;
    }

    /**
     * @return mixed
     */
    public function getComment()
    {
        return $this->comment;
    }

    # endregion







}