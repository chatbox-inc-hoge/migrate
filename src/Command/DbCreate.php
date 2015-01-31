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

class DBCreate extends Base{

    public function configure(){
        $this->setName("db:create");
        $this->setDescription("create database");
        parent::configure();
        $this->addArgument("dbname",InputArgument::IS_ARRAY,"database name",[]);
    }

    protected function execute(InputInterface $input, OutputInterface $output){
        $dbnames = $input->getArgument("dbname");

        $if_not_exists = true;
        foreach($dbnames as $dbname){
            $sql = 'CREATE DATABASE';
            $sql .= $if_not_exists ? ' IF NOT EXISTS ' : ' ';
            $sql .= " `$dbname`";
            $sql .= " CHARACTER SET utf8";
            $this->getConnectionWithoutDatabase($input)->update($sql);

            $output->writeln("[CREATED] DATABASE: $dbname");
        }
	}
}