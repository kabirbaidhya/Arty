<?php namespace Gckabir\Arty\Traits;

use Gckabir\Arty\Configuration;
use Symfony\Component\Yaml\Yaml;
use Illuminate\Filesystem\Filesystem;

trait ConfigureTrait
{
    public function configure(array $config = array())
    {
        $configuration = new Configuration();

        $finalConfig = $configuration->all($config);
        $this->app->instance('config', $finalConfig);
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
