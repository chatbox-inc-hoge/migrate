<?php
namespace Chatbox\Migrate\SQL\Common;
/**
 * Created by PhpStorm.
 * User: mkkn
 * Date: 2015/04/04
 * Time: 11:44
 */
use Chatbox\Traits\Facade;

abstract class SQLGrammer {

    use Facade;

    public function quote($value){
        return $value;
    }



}