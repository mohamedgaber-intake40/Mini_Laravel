<?php
use Core\Dispatcher;

define('WEBROOT', str_replace("public/index.php", "", $_SERVER["SCRIPT_NAME"]));

define('ROOT', str_replace("public/index.php", "", $_SERVER["SCRIPT_FILENAME"]));

require(ROOT . '/'.'bootstrap.php');

$dispatcher = new Dispatcher();

$dispatcher->dispatch();


