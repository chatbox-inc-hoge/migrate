<?php
namespace Migrate\Scaffold\Fuelphp;
/**
 * Created by PhpStorm.
 * User: mkkn
 * Date: 2014/12/20
 * Time: 21:21
 */
class Crud extends \Migrate\Scaffold{

    public function getTemplate()
    {
        return __DIR__."/../../../views/fuelphp/crud.php";
    }

    public function getOutput()
    {
        $path = $this->scaffoldConfig->getOutput();
        $className = $this->getClassName();
        $className = str_replace(["_"],DIRECTORY_SEPARATOR,$className);
        $className = strtolower($className);
        $path .= $className.".php";
        return $path;
    }


    public function getData()
    {
        $data = parent::getData();
        $data["namespace"] = $this->scaffoldConfig->getNamespace()?:"";
        $data["parentClassName"] = $this->scaffoldConfig->getParentClass()?:"Model_Crud";

        $data["className"] = $this->getClassName();
        return $data;
    }

    private function getClassName(){
        $className = $this->scaffoldConfig->getPrefix()?:"";
        $className .= ucfirst($this->tableName);
        return $className;
    }


}