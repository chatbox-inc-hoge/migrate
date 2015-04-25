<?php
/**
 * Created by PhpStorm.
 * User: mkkn
 * Date: 2015/04/25
 * Time: 4:59
 */

namespace Chatbox\Migrate\SQL;


interface SeederInterface {

    public function runWithSeeder(Seeder $seeder);

}