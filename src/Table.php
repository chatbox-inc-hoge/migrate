<?php
/**
 * Created by PhpStorm.
 * User: mkkn
 * Date: 2014/12/01
 * Time: 11:30
 */
namespace Migrate;

use \Migrate\Command\Config;
use \Illuminate\Database\Capsule\Manager as Capsule;

class Table{

	public $config;

    /**
     * @var \Illuminate\Database\Schema\Builder
     */
    public $builder;

	function __construct(Config $config)
	{
		$this->config = $config;
		$capsule = $this->config->setConnection();
        $this->builder = $capsule->getConnection()->getSchemaBuilder();


	}


	public function create()
	{
        $schema = $this->config->get("schema");

        foreach($schema as $tableName=>$_schema){
            $this->builder->create($tableName,$_schema);
        }
	}

	public function drop($database, $db = null){
        $schema = $this->config->get("schema");

        foreach($schema as $tableName=>$_schema){
            $sql = 'DROP TABLE '."`$tableName`";
            Capsule::update($sql);
        }
	}

	/**
	 * Formats the default charset.
	 *
	 * @param    string    $charset       the character set
	 * @param    bool      $is_default    whether to use default
	 * @param    string    $db       the database name in the config
	 * @param    string    $collation       the collating sequence to be used
	 * @return   string    the formated charset sql
	 */
	protected static function process_charset($charset = null, $is_default = false, $db = null, $collation = null)
	{
		if (empty($charset))
		{
			return '';
		}

		if (empty($collation) and ($pos = stripos($charset, '_')) !== false)
		{
			$collation = $charset;
			$charset = substr($charset, 0, $pos);
		}

		$charset = 'CHARACTER SET '.$charset;

		if ($is_default)
		{
			$charset = 'DEFAULT '.$charset;
		}

		if ( ! empty($collation))
		{
			if ($is_default)
			{
				$charset .= ' DEFAULT';
			}
			$charset .= ' COLLATE '.$collation;
		}

		return $charset;
	}




}
