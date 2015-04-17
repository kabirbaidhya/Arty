<?php
return [
    'environment'   => 'production',
    'path'      => '',
    'migrations'    => [
        'directory'    => 'migrations',
        'table'    => 'migrations',
    ],
    'eloquent'  => [
        'boot'  => false,
    ],
    'database'    => [
        'default'   => 'mysql',
        'connections' => [

        ],
    ],
];
