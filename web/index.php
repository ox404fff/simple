<?php
/**
 * Created by PhpStorm.
 * User: ox404fff
 * Date: 14.04.16
 * Time: 20:44
 */

defined('ENVIRONMENT') or define('ENVIRONMENT', 'dev');
defined('BASE_PATH') or define('BASE_PATH', realpath(__DIR__ . '/..'));

require(BASE_PATH . '/vendor/autoloader.php');

$config = require(BASE_PATH . '/config/web.php');

/**
 * Run application
 */
vendor\Application::getInstance()->run($config);