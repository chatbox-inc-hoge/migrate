<?php
namespace Chatbox\Migrate\SQL\Seeds;

use Chatbox\Migrate\SQL\Seeder;
use Chatbox\Migrate\SQL\SeederInterface;

/**
 * Created by PhpStorm.
 * User: mkkn
 * Date: 2015/04/25
 * Time: 5:11
 */

class ArraySeeder implements SeederInterface{

    /**
     * @var array
     */
    protected $seeds = [];

    function __construct(array $seeds)
    {
        $this->seeds = $seeds;
    }


    public function runWithSeeder(Seeder $seeder)
    {
        foreach($this->seeds as $seed){
            list($table,$values) = $seed;
            $seeder->acceptSeeds($table,$values);
        }
    }


}