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
        'db' => require __DIR__.DIRECTORY_SEPARATOR.'database.php',
        'assetsManager' => require __DIR__.DIRECTORY_SEPARATOR.'assets.php',
        'urlManager' => [
            'class'        => 'vendor\components\UrlManager',
            'defaultRoute' => ['comments', 'index'],
            'prettyUrl'    => true,
        ],
        'request' => [
            'class'     => 'vendor\components\Request',
        ],
        'formatter' => [
            'class'     => 'helpers\Formatter',
        ],
    ]
];