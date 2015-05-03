<?php
namespace Chatbox\Migrate\SQL\Seeds;

use Chatbox\Migrate\SQL\SeederInterface;
use Chatbox\Migrate\SQL\SeederProcessor;

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

    public function before(SeederProcessor $seeder)
    {
    }


    public function process(SeederProcessor $seeder)
    {
        foreach($this->seeds as $seed){
            list($table,$values) = $seed;
            $seeder->insertRows($table,$values);
        }
    }


}