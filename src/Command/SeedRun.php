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

use Migrate\Seeder\DBUnitSeeder;

class SeedRun extends Base{

    public function configure(){
        $this->setName("seed:run");
        $this->setDescription("seed data to tables");
        parent::configure();
        $this->addArgument("group",InputArgument::IS_ARRAY,"group name",["default"]);
//        $this->addOption("test",null,InputOption::VALUE_NONE,"hogehoge");
    }

    protected function execute(InputInterface $input, OutputInterface $output){
//        if($input->getOption("test")){
//            $output->writeln("hogehoge");
//
//            $hoge = new DBUnitSeeder();
//            $hoge->setUp();
//
//            exit;
//        }
        $config = $this->getConfig($input);
        $groups = $input->getArgument("group");
        $groups = $config->locateGroup($groups);

        foreach($groups as $groupName){
            $output->writeln("[INFO] run group $groupName");
            $seeds = $config->getSeed($groupName);

            foreach($seeds as $seed){
                if($seed instanceof \PHPUnit_Extensions_Database_DataSet_IDataSet){
                    $hoge = new DBUnitSeeder($this->getConnection($input)->getPdo(),$this->getDatabaseName($input),$seed);
                    $hoge->setUp();
                    $output->writeln("hogehogehoge");
                }else{
                    $tableName = array_shift($seed);
                    $output->writeln("[CREATE] seed data to table $tableName");
                    $builder = $this->getConnection($input)->table($tableName);
                    $seed($builder);
                }
            }
        }
	}
}