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

    /**
     * @param $prefix
     * @return static
     */
    static public function prefix($prefix){
        $obj = new static;
        $obj->setPrefix($prefix);
        return $obj;
    }

    protected $prefix;

    public function __construct(
        array $tables = array(),
        array $sequences = array(),
        SchemaConfig $schemaConfig = null,
        array $namespaces = array()
    ) {
        parent::__construct($tables, $sequences, $schemaConfig, $namespaces);
    }

    public function setPrefix($prefix){
        $this->prefix = $prefix;
        return $this;
    }

    /**
     * 遅延実行の関係上publicに変更
     * こちらはprefixの関係上遅延実行する。
     */
    public function configure(){

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