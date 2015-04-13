<?php namespace Gckabir\Arty\Config;

class Config
{
    protected $config;

    /**
     * Constructor
     * @param array $config
     */
    public function __construct(array $config)
    {
        $this->config = $config;
    }

    /**
     * Get the default config
     * @return array
     */
    protected function getDefaultConfig()
    {
        $default = require __DIR__.'/../../misc/default.config.php';

        $script = $_SERVER['SCRIPT_FILENAME'];
        $default['path']   = dirname(realpath($script));

        return array_dot($default);
    }

    /**
     * Get a merged array of default and overriden config
     * @return array
     */
    public function all()
    {
        $defaultConfig = $this->getDefaultConfig();
        $userConfig = array_dot($this->config);

        $config = ($userConfig + $defaultConfig);

        return array_undot($config);
    }
}
