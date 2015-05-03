<?php
namespace Chatbox\Migrate\SQL\Seeds;

use Chatbox\Migrate\SQL\SeederInterface;
use Chatbox\Migrate\SQL\SeederProcessor;
use Symfony\Component\Finder\Finder;
use Symfony\Component\Finder\SplFileInfo;

/**
 * Created by PhpStorm.
 * User: mkkn
 * Date: 2015/04/25
 * Time: 5:11
 */

abstract class FileSeeder implements SeederInterface{

    protected $dir;

    protected $fileName;


    function __construct($dir=null,$fileName=null)
    {
        $dir && ($this->dir = $dir);
        $fileName && ($this->fileName = $fileName);
    }

    public function before(SeederProcessor $seeder)
    {

    }

    public function process(SeederProcessor $seeder)
    {
        foreach($this->getFileIterator() as $file){
            $this->processFile($seeder,$file);
        }
    }

    public function getFileIterator(){
        $finder = new Finder();
        $finder->files()->in($this->dir);
        if($this->fileName){
            $finder->name($this->fileName);
        }
        return $finder;
    }

    abstract protected function processFile(SeederProcessor $seeder,SplFileInfo $file);


}