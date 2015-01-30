<?php

//date_default_timezone_set('UTC');
//
//require_once dirname(__FILE__) . '/../util.php';
//
/**
 * PHPUnit test case for the util.php library
 *
 * @since   1.0.000
 */



class ConfigTest extends PHPUnit_Framework_TestCase
{
	public function test_connection()
	{
        $primary = include __DIR__."/sample/primary.php";
        $config = new \Migrate\Config();
        $config->primaryIncludes(__DIR__."/sample/primary.php");
        $this->assertEquals(
            $config->getConnectionConfig("default"),
            \Chatbox\Arr::get($primary,"connections.default")
        );
    }

    public function test_schema()
    {
        $primary = include __DIR__."/sample/primary.php";
        $subUser = include __DIR__."/sample/sub/user.php";
        $subItem = include __DIR__."/sample/sub/item.php";

        $config = new \Migrate\Config();
        $config->primaryIncludes(__DIR__."/sample/primary.php");

        $this->assertEquals(
            $config->getSchema("user"),
            \Chatbox\Arr::get($subUser,"schema")
        );
        $this->assertEquals(
            $config->getSchema("item"),
            \Chatbox\Arr::get($subItem,"schema")
        );
    }

    public function test_alias(){
        $sample = ["hoge","piyo"];

        $config = new \Migrate\Config();
        $group = $config->locateGroup(["hoge","piyo"]);
        $this->assertEquals($sample,$group);

        $config = new \Migrate\Config([
            "alias" => ["piyo"=>["hoge","blue"]]
        ]);
        $group = $config->locateGroup(["hoge","piyo"]);
        $this->assertEquals(["hoge","blue"],$group);


    }

}
