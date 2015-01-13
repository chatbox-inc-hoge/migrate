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

class Seed extends Base{

	protected $name = "seed";
	protected $description = "seed: put data to table";

	protected function setUpDefinition(){
		$this->definitions = [
			new InputArgument("group",InputArgument::OPTIONAL,"group name","default"),
			new InputOption("truncate","t",InputOption::VALUE_NONE,"truncate tables, insted of seeding",null)
		];
		parent::setUpDefinition();
	}

	protected function process(InputInterface $input, OutputInterface $output){
		if($input->getOption("truncate")){
			$this->commandDelete($input,$output);
		}else{
			$this->commandCreate($input,$output);
		}
	}

	protected function commandDelete(InputInterface $input, OutputInterface $output){
		$group = $input->getArgument("group");
		$con = $this->getConnection($input);
		$res = $this->getConfig($input)->getSeed($group)->truncate($con);
		$output->writeln("[$group] has successfully deleted.");
	}

	protected function commandCreate(InputInterface $input, OutputInterface $output){
		$group = $input->getArgument("group");
		$con = $this->getConnection($input);
		$res = $this->getConfig($input)->getSeed($group)->insert($con);
		$output->writeln("[$group] has successfully created.");
	}
}