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

	protected $name = "database";
	protected $description = "this is migrate command";

	protected function setUpDefinition(){
		$this->definitions = [
			new InputArgument("dbname",InputArgument::REQUIRED,"database name",null),
			new InputOption("delete","d",InputOption::VALUE_NONE,"is Delete mode",null)
		];
        parent::setUpDefinition();
	}

//	protected function process(InputInterface $input, OutputInterface $output){
//		$database = new \Migrate\Database($this->getConfig($input));
//		$dbName = $input->getArgument("dbname");
//
//		if($input->getOption("delete")){
//			if($database->delete($dbName)){
//				$line = "successfully delete database: $dbName";
//			}else{
//				$line = "database '$dbName' not found";
//			}
//			$output->writeln($line);
//		}else{
//			if($database->create($dbName)){
//				$line = "successfully create database: $dbName";
//			}else{
//				$line = "cant create database '$dbName' already exist";
//			}
//			$output->writeln($line);
//		}
//	}
}