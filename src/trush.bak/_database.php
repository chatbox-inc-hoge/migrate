<?php
/**
 * Created by PhpStorm.
 * User: t.goto
 * Date: 2014/12/01
 * Time: 12:32
 */
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

$obj = new Command("database");

$obj->setDescription("this is migrate command");
$obj->setDefinition([
	new InputArgument("dbname",InputArgument::REQUIRED,"database name",null),
	new InputOption("delete","d",InputOption::VALUE_NONE,"is Delete mode",null)
]);
$obj->setCode(function(InputInterface $input, OutputInterface $output){

    $config = require getcwd() . "/Database.php";
	$database = new \Migrate\Database($config);
	$dbName = $input->getArgument("dbname");

	if($input->getOption("delete")){
		$output->writeln("delete mode");
		$database->delete($dbName);
	}else{
		$output->writeln("not delete mode");
		$database->create($dbName);
	}
});

return $obj;