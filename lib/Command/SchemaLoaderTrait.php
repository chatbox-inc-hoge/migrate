<?php
/**
 * Created by PhpStorm.
 * User: mkkn
 * Date: 2015/04/25
 * Time: 1:30
 */

namespace Chatbox\Migrate\Command;

use Chatbox\Migrate\SQL\Connection;
use Chatbox\Migrate\SQL\SeederProcessor;
use Doctrine\ORM\EntityManager;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;
use Chatbox\Migrate\SQL\Builder;
use Chatbox\Migrate\Doctrine\Schema;
use Chatbox\Migrate\SQL\SeederInterface;

/**
 * Schema 定義ファイルを読み込むトレイト
 * @package Chatbox\Migrate\Command
 */
trait SchemaLoaderTrait {

    /**
     * @var Connection
     */
    protected $connection;


    protected function schemaLoaderConfigure(){
        $this->addArgument("groups",InputArgument::IS_ARRAY,"group name",[]);
        $this->addOption("config",null,InputOption::VALUE_OPTIONAL,"display config","database/schema.php");
    }

    protected function getConnection(){
        if(!$this->connection){
            $con = $this->getConfig("config")["con"];
//        $con = [
//            "driver" => "mysqli",
//            "host" => "127.0.0.1",
//            "user" => "root",
//        ];
            $this->connection = new Connection($con);
        }
        return $this->connection;
    }

    /**
     * @return Builder
     */
    protected function getBuilder()
    {
        return new Builder($this->getConnection());
    }

    /**
     * @return SeederProcessor
     */
    protected function getSeederProcessor(){
        return new SeederProcessor($this->getConnection());
    }


    /**
     * @return Schema[]
     */
    protected function getSchemas(){
        $con = $this->getConfig("config");

        foreach($con["schema"] as $schema){
            /** @var Schema $schema */
            $schema->configure();
        }

        return $con["schema"];
    }

    /**
     * @return SeederInterface[]
     */
    protected function getSeeders(){
        $con = $this->getConfig("config");

        $seeders = [];
        foreach($this->getSchemas() as $schema){
            foreach($schema->getSeeders() as $seeder){
                $seeders[] = $seeder;
            }
        }
        return $seeders;
    }

}