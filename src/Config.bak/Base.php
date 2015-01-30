<?php
namespace Migrate\Config;
/**
 * Created by PhpStorm.
 * User: mkkn
 * Date: 2014/12/13
 * Time: 16:50
 */

/**
 *
 * @package Migrate\Config
 */
class Base extends \FuelPHP\Common\DataContainer{

	static public function forge($data = []){
		return new static($data);
	}

	public function __construct(array $data = null, $readOnly = false)
	{
		parent::__construct($data, true);
	}


}
