<?php
/**
 * Created by PhpStorm.
 * User: t.goto
 * Date: 2014/12/02
 * Time: 10:55
 */
namespace Chatbox\Migrate\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputDefinition;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

use Symfony\Component\Console\Helper\HelperSet;

use Chatbox\Migrate\SQL\TableQuery;


class Debug extends Base{

    public function configure(){
        $this->setName("debug");
        $this->setDescription("create table");
        parent::configure();
        $this->addArgument("groups",InputArgument::IS_ARRAY,"group name",[]);
//        $this->addArgument("groups",InputArgument::IS_ARRAY,"group name",[]);
        $this->addOption("schema","s",InputOption::VALUE_OPTIONAL,"display config","database.php");
//        $this->addOption("execute","e",InputOption::VALUE_NONE,"execute query with setting");
//        $this->addArgument("dbname",InputArgument::IS_ARRAY,"database name",[]);
    }

    protected function execute(InputInterface $input, OutputInterface $output){
        $data = include __DIR__."/config/database.php";
        $config = [];
        $obj = new \Chatbox\Migrate\Manager($config,$data);


	}


    protected function loadFile(InputInterface $input){
        $file = $input->getOption("schema");
        $path = getcwd()."/$file";
        $data = require $path;
        return $data;
    }
}