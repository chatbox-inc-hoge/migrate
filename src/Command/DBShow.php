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

use Symfony\Component\Console\Helper\Table;

class DBShow extends Base{

    public function configure(){
        $this->setName("db:show");
        $this->setDescription("show database");
        parent::configure();
    }

    protected function execute(InputInterface $input, OutputInterface $output){
        $sql = 'SELECT * FROM information_schema.SCHEMATA';
        $res = $this->getConnectionWithoutDatabase($input)->select($sql);

        $table = new Table($output);
        $table
            ->setHeaders(array('Database', 'charset', 'collation'));
        foreach($res as $row){
            $table->addRow([$row["SCHEMA_NAME"],$row["DEFAULT_CHARACTER_SET_NAME"],$row["DEFAULT_COLLATION_NAME"]]);
        }
        $table->render();
    }
}