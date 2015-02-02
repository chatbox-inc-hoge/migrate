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

class ScaffoldConfig extends Base{

    public function configure(){
        $this->setName("scaffold:config");
        $this->setDescription("create configuration template");
        parent::configure();
    }

    protected function execute(InputInterface $input, OutputInterface $output){
        $content = file_get_contents(__DIR__."/../../scaffold/database.php");
        $output->writeln($content);
	}
}