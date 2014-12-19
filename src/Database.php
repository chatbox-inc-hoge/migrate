<?php
/**
 * Created by PhpStorm.
 * User: mkkn
 * Date: 2014/12/01
 * Time: 11:30
 */
namespace Migrate;

use \Illuminate\Database\Connection;

class Database{

	/**
	 * @param Connection $con
	 * @param $databaseName
	 * @param string $charset
	 * @param bool $if_not_exists
	 * @return int
	 */
	static public function create(Connection $con,$databaseName, $charset = "utf8", $if_not_exists = true)
	{
		$sql = 'CREATE DATABASE';
		$sql .= $if_not_exists ? ' IF NOT EXISTS ' : ' ';

		$charset = static::process_charset($charset, true);

		return $con->update("{$sql} `$databaseName` $charset");

	}

	/**
	 * @param Connection $con
	 * @param $databaseName
	 * @return int
	 */
	static public function drop(Connection $con,$databaseName){
		$sql = 'DROP DATABASE '."`$databaseName`";
		return $con->update($sql);
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
