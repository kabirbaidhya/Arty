<?php namespace Gckabir\Arty\Traits;

use Gckabir\Arty\Config\AbstractConfig as Config;
use Gckabir\Arty\Config\PHPConfig;
use Gckabir\Arty\Config\YamlConfig;
use Illuminate\Filesystem\Filesystem;

trait ConfigurableTrait
{
    /**
     * Configuration
     *
     * @var \Gckabir\Arty\Config\AbstractConfig
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
     * Gets config
     * @return \Gckabir\Arty\Config\AbstractConfig
     */
    public function getConfig()
    {
        return $this->config;
    }

    /**
     * Set config from a PHP file
     * @param  string $filename
     * @return $this
     */
    public function configureFromPhp($filename)
    {
        return $this->setConfig(new PHPConfig($filename, new Filesystem()));
    }

    /**
     * Set config from a YAML file
     * @param  string $filename
     * @return $this
     */
    public function configureFromYaml($filename)
    {
        return $this->setConfig(new YamlConfig($filename, new Filesystem()));
    }

    /**
     * Auto detects configuration if any configuration files exists
     * @return $this
     */
    public function autodetectConfig()
    {
        $filesystem = new Filesystem();

        $default = [
            'yaml'  => '.arty.yml',
            'php'   => 'config/arty.php',
        ];

        foreach ($default as $key => $file) {
            if ($filesystem->exists($file)) {
                $this->{'configureFrom'.$key}($file);
                break;
            }
        }

        dump($this->getConfig());

        return $this;
    }
}
