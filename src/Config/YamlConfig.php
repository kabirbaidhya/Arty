<?php namespace Gckabir\Arty\Config;

use Symfony\Component\Yaml\Yaml;

class YamlConfig extends AbstractConfig
{

    public function all()
    {
        $this->config = Yaml::parse($this->getFileContentsSafely());

        return parent::all();
    }
}
