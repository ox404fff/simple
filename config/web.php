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
            'errorMode' => ENVIRONMENT == 'prod' ? \PDO::ERRMODE_SILENT : \PDO::ERRMODE_EXCEPTION
        ],
        'urlManager' => [
            'class'     => 'vendor\components\UrlManager',
            'prettyUrl' => true,
        ],
        'formatter' => [
            'class'     => 'helpers\Formatter',
        ],
        'assetsManager' => [
            'class'     => 'vendor\components\AssetsManager',
            'globalJsFiles' => [
                '<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.2/jquery.min.js"></script>',
                '<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>',
                '<script src="/js/main.js"></script>',
            ],
            'globalCssFiles' => [
                '<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">',
                '<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap-theme.min.css" integrity="sha384-fLW2N01lMqjakBkx3l/M9EahuwpSfeNvV63J5ezn3uZzapT0u7EYsXMjQV+0En5r" crossorigin="anonymous">',
                '<link rel="stylesheet" href="/css/main.css">',
            ]
        ]
    ]
];