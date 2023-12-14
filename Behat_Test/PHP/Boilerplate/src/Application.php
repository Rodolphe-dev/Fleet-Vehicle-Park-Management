#!/usr/bin/env php
<?php
// application.php

require __DIR__ . '/../vendor/autoload.php';
require 'db_connection.php';

use Behat_Test\App\Command\CreateFleetCommand;
use Behat_Test\App\Command\RegisterVehicleCommand;
use Behat_Test\App\Command\ParkVehicleCommand;
use Behat_Test\App\Command\LocalizeVehicleCommand;

use Symfony\Component\Console\Application;

$application = new Application();

// Commands
$application->add(new CreateFleetCommand());
$application->add(new RegisterVehicleCommand());
$application->add(new ParkVehicleCommand());
$application->add(new LocalizeVehicleCommand());

$application->run();

?>
