<?php
namespace Chatbox\Migrate\SQL\MySQL;
/**
 * Created by PhpStorm.
 * User: mkkn
 * Date: 2015/04/04
 * Time: 11:39
 */
use Chatbox\Migrate\Schema\Column;

class ColumnParser extends \Chatbox\Migrate\SQL\Common\ColumnParser{

    protected function getGrammer()
    {
        return new SQLGrammer();
    }

    public function createTable(Column $column){
        $sql   = [];

        $sql[] = $this->quote($column->getName());

        $type = $column->getType();
        if(is_array($column->getConstraint())){
            $constraint = $column->getConstraint();
            foreach($constraint as &$value){
                if(is_string($value)){
                    $value = "'$value'";
                }
            }
            $constraint = implode($constraint,",");
            $type .= "($constraint)";
        }elseif($column->getConstraint()){
            $type .= "({$column->getConstraint()})";
        }
        $sql[] = $type;

        if($column->getUnsigned()){
            $sql[] = "UNSIGNED";
        }

        if($default = $column->getDefault()){
            $sql[] = "DEFAULT $default";
        }

        $sql[] = ($column->getNullable())?"NULL":"NOT NULL";

        if($column->getAutoIncrement()){
            $sql[] = "AUTO_INCREMENT";
        }

        if($comment = $column->getComment()){
            $sql[] = "COMMNET $comment";
        }

//        if (array_key_exists('PRIMARY_KEY', $attr) and $attr['PRIMARY_KEY'] === true)
//        {
//            $sql .= ' PRIMARY KEY';
//        }
        return implode($sql," ");


    }

}