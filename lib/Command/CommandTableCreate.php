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

use Chatbox\Migrate\SQL\CreateTable;

class CommandTableCreate extends Base{

    public function configure(){
        $this->setName("table:create");
        $this->setDescription("create table");
        parent::configure();
//        $this->addArgument("dbname",InputArgument::IS_ARRAY,"database name",[]);
    }

    protected function execute(InputInterface $input, OutputInterface $output){
        $output->writeln("hogehogehoge");
        $sql = new CreateTable();

	}
}