<?php

use Tracy\Debugger;

require __DIR__ . '/../vendor/autoload.php';

$configurator = new Nette\Configurator;

$allowed_ips = [
	'86.49.121.69', // JT sporilov
	'90.176.144.217', // JT litice
	'109.81.211.176', // JT ostrov
	'89.233.158.239', // JT stodulky
	'85.70.131.182', // Lubo plzen
	'2a00:1028:96d4:77de:740e:dcb:cb6:aedb', // lubos utery
	'212.79.110.125',  //lubos plzen
	'109.81.211.109',  //JT ostrov
	'109.81.211.137', // JT ostrov
	'212.79.110.119', // petr kodl
	'89.103.181.18', // tomas susovsky
	'88.100.165.176', // adam havelka
	'85.13.100.76', // JT ostrov u verci
	'109.80.243.178', // kancl
	'78.80.248.78', // stepan sevcik vary
	'147.228.209.157', // stepan sevcik kolej
	'90.176.144.217', // JT litice
	'212.79.110.120', //
];
$configurator->setDebugMode($allowed_ips);
if (php_sapi_name() == 'cli') {
	$configurator->setDebugMode(true);
}
//$configurator->setDebugMode(true);
Debugger::$email = 'all@incolor.cz';

$configurator->enableDebugger(__DIR__ . '/../log');

$configurator->setTempDirectory(__DIR__ . '/../temp');

$configurator->createRobotLoader()
	->addDirectory(__DIR__)
	->register();


$configurator->addConfig(__DIR__ . '/config/config.neon');
if (!isset($_SERVER['REMOTE_ADDR']) OR in_array($_SERVER['REMOTE_ADDR'], array('127.0.0.1', '::1'))) { // !isset is for doctrine
	$configurator->addConfig(__DIR__ . '/config/config.local.neon');
} else if (strpos($_SERVER['HTTP_HOST'], 'incolor.cz') !== false) {
	$configurator->addConfig(__DIR__ . '/config/config.dev.neon');
} else {
	$configurator->addConfig(__DIR__ . '/config/config.production.neon');
}

require_once(__DIR__ . '/libs/bootstrapIncludes.php');

$container = $configurator->createContainer();

return $container;
