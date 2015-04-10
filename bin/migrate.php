<?php

use \Symfony\Component\Console\Application;


if(!class_exists("\\Migrate\\Config")){
    echo "you need to install local migrate.".PHP_EOL;
    exit(1);
}

$console = new Application();
$console->add(new Migrate\Command\DBDelete());
$console->add(new Migrate\Command\DBShow());
$console->add(new Migrate\Command\DBCreate());

$console->add(new Migrate\Command\SchemaCreate());
$console->add(new Migrate\Command\SchemaDelete());

$console->add(new Migrate\Command\ScaffoldConfig());

$console->add(new Migrate\Command\SeedRun());
$console->add(new Migrate\Command\SeedTruncate());

$console->add(new \Chatbox\Migrate\Command\CommandTableCreate());

$console->run();

