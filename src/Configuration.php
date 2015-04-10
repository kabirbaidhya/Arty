<?php namespace Gckabir\Arty;

use RuntimeException;

class Configuration
{
    protected $config;

    public function __construct(array $config)
    {
        if (empty($config)) {
            throw new RuntimeException("Invalid configuration");
        }

        $this->config = $config;
    }

    protected function getDefaultConfig()
    {
        $default = require __DIR__.'/Misc/default.config.php';

        $script = $_SERVER['SCRIPT_FILENAME'];
        $default['path']   = dirname(realpath($script));

        return array_dot($default);
    }

    public function all()
    {
        $defaultConfig = $this->getDefaultConfig();
        $userConfig = array_dot($this->config);

        $config = ($userConfig + $defaultConfig);

        return array_undot($config);
    }
}
