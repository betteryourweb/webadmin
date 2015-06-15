#!/usr/bin/env php
<?php
use Symfony\Component\Console\Application;
use Betteryourweb\Commands\UserAddCommand;
use Betteryourweb\Commands\UserDeleteCommand;
use Betteryourweb\Commands\SyncCommand;


ini_set('display_errors','1');
error_reporting(E_ALL);

require_once "start.php";
require "vendor/autoload.php";

$app = new Application('Spottail Admin for DigitalOcean Droplets', '0.0.1a');

$app->add(new UserAddCommand);
$app->add(new UserDeleteCommand);


$app->add(new SyncCommand);

$app->run();
