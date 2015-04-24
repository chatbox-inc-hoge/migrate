<?php
/**
 * Created by PhpStorm.
 * User: mkkn
 * Date: 2015/04/21
 * Time: 21:38
 */

namespace Chatbox\Migrate\Doctrine;

use Doctrine\DBAL\Schema\Table as DoctrineTable;

class Table extends DoctrineTable{


    public function __construct(
        $tableName,
        array $columns = array(),
        array $indexes = array(),
        array $fkConstraints = array(),
        $idGeneratorType = 0,
        array $options = array()
    ) {
        parent::__construct($tableName, $columns, $indexes, $fkConstraints, $idGeneratorType, $options);
        $this->configure();
    }

    protected function configure(){

    }

    public function createTable($tableName)
    {
        $table = new Table($tableName);
        $this->_addTable($table);

        foreach ($this->_schemaConfig->getDefaultTableOptions() as $name => $value) {
            $table->addOption($name, $value);
        }

        return $table;
    }


}