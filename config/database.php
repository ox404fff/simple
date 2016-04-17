<?php
/**
 * Connection to database
 */

return [
    'class'     => 'vendor\components\DBConnection',
    'dsn'       => 'mysql:host=localhost;dbname=simple',
    'username'  => 'root',
    'password'  => 'polkilo',
    'charset'   => 'utf8',
    'errorMode' => ENVIRONMENT == 'prod' ? \PDO::ERRMODE_SILENT : \PDO::ERRMODE_EXCEPTION
];