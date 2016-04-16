<?php
/**
 * Application config array
 */

return [
    'parameters' => [
        'title'    => 'Simple',
        'language' => 'ru',
        'charset'  => 'utf-8',
    ],
    'components' => [
        'db' => [
            'class'     => 'vendor\components\DBConnection',
            'dsn'       => 'mysql:host=localhost;dbname=simple',
            'username'  => 'root',
            'password'  => 'polkilo',
            'charset'   => 'utf8',
        ],
        'urlManager' => [
            'class'     => 'vendor\components\UrlManager',
            'prettyUrl' => true,
        ]
    ]
];