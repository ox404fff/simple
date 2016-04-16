<?php
/**
 * Created by PhpStorm.
 * User: ox404fff
 * Date: 14.04.16
 * Time: 21:13
 */


return [
    'components' => [
        'db' => [
            'class'     => 'vendor\components\DBConnection',
            'dsn'       => 'mysql:host=localhost;dbname=simple',
            'username'  => 'root',
            'password'  => '',
            'charset'   => 'utf8',
        ],
        'urlManager' => [
            'class'     => 'vendor\components\UrlManager',
            'prettyUrl' => true,
        ]
    ]
];