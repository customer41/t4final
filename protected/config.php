<?php

return [
    'db' => [
        'default' => [
            'driver' => 'mysql',
            'host' => '127.0.0.1',
            'user' => 'root',
            'password' => '',
            'dbname' => 't4final',
        ],
    ],

    'extensions' => [
        'jquery' => [],
        'bootstrap' => [
            'theme' => 'cosmo',
        ],
        'ckeditor' => [
            'location' => 'local',
        ],
    ],

    'errors' => [
        404 => '//Error/404',
        403 => '//Error/403',
    ],

    'title' => 'Блог Александра Попова',
];