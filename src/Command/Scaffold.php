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

class Scaffold extends Base{

    public function configure(){
        $this->setName("scaffold");
        $this->setDescription("create template");
        parent::configure();
        $this->addArgument("group",InputArgument::IS_ARRAY,"group name",["default"]);
		$this->addOption("drop","d",InputOption::VALUE_NONE,"work as delete mode with this",null);
		$this->addOption("setting","s",InputOption::VALUE_NONE,"generate configuration template",null);
    }

    protected function execute(InputInterface $input, OutputInterface $output){
        if($input->getOption("config")){
            $this->commandCreateConfig($output);
        }else{
            $this->commandCreate($input,$output);
        }
	}

    protected function commandCreateConfig($output){
        $output->writeln(\Migrate\Scaffold::config());
    }

	protected function commandCreate(InputInterface $input, OutputInterface $output){
		$group = $input->getArgument("group");
		$con = $this->getConnection($input);
        $schemaConfig = $this->getConfig($input)->getSchema($group);
        $scaffoldConfig = $this->getConfig($input)->getScaffold()->setType("fuelphp_crud");
        \Migrate\Scaffold::create($schemaConfig,$scaffoldConfig);
		$output->writeln("[$group] has successfully deleted.");
	}
}