<?php namespace Gckabir\Arty\Traits;

use Gckabir\Arty\Config\Config;
use Gckabir\Arty\Config\PHPConfig;
use Gckabir\Arty\Config\YamlConfig;
use Illuminate\Filesystem\Filesystem;

trait ConfigurableTrait
{
    /**
     * Configuration
     *
     * @var \Gckabir\Arty\Config\Config
     */
    protected $config;

    /**
     * Config Setter
     * @param  Config $config
     * @return $this
     */
    protected function setConfig(Config $config)
    {
        $this->config = $config;

        return $this;
    }

    /**
     * Config Getter
     * @return \Gckabir\Arty\Config\Config
     */
    public function getConfig()
    {
        return $this->config;
    }

    /**
     * Set config from raw config values
     * @param  array $values
     * @return $this
     */
    public function configure(array $values)
    {
        return $this->setConfig(new Config($values));
    }

    /**
     * Set config from a php file
     * @param  string $filename
     * @return $this
     */
    public function configureFrom($filename)
    {
        return $this->setConfig(new PHPConfig($filename, new Filesystem()));
    }

    /**
     * Set config from a yaml file
     * @param  string $filename
     * @return $this
     */
    public function configureFromYaml($filename = '.arty.yml')
    {
        return $this->setConfig(new YamlConfig($filename, new Filesystem()));
    }
}
