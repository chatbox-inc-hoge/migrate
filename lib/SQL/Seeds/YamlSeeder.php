<?php
namespace Chatbox\Migrate\SQL\Seeds;

use Chatbox\Migrate\SQL\SeederProcessor;
use Symfony\Component\Finder\SplFileInfo;
use Symfony\Component\Yaml\Yaml;

/**
 * Created by PhpStorm.
 * User: mkkn
 * Date: 2015/04/25
 * Time: 5:11
 */

class YamlSeeder extends FileSeeder{

    protected function processFile(SeederProcessor $seeder, SplFileInfo $file)
    {
        $arr = Yaml::parse($file->getContents());
        foreach($arr as $tableName => $rows){
            $seeder->insertRows($tableName,$rows);
        }
    }


}