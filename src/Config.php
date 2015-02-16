<?php
/**
 * Created by PhpStorm.
 * User: t.goto
 * Date: 2014/12/01
 * Time: 13:29
 */
namespace Migrate;

use Chatbox\Config\Config as Container;
use Illuminate\Database\Capsule\Manager as Capsule;

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
    /**
     * primary扱いになるグループ名
     * @var string
     */
    public $defaultGroup = "default";
    /**
     * メイン設定ファイルを格納
     * @var Container
     */
    protected $primary;

    protected $subContainer = [];

    /**
     *
     */
    public function __construct(array $data = [])
    {
        $this->primary = Container::forge($data);
    }

    public function primaryIncludes($filePath){
        $this->primary->load($filePath);
    }

    /**
     * オンデマンドに必要なときだけ呼ぶからprotected
     * @param $name
     * @throws Exception
     */
    protected function includes($name){
        if($includePath = $this->primary->get("includes.$name")){
            $container = Container::forge([])->load($includePath);
            $this->subContainer[$name] = $container;
            return true;
        }else{
            return false;
        }
    }

	/**
	 * @return Capsule
	 * @throws \Exception
	 */
	public function makeCapsule($group,$withoutDatabase=false){
        $conInfo = $this->getConnectionConfig($group);
        if($conInfo){
            ($withoutDatabase) && ($conInfo["database"] = "");
            $capsule = new Capsule;
            $capsule->addConnection($conInfo);
            return $capsule;
        }else{
            throw new \Exception("invalid database setting");
        }
	}
	/**
	 * @return Capsule
	 * @throws \Exception
	 */
	public function getDatabaseName($group=null){
        $conInfo = $this->getConnectionConfig($group);
        return $conInfo["database"];
	}

    /**
     * TEST用に
     * @param $group
     * @return mixed
     */
    public function getConnectionConfig($group){
        return $this->primary->get("connections.$group");
    }

    /**
     * ScaffoldはPrimaryからのみ
     * @return Config\Scaffold
     */
    public function getScaffold($type){
        return $this->primary->get("scaffold.$type");
    }



	/**
	 * @param null $group
	 * @return \Migrate\Config\Schema
	 * @throws \Exception
	 */
	public function getSchema($group){
		$container = $this->locateContainer($group);
		return $container->get("schema",[]);
	}

	/**
	 * @param null $group
	 * @return \Migrate\Config\Seed
	 * @throws \Exception
	 */
	public function getSeed($group=null){
        $container = $this->locateContainer($group);
        return $container->get("seed",[]);
	}

    /**
     * @param $group
     * @return Container
     * @throws \Exception
     */
    protected function locateContainer($group){
        if($group === $this->defaultGroup)
        {//デフォルトグループからの読み込み
            return $this->primary;
        }else
        {//サブ設定ファイルの読み込み
            if(!isset($this->subContainer[$group]) && $this->includes($group) === false)
            {//まだロードされていない時で、サブ設定ファイルを読み込めなかった時
                throw new \Exception("invalid group name: $group");
            }
            return $this->subContainer[$group];
        }
    }

    /**
     * エイリアスを考慮してグループ名を変換する。
     */
    public function locateGroup(array $group){
        $table = $this->primary->get("alias",[]);
        $pool = [];
        foreach($group as $g){
            if($alias = \Chatbox\Arr::get($table,$g,false)){
                $pool = array_merge($pool,array_values($alias));
            }else{
                $pool[] = $g;
            }
        }
        return array_values(array_unique($pool));
    }

}