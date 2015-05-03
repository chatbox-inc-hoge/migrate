<?php
/**
 * Created by PhpStorm.
 * User: mkkn
 * Date: 2015/04/21
 * Time: 21:38
 */

namespace Chatbox\Migrate\Doctrine;

use Doctrine\DBAL\Schema\Schema as DoctrineSchema;
use Doctrine\DBAL\Schema\SchemaConfig;
use Chatbox\Migrate\SQL\SeederInterface;

class Schema extends DoctrineSchema{

    public function __construct(
        array $tables = array(),
        array $sequences = array(),
        SchemaConfig $schemaConfig = null,
        array $namespaces = array()
    ) {
        parent::__construct($tables, $sequences, $schemaConfig, $namespaces);
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

    /**
     * シードの一覧を返す。テーブル名のバインドがあるので、
     * こちらに配置するのが良さそう。
     * @return SeederInterface[]
     */
    public function getSeeders(){
        return [];
    }



}