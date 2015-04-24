<?php
/**
 * Created by PhpStorm.
 * User: mkkn
 * Date: 2015/04/21
 * Time: 22:36
 */

namespace Chatbox\Migrate\Doctrine;

/**
 * Class OptionalColumnTrait
 *  Autoincrement  オートインクリメント
    Comment  コメント
    Default  デフォルト
    Fixed 可変長を辞める
    Length ()の中で使うやつ
    Notnull ご存知の通り
    Scale  小数の(p,s)
    Unsigned ご存知の通り
    Precision  小数の(p,s)

 * @package Chatbox\Migrate\Doctrine
 */
trait OptionalColumnTrait {

    use BasicColumnTrait;

    public function addUnsignedInt($name,array $options=[]){
        $options["Unsigned"] = true;
        return $this->addInteger($name,$options);
    }

    public function addId($name="id",$autoIncrement=false){
        $option = [
            "Autoincrement" => $autoIncrement,
        ];
        return $this->addUnsignedInt($name,$option);
    }

    public function addCreatedAt($name="created_at"){
        return $this->addDatetime($name);
    }

    public function addUpdatedAt($name="updated_at"){
        return $this->addDatetime($name);
    }

    public function addDeletedAt($name="deleted_at"){
        return $this->addDatetime($name);
    }

    public function addTimestamps(){
        $this->addCreatedAt();
        $this->addUpdatedAt();
    }

    public function addSurrogateKey(){
        $col = $this->addId("id",true);
        $this->setPrimaryKey(["id"]);
        return $col;
    }

}