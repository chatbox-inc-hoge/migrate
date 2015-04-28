<?php
namespace Chatbox\Migrate\SQL\Seeds;

use Chatbox\Migrate\SQL\Seeder;
use Chatbox\Migrate\SQL\SeederInterface;
use Symfony\Component\Finder\SplFileInfo;
use Symfony\Component\Yaml\Yaml;

/**
 * Created by PhpStorm.
 * User: mkkn
 * Date: 2015/04/25
 * Time: 5:11
 */

class YamlSeeder extends FileSeeder{

    protected function processFile(Seeder $seeder, SplFileInfo $file)
    {
        $arr = Yaml::parse($file->getContents());
        foreach($arr as $tableName => $rows){
            $seeder->acceptRows($tableName,$rows);
        }
    }


}