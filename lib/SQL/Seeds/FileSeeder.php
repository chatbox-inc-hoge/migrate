<?php
namespace Chatbox\Migrate\SQL\Seeds;

use Chatbox\Migrate\SQL\Seeder;
use Chatbox\Migrate\SQL\SeederInterface;
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

    public function getFileIterator(){
        $finder = new Finder();
        $finder->files()->in($this->dir);
        if($this->fileName){
            $finder->name($this->fileName);
        }
        return $finder;
    }

    abstract protected function processFile(Seeder $seeder,SplFileInfo $file);

    public function runWithSeeder(Seeder $seeder)
    {
        foreach($this->getFileIterator() as $file){
            $this->processFile($seeder,$file);
        }
    }


}