<?php
/**
 * Created by PhpStorm.
 * User: t.goto
 * Date: 2014/12/02
 * Time: 10:55
 */
namespace Migrate\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputDefinition;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class SchemaCreate extends Base{

    public function configure(){
        $this->setName("schema:create");
        $this->setDescription("create tables");
        parent::configure();
        $this->addArgument("group",InputArgument::IS_ARRAY,"group name",["default"]);
    }

    protected function execute(InputInterface $input, OutputInterface $output){
        $config = $this->getConfig($input);

        $groups = $input->getArgument("group");
        $groups = $config->locateGroup($groups);

        foreach($groups as $groupName){
            $output->writeln("[INFO] run group $groupName");
            $schema = $config->getSchema($groupName);
            $builder = $this->getBuilder($input);

            foreach($schema as $tableName=>$_schema){
                $output->writeln("[CREATE] create table $tableName");
                $builder->create($tableName,$_schema);
            }
        }
	}
}