<?php

use \Symfony\Component\Console\Application;

if(!class_exists("\\Migrate\\Command\\Database")){
    echo "you need to install local migrate.".PHP_EOL;
    exit(1);
}

$console = new Application();
//$console->add( require __DIR__."/../src/Command/_database.php");
$console->add(new Migrate\Command\Database());
$console->add(new Migrate\Command\Schema());
$console->add(new Migrate\Command\Seed());
$console->add(new Migrate\Command\Scaffold());
//$console->add( require __DIR__."/../src/Command/_schema.php");
//$console->add( require __DIR__."/../src/Command/_seed.php");
$console->run();

