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

class SchemaDelete extends Base{

    public function configure(){
        $this->setName("schema:delete");
        $this->setDescription("delete tables");
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

            foreach($schema as $tableName=>$_schema){
                $output->writeln("[DELETE] delete table $tableName");
                $sql = 'DROP TABLE IF EXISTS '."`$tableName`";
                $this->getConnection($input)->update($sql);
            }
        }
	}
}