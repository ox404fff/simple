<?php

defined('ENVIRONMENT') or define('ENVIRONMENT', 'dev');
defined('BASE_PATH') or define('BASE_PATH', realpath(__DIR__ . '/..'));

require(BASE_PATH . '/vendor/autoloader.php');

$config = require(BASE_PATH . '/config/web.php');

/**
 * Run application
 */
vendor\Application::getInstance()->run($config);