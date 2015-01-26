<?php
/**
 * Created by PhpStorm.
 * User: mkkn
 * Date: 2014/12/01
 * Time: 11:30
 */
namespace Migrate;

use \Illuminate\Database\Connection;
use \Illuminate\Database\Schema\Blueprint;

use \Symfony\Component\Filesystem\Filesystem;

abstract class Scaffold{

    /**
     * @param Connection $con
     * @param Config\Schema $schemaConfig
     * @param $options
     *   namespace: 名前空間
     *   prefix: クラス名接頭辞
     *   parentClass: 親クラス名
     */
    static public function create(Config\Schema $schemaConfig,Config\Scaffold $scaffoldConfig)
	{
        $fs = new Filesystem();
        foreach($schemaConfig->all() as $table => $callback){
            $bluePrint = new Blueprint($table);
            $callback($bluePrint);
            $cols = $bluePrint->getColumns();

            $obj = $scaffoldConfig->forgeScaffold($table,$cols);

            $fs->dumpFile($obj->getOutput(),$obj->render());
        }
	}

    static public function config(){
        $path = getcwd()."/database.php";
        $content = file_get_contents(__DIR__."/../scaffold/database.php");
        $fs = new Filesystem();
        $fs->dumpFile($path,$content);
    }

    protected $tableName;
    protected $columns;
    protected $primaryKeys;

    protected $scaffoldConfig;

    function __construct($tableName,$columns,Config\Scaffold $scaffoldConfig)
    {
        $this->tableName = $tableName;
        $this->columns = $columns;

        $this->scaffoldConfig = $scaffoldConfig;
    }

    public function getData(){
        $data = [
            "tableName" => $this->tableName,
            "columns" => $this->columns,
            "primaryKeys" => $this->primaryKeys,
        ];
        return $data;
    }

    public function render(){
        $data = $this->getData();
        $cleanRoom = function($__file_name, array $__data){
            extract($__data, EXTR_REFS);
            ob_start();
            try{
                include $__file_name;
            }
            catch (\Exception $e){
                ob_end_clean();
                throw $e;
            }
            return ob_get_clean();
        };
        $string = $cleanRoom($this->getTemplate(),$data);
        return $string;
    }

    abstract public function getTemplate();

    abstract public function getOutput();
}
