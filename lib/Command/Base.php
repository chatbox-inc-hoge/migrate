<?php
/**
 * Created by PhpStorm.
 * User: t.goto
 * Date: 2014/12/02
 * Time: 10:55
 */
namespace Chatbox\Migrate\Command;

use Symfony\Component\Console\Input\InputDefinition;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

use Chatbox\SymfonyComponents\Command\CommandBase;


abstract class Base extends CommandBase{

//    /*
//	 * @var Capsule
//	 */
//	private $capsule = null;

//	public function configure()
//	{
//        $this->addOption("config","c",InputOption::VALUE_OPTIONAL,"configuration file","migrate.php");
//        $this->addOption("host",null,InputOption::VALUE_OPTIONAL,"connection setting",null);
//	}

//    /**
//     * @param InputInterface $input
//     * @return Config
//     */
//    protected function getConfig(InputInterface $input){
//		if(is_null($this->config)){
//            $config = new Config();
//            $path = $input->getOption("config");
//            $fs = new \Symfony\Component\Filesystem\Filesystem();
//            ($fs->isAbsolutePath($path)) || $path = getcwd()."/$path";
//            $config->load($path);
//            $this->config = $config;
//		}
//		return $this->config;
//	}

//	/**
//     * カプセルオブジェクトの再利用はCommand側の責任で
//	 * @param $input
//	 * @return Capsule
//	 */
//	protected function getCapsule($input){
//		if(is_null($this->capsule)){
//            $this->capsule = $this->getConfig($input)->makeCapsule("default");
//		}
//		return $this->capsule;
//	}
//	/**
//	 * @param $input
//	 */
//	protected function getDatabaseName($input){
//        return $this->getConfig($input)->getDatabaseName();
//	}
//
//	/**
//	 * @param $input
//	 * @return \Illuminate\Database\Connection
//	 */
//	protected function getConnection($input){
//		$capsule = $this->getCapsule($input);
//		return $capsule->getConnection();
//	}
//    /**
//     * キャッシュしない。
//     * @param $input
//     * @return \Illuminate\Database\Connection
//     */
//    protected function getConnectionWithoutDatabase($input){
//        return $this->getConfig($input)->makeCapsule("default",true)->getConnection();
//    }
//
//	/**
//	 * @param $input
//	 * @return \Illuminate\Database\Schema\Builder
//	 */
//	protected function getBuilder($input){
//		$con = $this->getConnection($input);
//		return $con->getSchemaBuilder();
//	}
}