<?php

use Migrate\Command\Config;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Query\Builder;

$config = new Config();

$config->setConnection("database",[
    'driver'    => 'mysql',
    'host'      => '127.0.0.1',
    'database'  => 'database',
    'username'  => 'root',
    'password'  => '',
    'charset'   => 'utf8',
    'collation' => 'utf8_unicode_ci',
    'prefix'    => '',
]);

$config->setSchema("default",[
    "master_user" => function(Blueprint $table){
        $table->unsignedInteger("id",true,true);
        $table->string("name");
        $table->unsignedInteger("sex",false,true);
        $table->timestamps();
        $table->softDeletes();

//        $table->primary("id");
        $table->unique("name");
    },
]);

$config->setSeeds("default",[
    ["master_user",function(Builder $builder){
        $builder->insert([
            "name"=>"Tom",
            "sex" => "1"
        ]);
    }],
]);

return $config;