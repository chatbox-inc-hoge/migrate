<?php
/**
 * Created by PhpStorm.
 * User: t.goto
 * Date: 2014/12/01
 * Time: 13:29
 */
namespace Migrate;

use FuelPHP\Common\Arr;


/**
 * Class Config
 *
 * 複数の設定ファイル情報を持ちながら、
 * 実行スべき構成情報を保有しているもの。
 *
 * 基本的には、起点となる設定ファイルの籠であって、
 * サブのinclude系ファイルの籠ではない。
 *
 *
 * 持つもの
 *   connection setting
 *   eache group container
 *
 * not holding
 *   active group/connection
 *   direct schema
 *
 * @package Migrate
 */
class Config{

    const TYPE_PHP = "php";
    const TYPE_YAML = "yml";

	/**
	 * オプションからの直入に対応するための第二引数
	 * @param $path
	 * @param array $additionalData
	 */
	static public function load($path,$additionalData=[]){
		$config = static::loadFile($path);
		$data = array_merge($config,$additionalData);
		return static::forge($data);
	}

	static protected function loadFile($_path){
		$tryPath = [$_path];
		$tryPath[] = getcwd()."/".$_path;
		foreach($tryPath as $path){
			if(file_exists($path) && is_file($path)){
				return require $path;
			}
		}
		throw new \Exception("invalid file!");
	}

	/**
	 * 生配列を受け取って色々生成する人。
	 * @param $data
	 * @return \Migrate\Config
	 */
	static public function forge($data){
		Arr::set($data,"includes.default",static::forgeGroup($data));

		$connection = static::forgeConnectionConfig($data);
        $scaffold = static::forgeScaffoldConfig($data);
		$subConfig = Arr::get($data,"includes",[]);

		$obj = new static($connection,$scaffold,$subConfig);
		return $obj;
	}

	static public function forgeGroup($data){
		return [
			"schema" => static::forgeSchemaConfig($data),
			"seed" => static::forgeSeedConfig($data),
		];
	}

	/**
	 * @param $data
	 * @return \Migrate\Config\Connection
	 * @throws \Exception
	 */
	static protected function forgeConnectionConfig($data){
		$defaultClass = "\\Migrate\\Config\\Connection";
		$className = $defaultClass; // カスタムローダの埋め込み
		$configParam = Arr::get($data,"connections",[]);//必要なパラメータの読み込み

		if(is_a($className,$defaultClass,true)){//カスタムローダのクラスが正しいかの確認
			$obj = new $className($configParam);
			return $obj;
		}else{
			throw new \Exception("invalid class type on connection config loader");
		}
	}
    /**
     * @param $data
     * @return \Migrate\Config\Scaffold
     * @throws \Exception
     */
    static protected function forgeScaffoldConfig($data){
        $defaultClass = "\\Migrate\\Config\\Scaffold";
        $className = $defaultClass; // カスタムローダの埋め込み
        $configParam = Arr::get($data,"scaffold",[]);//必要なパラメータの読み込み

        if(is_a($className,$defaultClass,true)){//カスタムローダのクラスが正しいかの確認
            $obj = new $className($configParam);
            return $obj;
        }else{
            throw new \Exception("invalid class type on scaffold config loader");
        }
    }
	/**
	 * @param $data
	 *   schema: 必要なパラメータ
	 * @return \Migrate\Config\Schema
	 * @throws \Exception
	 */
	static protected function forgeSchemaConfig($data){
		$defaultClass = "\\Migrate\\Config\\Schema";
		$className = $defaultClass; // カスタムローダの埋め込み
		$configParam = Arr::get($data,"schema",[]);//必要なパラメータの読み込み

		if(is_a($className,$defaultClass,true)){//カスタムローダのクラスが正しいかの確認
			$obj = new $className($configParam);
			return $obj;
		}else{
			throw new \Exception("invalid class type ");
		}
	}
	/**
	 * @param $data
	 * @return \Migrate\Config\Seed
	 * @throws \Exception
	 */
	static protected function forgeSeedConfig($data){
		$defaultClass = "\\Migrate\\Config\\Seed";
		$className = $defaultClass; // カスタムローダの埋め込み
		$configParam = Arr::get($data,"seed",[]);//必要なパラメータの読み込み

		if(is_a($className,$defaultClass,true)){//カスタムローダのクラスが正しいかの確認
			$obj = new $className($configParam);
			return $obj;
		}else{
			throw new \Exception("invalid class type ");
		}
	}
	/**
	 * 接続先情報
	 * 接続先情報はルートの構成書しか持たない。
	 * @var \Migrate\Config\Connetion
	 */
	protected $connection;

    /**
     * ジェネレータ設定
     * こちらもルートの構成書しか持たない。
     * @var \Migrate\Config\Scaffold
     */
    protected $scaffold;
	/**
	 * サブConfig情報
	 * "schema" => Config\Schema
	 * "seed" => Config\Seed
	 */
	protected $subConfig = [];

    /**
     *
     */
    public function __construct(Config\Connection $connection,Config\Scaffold $scaffold,array $subConfig)
    {
	    $this->connection = $connection;
        $this->scaffold = $scaffold;
//	    $this->schema = $schema;
//	    $this->seed = $seed;
	    $this->subConfig = $subConfig;
    }

	/**
	 * @return \Migrate\Config\Connection
	 * @throws \Exception
	 */
	public function getConnection(){
		return $this->connection;
	}

    /**
     * @return Config\Scaffold
     */
    public function getScaffold(){
        return $this->scaffold;
    }

	/**
	 * @param null $group
	 * @return \Migrate\Config\Schema
	 * @throws \Exception
	 */
	public function getSchema($group){
		//多階層Configとかしたかったら$groupを分割して、引数で渡すの?
		return $this->getSubConfig($group)["schema"];
	}

	/**
	 * @param null $group
	 * @return \Migrate\Config\Seed
	 * @throws \Exception
	 */
	public function getSeed($group=null){
		//多階層Configとかしたかったら$groupを分割して、引数で渡すの?
		return $this->getSubConfig($group)["seed"];
	}

	/**
	 * 内部的な参照。includesエントリからConfigオブジェクトを取り出す。
	 * @param $group
	 * @return array subConfig配列
	 * @throws \Exception
	 */
	protected function getSubConfig($group){

		$subConfig = Arr::get($this->subConfig,$group,null);//ここではパスかsubConfig配列が入ってくる

		if($subConfig){
			if(!is_array($subConfig)){
				$path = $subConfig;
				$data = static::loadFile($path);
				$subConfig = static::forgeGroup($data);
				Arr::set($this->subConfig,$group,$subConfig);
			}
			return $subConfig;
		}else{
			throw new \Exception("invalid group name: $group");
		}
	}
} 