<?php
require __DIR__ . '/vendor/autoload.php';

use Cowsayphp\Farm;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;

header('Content-Type: text/plain');

$text = "Set a message by adding ?message=<message here> to the URL";
if(isset($_GET['message']) && $_GET['message'] != '') {
	$text = htmlspecialchars($_GET['message']);
}

$cow = Farm::create(\Cowsayphp\Farm\Cow::class);
echo $cow->say($text);

// create a log channel
$log = new Logger('name');
$log->pushHandler(new StreamHandler('path/to/your.log', Logger::DEBUG));
$log->pushHandler(new StreamHandler('php://stdout', Logger::DEBUG));

// add records to the log
$log->warning('hello',$_ENV);
$log->error('you',$_SERVER);

echo "\n\nOK!";
