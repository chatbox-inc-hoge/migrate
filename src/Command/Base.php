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

	protected $name = null;

	protected $description = "empty description";

    protected $definitions = [];

	/**
	 * getter 付きアクセスのため、private
	 * @var null
	 */
	private $config = null;
	private $capsule = null;

	public function __construct($name = null)
	{
		(func_num_args() === 0) && ($name = $this->name);
		parent::__construct($name);
		$this->setUp();
	}

	protected function setUp(){
		$this->setUpDescription();
		$this->setUpDefinition();
		$this->setUpCode();
	}

	protected function setUpDescription(){
		$this->setDescription($this->description);
	}

	protected function setUpDefinition(){
        $this->definitions[] = new InputOption("config","c",InputOption::VALUE_OPTIONAL,"configuration file","database.php");
		$this->setDefinition($this->definitions);
	}

	protected function setUpCode(){
		$closure = function(InputInterface $input, OutputInterface $output){
			$this->process($input,$output);
		};
		$this->setCode($closure);
	}

	abstract protected function process(InputInterface $input, OutputInterface $output);


	/**
	 * @param InputInterface $input
	 * @return \Migrate\Config
	 */
	protected function getConfig(InputInterface $input){
		if(is_null($this->config)){
			$path = $input->getOption("config");

			$optionData = static::readInlineConnection($input);
			$path = getcwd(). "/database.php";

			$config = \Migrate\Config::load($path,$optionData); //本来はloadで処理する
			$this->config = $config;
//
//			$this->config = require getcwd() . "/database.php";
		}
		return $this->config;
	}

	protected function readInlineConnection($input){
		return [];
	}

	protected function getCapsule($input){
		if(is_null($this->capsule)){
			$connection = $this->getConfig($input)->getConnection();
			$this->capsule = $connection->getCapsule("default");
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
	 * @param $input
	 * @return \Illuminate\Database\Schema\Builder
	 */
	protected function getBuilder($input){
		$con = $this->getConnection($input);
		return $con->getSchemaBuilder();
	}
}