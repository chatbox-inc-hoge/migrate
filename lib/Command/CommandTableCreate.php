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

use Chatbox\Migrate\SQL\TableQuery;


class CommandTableCreate extends Base{

    public function configure(){
        $this->setName("table:create");
        $this->setDescription("create table");
        parent::configure();
        $this->addArgument("groups",InputArgument::IS_ARRAY,"group name",[]);
        $this->addOption("describe","d",InputOption::VALUE_NONE,"display config");
        $this->addOption("execute","e",InputOption::VALUE_NONE,"execute query with setting");
//        $this->addArgument("dbname",InputArgument::IS_ARRAY,"database name",[]);
    }

    protected function execute(InputInterface $input, OutputInterface $output){
        $tableConfig = $this->getConfig($input)->getTableConfig();
        if($input->getOption("describe")){
            $data = $tableConfig->describe();
            $output->writeln("config mode");
            $output->writeln($data);
        }else{
            foreach($input->getArgument("groups") as $groupName){
                $output->writeln("-- generate SQL: $groupName");
                $query = new TableQuery();
                foreach($tableConfig->getGroup($groupName) as $table){
                    $dropQuery   = $query->dropTable($table);
                    $createQuery = $query->createTable($table);
                    if($input->getOption("execute")){
                        $this->getConfig($input)->runStatement($dropQuery);
                        $this->getConfig($input)->runStatement($createQuery);
                    }else{
                        $output->writeln($dropQuery);
                        $output->writeln($createQuery);
                    }
                }
            }
        }




//        $sql = new CreateTable();
//        $hoge = $sql->sql(new \Chatbox\Chatbox\Schema\CbRoom("cb_room"));
//        var_dump($hoge);
	}
}