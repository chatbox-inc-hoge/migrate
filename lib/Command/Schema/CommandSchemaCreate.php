<?php
/**
 * Created by PhpStorm.
 * User: t.goto
 * Date: 2014/12/02
 * Time: 10:55
 */
namespace Chatbox\Migrate\Command\Schema;

use Needs\Schema\UserSchema;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputDefinition;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

use Chatbox\Migrate\Command\CommandSchemaAbstract;
use Chatbox\Migrate\SQL\TableQuery;
use Chatbox\Migrate\SQL\Builder;


class CommandSchemaCreate extends CommandSchemaAbstract{

    public function configure(){
        $this->setName("schema:create");
        $this->setDescription("create tables");
        parent::configure();
//        $this->addArgument("groups",InputArgument::IS_ARRAY,"group name",[]);
        $this->addOption("dump","d",InputOption::VALUE_NONE,"dump sql");
        $this->addOption("force","f",InputOption::VALUE_NONE,"execute query");
    }

    protected function handle()
    {
        $builder = $this->getBuilder();
        foreach($this->getSchemas() as $schema){
            $sqls = $builder->createSchema($schema);
            foreach($sqls as $sql){
                if($this->getOption("dump")){
                    $this->getOutput()->writeln($sql);
                }elseif($this->getOption("force")){
                    $builder->runSql($sql);
                }else{
                    $this->line("you should set --force or --dump option");
                    exit(1);
                }

            }
        }
    }
}