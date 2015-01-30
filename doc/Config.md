# migrate configuration file

````
<?php
use \Illuminate\Database\Schema\Blueprint;
use \Illuminate\Database\Query\Builder;

return [
    "connections" => [
        "default" => [
            'driver'    => 'mysql',
            'host'      => '127.0.0.1',
            'database'  => '',
            'username'  => 'root',
            'password'  => '',
            'charset'   => 'utf8',
            'collation' => 'utf8_unicode_ci',
            'prefix'    => '',
        ]
    ],
    "schema" => [
        "sample_table" => function(Blueprint $table){
                $table->unsignedInteger("id",true);
                $table->string("key");
                $table->text("data");
                $table->dateTime("created_at");
                $table->dateTime("updated_at");
            },
    ],
    "seeds" => [
        ["sample_table",function(Builder $builder){
            $builder->insert($data);
        }],
    ],
    "includes" => [
        "user" => __DIR__."/data/user.php"
    ]
];

````

### connections.default

DB configuration

### schema



### seed

### includes

sub configuration value

### alias



