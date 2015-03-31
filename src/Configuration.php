<?php namespace Gckabir\Arty;

class Configuration
{
    protected $params = [
        'database'    => [
            'driver'    => 'mysql',
            'host'      => '127.0.0.1',
            'database'  => '',
            'username'  => '',
            'password'  => '',
            'charset'   => 'utf8',
            'collation' => 'utf8_unicode_ci',
            'prefix'    => '',
            'strict'    => false,
        ],

        'path'      => '',

        'migrations'    => [
            'directory'    => 'migrations',
            'table'    => 'migrations',
        ],

        'eloquent'  => [
            'boot'    => false,
        ],
    ];

    public function all(array $override = array())
    {
        $script = $_SERVER['SCRIPT_FILENAME'];
        $this->params['path']   = dirname(realpath($script));

        return ($override + $this->params);
    }
}
