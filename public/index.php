<?php

session_start();

require_once '../vendor/autoload.php';

App\Helpers\Env::load(__DIR__ . '/../.env');

define('BASE_PATH', rtrim(str_replace('\\', '/', dirname($_SERVER['SCRIPT_NAME'])), '/'));

require_once '../config/database.php';

$router = require '../routes/web.php';

$router->dispatch();
