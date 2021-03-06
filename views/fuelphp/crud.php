<?="<?php".PHP_EOL?>
<?php if($namespace):?>
namespace <?=$namespace?>;
<?php endif?>
/**
* Generated by console
*/

class <?=$className?> extends <?=$parentClassName?> {

    static protected $_table_name = "<?=$tableName?>";
<?php if(count($primaryKeys) === 1):?>
    static protected $_primary_key = "<?=$primaryKeys[0]["name"]?>";
<?php endif;?>
    protected static $_properties = [
<?php foreach($columns as $col):?>
        "<?=$col["name"]?>",
<?php endforeach?>
    ];

    protected static $_mysql_timestamp = true;

    protected static $_created_at = 'created_at';
    protected static $_updated_at = 'updated_at';
}