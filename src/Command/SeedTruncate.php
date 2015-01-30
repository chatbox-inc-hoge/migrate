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

class SeedTruncate extends Base{

    public function configure(){
        $this->setName("seed:truncate");
        $this->setDescription("truncate table for re-seeding");
        parent::configure();
        $this->addArgument("group",InputArgument::IS_ARRAY,"group name",["default"]);
    }

    protected function execute(InputInterface $input, OutputInterface $output){
        $config = $this->getConfig($input);

        $groups = $input->getArgument("group");
        $groups = $config->locateGroup($groups);

        foreach($groups as $groupName){
            $output->writeln("[INFO] run group $groupName");
            $seeds = $config->getSchema($groupName);

            foreach($seeds as $seed){
                $tableName = array_shift($seed);
                $output->writeln("[DELETE] truncate table $tableName");
                $sql = 'TRUNCATE TABLE '."`$tableName`";
                $this->getConnection($input)->update($sql);
            }
        }
	}
}