<?php
/**
 * Created by PhpStorm.
 * User: t.goto
 * Date: 2014/12/02
 * Time: 10:55
 */
namespace Chatbox\Migrate\Command;

use Symfony\Component\Console\Input\InputOption;

class CommandSchemaCreate extends Base{

    use SchemaLoaderTrait;

    public function configure(){
        $this->setName("schema:create");
        $this->setDescription("create tables");
        parent::configure();
        $this->schemaLoaderConfigure();
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