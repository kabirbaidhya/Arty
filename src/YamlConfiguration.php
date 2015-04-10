<?php namespace Gckabir\Arty;

use RuntimeException;
use Illuminate\Filesystem\Filesystem;
use Symfony\Component\Yaml\Yaml;
// use Illuminate\Contracts\Filesystem\FileNotFoundException;

class YamlConfiguration extends Configuration
{

    public function __construct($filename = '.arty.yml')
    {
        if (empty($filename)) {
            throw new RuntimeException("Yaml config file must be supplied");
        }

        $config = $this->getYamlConfigurations($filename);
        parent::__construct($config);
    }

    protected function getYamlConfigurations($path)
    {
        $fs = new Filesystem();

        $contents = $fs->get($path);

        return Yaml::parse($contents);
    }
}
