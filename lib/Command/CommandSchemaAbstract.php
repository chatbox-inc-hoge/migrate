<?php
/**
 * Created by PhpStorm.
 * User: t.goto
 * Date: 2014/12/02
 * Time: 10:55
 */
namespace Chatbox\Migrate\Command;

use Needs\Schema\UserSchema;
use Symfony\Component\Console\Input\InputDefinition;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

use Chatbox\Migrate\SQL\TableQuery;
use Chatbox\Migrate\SQL\Builder;
use Chatbox\Migrate\Doctrine\Schema;


abstract class CommandSchemaAbstract extends Base{

    public function configure(){
        parent::configure();
        $this->addArgument("groups",InputArgument::IS_ARRAY,"group name",[]);


        $this->addOption("config",null,InputOption::VALUE_OPTIONAL,"display config","database.php");
    }

    /**
     * @return Builder
     */
    protected function getBuilder()
    {
        $con = $this->getConfig("config")["con"];
//        $con = [
//            "driver" => "mysqli",
//            "host" => "127.0.0.1",
//            "user" => "root",
//        ];
        return new Builder($con);
    }

    /**
     * @return Schema[]
     */
    protected function getSchemas(){
        $con = $this->getConfig("config");
        return $con["schema"];
    }

}