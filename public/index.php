<?php
use Core\Dispatcher;

$ds = DIRECTORY_SEPARATOR;
define('WEBROOT', str_replace("public".$ds."index.php", "", $_SERVER["SCRIPT_NAME"]));

define('ROOT', str_replace("public".$ds."index.php", "", $_SERVER["SCRIPT_FILENAME"]));
require(ROOT . '/'.'bootstrap.php');

$dispatcher = new Dispatcher();

$dispatcher->dispatch();


