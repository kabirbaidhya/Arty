<?php namespace Gckabir\Arty;

class Configuration
{
    protected function getDefaultConfig()
    {
        $default = require __DIR__.'/Misc/default.config.php';

        $script = $_SERVER['SCRIPT_FILENAME'];
        $default['path']   = dirname(realpath($script));

        return array_dot($default);
    }

    public function all(array $overridingConfig = array())
    {
        $overridingConfig = array_dot($overridingConfig);

        $defaultConfig = $this->getDefaultConfig();

        $config = ($overridingConfig + $defaultConfig);

        return array_undot($config);
    }
}
