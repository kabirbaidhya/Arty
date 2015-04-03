<?php
return [
    'environment'   => 'production',
    'path'      => '',
    'migrations'    => [
        'directory'    => 'migrations',
        'table'    => 'migrations',
    ],
    'database'    => [
        'default'   => 'mysql',
        'connections' => [

        ],
    ],

    'eloquent'  => [
        'boot'    => false,
    ],
];
