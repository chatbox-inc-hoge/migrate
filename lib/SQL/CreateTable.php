<?php
/**
 * Created by PhpStorm.
 * User: mkkn
 * Date: 2015/04/04
 * Time: 11:36
 */
namespace Chatbox\Migrate\SQL;

use Chatbox\Migrate\Schema\Table;

class CreateTable {

    protected $columnParser;

    function __construct()
    {
        $this->columnParser = new \Chatbox\Migrate\SQL\MySQL\ColumnParser();
    }

    public function sql(Table $table,$if_not_exists=true)
    {
        $sql = 'CREATE TABLE';

        $sql .= $if_not_exists ? ' IF NOT EXISTS ' : ' ';

        $sql .= $this->columnParser->quote($table->getName()).' (';
        $fields = [];
        foreach($table->getColumns() as $column){
            $fields[] = "\n\t".$this->columnParser->createTable($column);
        }
        $sql .= implode($fields,",");
//        if ( ! empty($primary_keys))
//        {
//            $key_name = \DB::quote_identifier(implode('_', $primary_keys), $db ? $db : static::$connection);
//            $primary_keys = \DB::quote_identifier($primary_keys, $db ? $db : static::$connection);
//            $sql .= ",\n\tPRIMARY KEY ".$key_name." (" . implode(', ', $primary_keys) . ")";
//        }
//
//        empty($foreign_keys) or $sql .= static::process_foreign_keys($foreign_keys);

        $sql .= "\n)";

        if($engine = $table->getEngine()){
            $sql .= "ENGINE = $engine";
        }
        return $sql;
    }



}