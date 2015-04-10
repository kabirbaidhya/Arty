<?php namespace Gckabir\Arty\Traits;

use RuntimeException;
use Illuminate\Support\Fluent;
use Gckabir\Arty\Configuration;
use Gckabir\Arty\YamlConfiguration;
use Gckabir\Arty\PHPConfiguration;

trait ConfigurationTrait
{

    protected function loadConfiguration()
    {
        if (!($this->config instanceof Configuration)) {
            throw new RuntimeException("Arty hasn't been configured yet");
        }

        // load configuration into the ioc container
        $values = array_dot_once($this->config->all());
        $this->app->instance('config', new Fluent($values));

        return $this;
    }

    private function setConfiguration(Configuration $config)
    {
        $this->config = $config;

        return $this;
    }

    public function configure(array $values)
    {
        return $this->setConfiguration(new Configuration($values));
    }

    public function configureFrom($filename)
    {
        return $this->setConfiguration(new PHPConfiguration($filename));
    }

    public function configureFromYaml($filename = '.arty.yml')
    {
        return $this->setConfiguration(new YamlConfiguration($filename));
    }
}
