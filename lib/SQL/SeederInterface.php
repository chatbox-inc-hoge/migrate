<?php
/**
 * Created by PhpStorm.
 * User: mkkn
 * Date: 2015/04/25
 * Time: 4:59
 */

namespace Chatbox\Migrate\SQL;


interface SeederInterface {

    /**
     * 事前処理を行う。
     * @param SeederProcessor $seeder
     * @return mixed
     */
    public function before(SeederProcessor $seeder);

    /**
     * 処理を行う
     * @param SeederProcessor $seeder
     * @return mixed
     */
    public function process(SeederProcessor $seeder);

}