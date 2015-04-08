<?php namespace Gckabir\Arty\Traits;

use Gckabir\Arty\Configuration;
use Symfony\Component\Yaml\Yaml;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Fluent;

trait ConfigurationTrait
{

    protected $configured = false;

    public function configure(array $config = array())
    {
        $configuration = new Configuration();

        $finalConfig = $configuration->all($config);

        $finalConfig = array_dot_once($finalConfig);
        $this->app->instance('config', new Fluent($finalConfig));
        $this->configured = true;

        // After configuration has been loaded other things can boot up
        $this->bootServices();

        return $this;
    }

    public function configureFromYaml($filename = '.arty.yml')
    {
        $fs = new Filesystem();
        $contents = $fs->get($filename);

        $config = Yaml::parse($contents);

        $this->configure($config);

        return $this;
    }
}
