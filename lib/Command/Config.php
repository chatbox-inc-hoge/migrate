<?php
/**
 * Created by PhpStorm.
 * User: mkkn
 * Date: 2015/04/05
 * Time: 2:17
 */
namespace Chatbox\Migrate\Command;

use Chatbox\Container\FileBasedContainer;
use Chatbox\Migrate\Command\Config\TableConfig;

class Config extends FileBasedContainer{


    /**
     * @return TableConfig
     */
    public function getTableConfig(){
        return new TableConfig($this);
    }

    /**
     * @return \Illuminate\Database\Connection
     */
    protected function getEloquent(){
        $eloq = \Chatbox\PHPUtil::bootEloquent($this->getItem("_setting.default"));
        return \Chatbox\PHPUtil::getEloquent();
    }

    public function runStatement($query){
        return $this->getEloquent()->statement($query);
    }


}