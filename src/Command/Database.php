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

class Database extends Base{

	protected $name = "database";
	protected $description = "this is migrate command";

	protected function setUpDefinition(){
		$this->definitions = [
            new InputArgument("dbname",InputArgument::REQUIRED,"database name",null),
            new InputOption("delete","d",InputOption::VALUE_NONE,"is Delete mode",null)
        ];
        parent::setUpDefinition();
	}

	protected function process(InputInterface $input, OutputInterface $output){
		if($input->getOption("delete")){
			$this->commandDelete($input,$output);
		}else{
			$this->commandCreate($input,$output);
		}
	}

	protected function commandDelete(InputInterface $input, OutputInterface $output){
		$dbname = $input->getArgument("dbname");
		$con = $this->getConnection($input);
		$affectedRows = \Migrate\Database::drop($con,$dbname);
		$output->writeln("[$dbname] has successfully deleted.");
	}

	protected function commandCreate(InputInterface $input, OutputInterface $output){
		$dbname = $input->getArgument("dbname");
		$con = $this->getConnection($input);
		$affectedRows = \Migrate\Database::create($con,$dbname);
		if($affectedRows){
			$output->writeln("[$dbname] has successfully deleted.");
		}else{
			$output->writeln("[$dbname] has successfully deleted."); //NOT IF つけてるから取れない…？
		}
	}

}