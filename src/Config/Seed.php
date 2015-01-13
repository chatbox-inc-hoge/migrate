<?php
namespace Migrate\Config;

use \Illuminate\Database\Connection;

use Illuminate\Database\Capsule\Manager as Capsule;

/**
 *
 * コンストラクタにかけた時点で、tableName=>Schemaの形に正規化すること。
 *
 */
class Seed extends Base{

	public function insert(Connection $con){
		;
		foreach($this->all() as $seeds){
			$tableName = array_shift($seeds);
			foreach($seeds as $seed){
				$builder = $con->table($tableName);
				$seed($builder);
			}
		}
	}

	public function truncate(Connection $con){
		foreach($this->all() as $seeds){
			$tableName = array_shift($seeds);
			$sql = 'DROP TABLE '."`$tableName`";
			$con->update($sql);
		}
	}
}
