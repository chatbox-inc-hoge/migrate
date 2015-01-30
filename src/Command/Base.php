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

use Illuminate\Database\Capsule\Manager as Capsule;



abstract class Base extends Command{

	/**
	 * getter 付きアクセスのため、private
	 * @var \Migrate\Config
	 */
	private $config = null;
	/**
	 * @var Capsule
	 */
	private $capsule = null;

	public function configure()
	{
        $this->addOption("config","c",InputOption::VALUE_OPTIONAL,"configuration file","database.php");
        $this->addOption("host",null,InputOption::VALUE_OPTIONAL,"connection setting",null);
	}

    /**
     * @param InputInterface $input
     * @return \Migrate\Config
     */
    protected function getConfig(InputInterface $input){
		if(is_null($this->config)){
            //Configにオプション初期値注入するならここで
            $config = new \Migrate\Config();
			$path = $input->getOption("config","database.php");
            (\Chatbox\Filesystem::with()->isAbsolutePath($path)) || $path = getcwd()."/$path";
            $config->primaryIncludes($path);
			$this->config = $config;
		}
		return $this->config;
	}

	/**
     * カプセルオブジェクトの再利用はCommand側の責任で
	 * @param $input
	 * @return Capsule
	 */
	protected function getCapsule($input){
		if(is_null($this->capsule)){
            $this->capsule = $this->getConfig($input)->makeCapsule("default");
		}
		return $this->capsule;
	}

	/**
	 * @param $input
	 * @return \Illuminate\Database\Connection
	 */
	protected function getConnection($input){
		$capsule = $this->getCapsule($input);
		return $capsule->getConnection();
	}
    /**
     * キャッシュしない。
     * @param $input
     * @return \Illuminate\Database\Connection
     */
    protected function getConnectionWithoutDatabase($input){
        return $this->getConfig($input)->makeCapsule("default",true)->getConnection();
    }

	/**
	 * @param $input
	 * @return \Illuminate\Database\Schema\Builder
	 */
	protected function getBuilder($input){
		$con = $this->getConnection($input);
		return $con->getSchemaBuilder();
	}
}