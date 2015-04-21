<?php
/**
 * Created by PhpStorm.
 * User: mkkn
 * Date: 2015/04/12
 * Time: 1:05
 */

namespace Chatbox\Migrate\Util;

use Doctrine\Common\Persistence\Mapping\Driver\MappingDriver;
use Chatbox\Migrate\Util\SchemaContainer;
use Chatbox\Migrate\Schema\Table;

class SchemaContainerDriver implements MappingDriver{

    protected $config;
//    protected $containers = [];
    /**
     * @var Table[]
     */
    protected $classMap = [];

    protected $metadataLoaded = [];



    function __construct($config,array $containers)
    {
        $this->config = $config;
        foreach($containers as $key=>$value){
            $this->setSchemaContainers($key,$value);
        }

    }


    public function setSchemaContainers($name,SchemaContainer $schemaContainer){
        $this->classMap = array_merge($this->classMap,$schemaContainer->getEntityClassMap());
//        $this->containers[$name] = $schemaContainer;
    }

    /**
     * Loads the metadata for the specified class into the provided container.
     *
     * @param string $className
     * @param \Doctrine\Common\Persistence\Mapping\ClassMetadata $metadata
     *
     * @return void
     */
    public function loadMetadataForClass($className, \Doctrine\Common\Persistence\Mapping\ClassMetadata $metadata)
    {
        if(isset($this->classMap[$className])){
            $schema = $this->classMap[$className];
            $metadata = $schema->getMetadata($metadata);
            $this->metadataLoaded[] = $className;
        }else{
            throw new \Exception("non supported class called");
        }

    }

    /**
     * Gets the names of all mapped classes known to this driver.
     *
     * @return array The names of all mapped classes known to this driver.
     */
    public function getAllClassNames()
    {
        return array_keys($this->classMap);
    }

    /**
     * Returns whether the class with the specified name should have its metadata loaded.
     * This is only the case if it is either mapped as an Entity or a MappedSuperclass.
     *
     * @param string $className
     *
     * @return boolean
     */
    public function isTransient($className)
    {
        return in_array($className,$this->metadataLoaded);
    }


}