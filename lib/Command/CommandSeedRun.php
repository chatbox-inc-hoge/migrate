<?php
/**
 * Created by PhpStorm.
 * User: t.goto
 * Date: 2014/12/02
 * Time: 10:55
 */
namespace Chatbox\Migrate\Command;

use Symfony\Component\Console\Input\InputOption;

class CommandSeedRun extends Base{

    use SchemaLoaderTrait;

    public function configure(){
        $this->setName("seed:run");
        $this->setDescription("drop tables");
        parent::configure();
        $this->schemaLoaderConfigure();
//        $this->addArgument("groups",InputArgument::IS_ARRAY,"group name",[]);
        $this->addOption("dump","d",InputOption::VALUE_NONE,"dump sql");
        $this->addOption("force","f",InputOption::VALUE_NONE,"execute query");
    }

    protected function handle()
    {
        $processor = $this->getSeederProcessor();

        $seeders = $this->getSeeders();

        foreach($seeders as $seeder){
            $seeder->before($processor);
        }
        foreach($seeders as $seeder){
            $seeder->process($processor);
        }
   }
}