<?php

session_start();

define('BASE_PATH', rtrim(str_replace('\\', '/', dirname($_SERVER['SCRIPT_NAME'])), '/'));

require_once '../config/database.php';

require_once '../vendor/autoload.php';

$router = require '../routes/web.php';

$router->dispatch();
