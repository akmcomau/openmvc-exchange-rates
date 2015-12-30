#!/usr/bin/env php
<?php

// drop all tables in postgres database
//   drop schema public cascade;
//   create schema public;

use core\classes\Database;
use core\classes\Config;
use core\classes\Logger;
use core\classes\Model;
use core\classes\AutoLoader;

include('core/ErrorHandler.php');
include('core/Constants.php');
include('core/classes/AutoLoader.php');
AutoLoader::init();
Logger::init();

$logger     = Logger::getLogger('');
$config     = new Config();
$database   = new Database($config);

// get command line options
$longopts  = [
	'domain:',
	'scrapers:',
	'methods:',
	'no-commit',
];
$options = getopt("", $longopts);

// make sure there is a domain
if (!isset($options['domain'])) {
	$logger->error('You must pass in a domain name');
	exit(1);
}
$config->setSiteDomain('www.'.$options['domain']);

$model = new Model($config, $database);
$exchange_rate = $model->getModel('\modules\exchange_rates\classes\models\ExchangeRate');
$exchange_rate->updateRates();
