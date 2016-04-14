<?php
/**
 * Created by PhpStorm.
 * User: ox404fff
 * Date: 14.04.16
 * Time: 20:44
 */

defined('ENVIRONMENT') or define('ENVIRONMENT', 'dev');
defined('BASE_PATH') or define('BASE_PATH', realpath('..'));

spl_autoload_register(function($class) {
    require BASE_PATH.DIRECTORY_SEPARATOR.str_replace('\\', DIRECTORY_SEPARATOR, $class).'.php';
});

$config = require(__DIR__ . '/../config/web.php');

vendor\Application::run($config);