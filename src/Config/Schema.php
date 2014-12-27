<?php
namespace Migrate\Config;

use \Illuminate\Database\Connection;
/**
 *
 * コンストラクタにかけた時点で、tableName=>Schemaの形に正規化すること。
 *
 */
class Schema extends Base{


	public function migrate(Connection $con){
		$builder = $con->getSchemaBuilder();

		foreach($this->all() as $tableName=>$_schema){
			$builder->create($tableName,$_schema);
		}
	}

	public function drop(Connection $con){
		foreach($this->all() as $tableName=>$_schema){
			$sql = 'DROP TABLE '."`$tableName`";
			$con->update($sql);
		}
	}
}
