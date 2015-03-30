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
        'bootEloquent'    => false,
    ];

    public function all(array $override = array())
    {
        return ($override + $this->params);
    }
}
