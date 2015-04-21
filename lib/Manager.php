<?php
namespace Chatbox\Migrate;
/**
 * Created by PhpStorm.
 * User: mkkn
 * Date: 2015/04/11
 * Time: 18:28
 */
use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\EntityManager;
use Chatbox\Migrate\Util\SchemaContainer;
use Chatbox\Migrate\Util\SchemaContainerDriver;

class Manager {

    /**
     * @var SchemaContainer[]
     */
    protected $container = [];

    protected $config;

    function __construct($config = [],$data)
    {
        $this->config = [
                "connection" => [
                    'driver' => 'pdo_sqlite',
                    'path' => __DIR__ . '/db.sqlite',
                ],
                "driver" => [],
                "isDevMode" => true,
                "proxy" => null,
                "cache" => null,
            ]+$config;
        foreach($data as $key=>$container){
            $this->setContainer($key,$container);
        }
    }

    protected function setContainer($key,SchemaContainer $container){
        $this->container[$key] = $container;
    }

    /**
     * @return EntityManager
     * @throws \Doctrine\ORM\ORMException
     */
    public function getEntityManager(){
        $isDevMode = true;
        $conn = $this->config["connection"];
        $entityManager = EntityManager::create($conn, $this->setUpConfig());
        return $entityManager;
    }

    /**
     * @return \Doctrine\ORM\Configuration
     */
    protected function setUpConfig(){
        $isDevMode = $this->config["isDevMode"];
        $proxyDir = $this->config["proxy"];
        $cache = $this->config["cache"];
        $driver = $this->getDriver();
        $config = Setup::createConfiguration($isDevMode, $proxyDir, $cache);
        $config->setMetadataDriverImpl($driver);
        return $config;
    }

    protected function getDriver(){
        $driver = new SchemaContainerDriver($this->config["driver"],$this->container);
        foreach($this->container as $key=>$value){
            $driver->setSchemaContainers($key,$value);
        }
        return $driver;
    }


}