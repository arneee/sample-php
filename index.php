<?php
require __DIR__ . '/vendor/autoload.php';

use Cowsayphp\Farm;
use Cowsayphp\Farm\Cow;
use Monolog\Formatter\JsonFormatter;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use Monolog\Processor\IntrospectionProcessor;
use Monolog\Processor\WebProcessor;

header('Content-Type: text/plain');

$text = "Set a message by adding ?message=<message here> to the URL";
if(isset($_GET['message']) && $_GET['message'] != '') {
	$text = htmlspecialchars($_GET['message']);
}

$cow = Farm::create(Cow::class);
echo $cow->say($text);

// create a log channel
$log = new Logger('name');
$handler = new StreamHandler('php://stdout', Logger::DEBUG);
$formatter = new JsonFormatter();
$handler->setFormatter($formatter);
$log->pushHandler($handler);
$log->pushProcessor(new WebProcessor());
$log->pushProcessor(new IntrospectionProcessor());


// add records to the log
$log->warning('hello ' . time(),$_ENV);
$log->error('you ' . time(),$_SERVER);

echo "\n\nOK!";
